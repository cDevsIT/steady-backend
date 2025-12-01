<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\TicketCommandJob;
use App\Mail\TicketAdminReplyNotification;
use App\Mail\TicketClosedNotification;
use App\Mail\TicketCreatedByAdminAdminConfirmation;
use App\Mail\TicketCreatedByAdminClientNotification;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\CommentEmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        // Set appropriate menu selection based on request parameters
        if ($request->has('create') && $request->create == '1') {
            menuSubmenu('tickets', 'ticketsCreate');
        } elseif ($request->status == 'admin_ticket') {
            menuSubmenu('tickets', 'ticketsAdmin');
        } else {
            menuSubmenu('tickets', 'tickets' . $request->status);
        }
        $paginate = 30;
        $query = Ticket::orderBy('id', 'DESC')
            ->leftJoin('users', 'users.id', '=', 'tickets.user_id')
            ->leftJoin('companies', 'companies.id', '=', 'tickets.company_id')
            ->where(function ($q) use ($request) {
                if ($request->filled('search')) {
                    $q->where('tickets.id', $request->search)
                        ->orWhere('tickets.title', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('users.first_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('users.last_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('users.email', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('companies.company_name', 'LIKE', '%' . $request->search . '%');
                }


            })->where(function ($q) use ($request) {
                if ($request->filled('status')) {
                    $q->where('tickets.status', $request->status);
                }

                if ($request->from_date && $request->to_date) {
                    $startDate = Carbon::parse($request->from_date)->startOfDay();
                    $endDate = Carbon::parse($request->to_date)->startOfDay();
                    $q->whereBetween('tickets.created_at', [$startDate, $endDate]);
                } elseif ($request->from_date) {
                    $startDate = Carbon::parse($request->from_date)->startOfDay();
                    $q->whereDate('tickets.created_at', $startDate);
                }
            })
            ->select(
                'tickets.created_at',
                'tickets.id',
                'tickets.title',
                'tickets.file_name',
                'tickets.status',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone',
                'companies.company_name');

//            ->paginate($paginate);dd($query);

        if ($request->submit_type == 'csv') {
            $tickets = $query->get();
            // Create CSV file content
            $csvData = [];
            $csvData[] = ['ID', 'Created At', 'Title', 'status', 'first_name', 'last_name', 'email', 'phone', 'company_name'];

            foreach ($tickets as $ticket) {
                $csvData[] = [
                    $ticket->id,
                    $ticket->created_at,
                    $ticket->title,
                    $ticket->status == "Close" ? "Closed" : $ticket->status,
                    $ticket->first_name,
                    $ticket->last_name,
                    $ticket->email,
                    $ticket->phone,
                    $ticket->company_name,

                ];
            }

            // Generate CSV file

            $filename = $request->status . "_tickets_" . date('Y-m-d_H-i-s') . ".csv";
            if ($request->daterange) {
                $filename = $request->status . "_tickets_" . $request->daterange . ".csv";
            }

            $fileContent = '';
            foreach ($csvData as $row) {
                $fileContent .= implode(",", $row) . "\n";
            }

            // Return response as a download
            return Response::make($fileContent, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        $tickets = $query->paginate($paginate);

        // Calculate summary statistics
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'Open')->count();
        $closedTickets = Ticket::whereIn('status', ['Close', 'Closed'])->count(); // Keep both for backward compatibility
        $uniqueCustomers = Ticket::distinct('user_id')->count('user_id');

        // Pass the tickets and statistics to the view for display
        return view('admin.tickets.index', compact('tickets', 'totalTickets', 'openTickets', 'closedTickets', 'uniqueCustomers'))->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    public function show(Ticket $ticket, Request $request)
    {
        $ticket = Ticket::where('tickets.id', $ticket->id)
            ->leftJoin('users', 'users.id', '=', 'tickets.user_id')
            ->leftJoin('companies', 'companies.id', '=', 'tickets.company_id')
            ->select(
                'tickets.id',
                'tickets.title',
                'tickets.status',
                'tickets.content',
                'tickets.file_name',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone',
                'users.role',
                'companies.company_name'
            )->first();

        $comments = Comment::where('comments.ticket_id', $ticket->id)
            ->leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.id', 'comments.comment_text', 'comments.created_at', 'comments.attachment', 'users.first_name', 'users.last_name', 'users.email', 'users.phone', 'users.role')
            ->orderBy('comments.id', 'ASC')->get();
        return view('admin.tickets.view', compact('ticket', 'comments'));
    }

    public function store(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);
        
        // Store old status to check if ticket was just closed
        $oldStatus = $ticket->status;
        
        // Load ticket with user and company data
        $ticket->load(['user:id,first_name,last_name,email,phone', 'company:id,company_name']);
        
        $comment = new Comment;
        $comment->comment_text = $request->comment_text;
        $comment->ticket_id = $ticket->id;
        $comment->user_id = Auth::id();
        
        $hasAttachment = false;
        if ($request->hasFile('attachment')) {
            $thumbnail_path = 'uploads/tickets/comment';
            if (!Storage::disk('public')->exists($thumbnail_path)) {
                Storage::disk('public')->makeDirectory($thumbnail_path);
            }
            $file = $request->file('attachment');
            $filenameWithExt = $file->getClientOriginalName();
            $generate_name = time() . $filenameWithExt;
            $fileNameToStore = $thumbnail_path . "/" . $generate_name;
            $file_with_path = 'uploads/tickets/comment' . $generate_name;

            Storage::disk("public")->put($fileNameToStore, file_get_contents($request->file('attachment')));
            $filePath = url(Storage::url($fileNameToStore));

            $comment->attachment = $fileNameToStore;
            $hasAttachment = true;
        }
        
        $comment->save();
        
        // Standardize status values - always save as 'Close' (without 'd') for consistency
        $status = $request->status;
        if ($status === 'Closed') {
            $status = 'Close';
        }
        $ticket->status = $status;
        $ticket->save();
        
        // Check if ticket was just closed
        $wasJustClosed = ($oldStatus !== 'Close' && $status === 'Close');
        
        // Get current user (admin)
        $currentUser = Auth::user();
        $isAdmin = $currentUser && $currentUser->role == 1;
        
        // Send emails (don't fail if email fails)
        try {
            $customer = $ticket->user;
            if ($customer && $customer->email) {
                $customerName = $customer->first_name . ' ' . $customer->last_name;
                $clientTicketUrl = url('/client/support-help/' . $ticket->id);
                
                // If admin replied, send reply notification
                if ($isAdmin && !empty($request->comment_text)) {
                    Mail::to($customer->email)->send(new TicketAdminReplyNotification([
                        'customerName' => $customerName,
                        'ticketId' => $ticket->id,
                        'ticketTitle' => $ticket->title,
                        'ticketStatus' => $ticket->status,
                        'replyMessage' => $request->comment_text,
                        'hasAttachment' => $hasAttachment,
                        'ticketUrl' => $clientTicketUrl,
                    ]));
                }
                
                // If ticket was just closed, send closed notification
                if ($wasJustClosed) {
                    Mail::to($customer->email)->send(new TicketClosedNotification([
                        'customerName' => $customerName,
                        'ticketId' => $ticket->id,
                        'ticketTitle' => $ticket->title,
                        'closingMessage' => $request->comment_text ?: 'Your ticket has been closed by our support team.',
                        'ticketUrl' => $clientTicketUrl,
                    ]));
                }
            }
        } catch (\Exception $emailError) {
            // Log email error but don't fail the request
            \Log::error('Failed to send ticket reply/closed emails: ' . $emailError->getMessage());
            \Log::error('Email error trace: ' . $emailError->getTraceAsString());
        }
        
        return redirect()->back()->with('success', 'Comment successfully. Done');
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'nullable|in:Open,Closed,admin_ticket',
            'user_id' => 'nullable|exists:users,id',
            'attachment' => 'nullable|file|max:5120',
        ]);

        $company = Company::findOrFail($request->company_id);
        $userId = $request->user_id ?: $company->user_id;

        $ticket = new Ticket();
        $ticket->title = $request->title;
        $ticket->content = $request->content;
        $ticket->status = $request->status === 'Closed' ? 'Close' : ($request->status ?: 'admin_ticket');
        $ticket->user_id = $userId;
        $ticket->company_id = $company->id;

        if ($request->hasFile('attachment')) {
            $thumbnail_path = 'uploads/tickets';
            if (!Storage::disk('public')->exists($thumbnail_path)) {
                Storage::disk('public')->makeDirectory($thumbnail_path);
            }
            $file = $request->file('attachment');
            $filenameWithExt = $file->getClientOriginalName();
            $generate_name = time() . $filenameWithExt;
            $fileNameToStore = $thumbnail_path . "/" . $generate_name;
            Storage::disk("public")->put($fileNameToStore, file_get_contents($file));
            $ticket->file_name = $fileNameToStore;
        }

        $ticket->save();

        // Load ticket with user and company data
        $ticket->load(['user:id,first_name,last_name,email,phone', 'company:id,company_name']);

        // Send emails (don't fail if email fails)
        try {
            $adminEmail = env('ADMIN_EMAIL', 'info@steadyformation.com');
            $customer = $ticket->user;
            $customerName = $customer ? ($customer->first_name . ' ' . $customer->last_name) : 'Customer';
            $customerEmail = $customer->email ?? '';
            $companyName = $ticket->company ? $ticket->company->company_name : '';
            
            // Admin ticket URL
            $adminTicketUrl = route('tickets.show', $ticket->id);
            
            // Client ticket URL (frontend - adjust based on your frontend route)
            $clientTicketUrl = url('/client/support-help/' . $ticket->id);

            // Send confirmation email to admin
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new TicketCreatedByAdminAdminConfirmation([
                    'ticketId' => $ticket->id,
                    'customerName' => $customerName,
                    'companyName' => $companyName,
                    'ticketTitle' => $ticket->title,
                    'ticketStatus' => $ticket->status,
                    'ticketUrl' => $adminTicketUrl,
                ]));
            }

            // Send notification email to client
            if ($customerEmail) {
                Mail::to($customerEmail)->send(new TicketCreatedByAdminClientNotification([
                    'customerName' => $customerName,
                    'ticketId' => $ticket->id,
                    'ticketTitle' => $ticket->title,
                    'ticketContent' => $ticket->content,
                    'ticketStatus' => $ticket->status,
                    'ticketUrl' => $clientTicketUrl,
                ]));
            }
        } catch (\Exception $emailError) {
            // Log email error but don't fail the request
            \Log::error('Failed to send admin ticket creation emails: ' . $emailError->getMessage());
            \Log::error('Email error trace: ' . $emailError->getTraceAsString());
        }

        return redirect()->route('tickets.index', ['status' => 'admin_ticket'])->with('success', 'Ticket created successfully.');
    }
}
