<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\TicketCommandJob;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\CommentEmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        menuSubmenu('tickets', 'tickets' . $request->status);
        $paginate = 30;
        $query = Ticket::orderBy('id', 'DESC')
            ->leftJoin('users', 'users.id', '=', 'tickets.user_id')
            ->where(function ($q) use ($request) {
                if ($request->has('search')) {
                    $q->where('tickets.id', $request->search)
                        ->orWhere('tickets.title', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('users.first_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('users.last_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('users.email', 'LIKE', '%' . $request->search . '%');
                }


            })->where(function ($q) use ($request) {
                if ($request->has('status')) {
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
                'users.phone');

//            ->paginate($paginate);dd($query);

        if ($request->submit_type == 'csv') {
            $tickets = $query->get();
            // Create CSV file content
            $csvData = [];
            $csvData[] = ['ID', 'Created At', 'Title', 'status', 'first_name', 'last_name', 'email', 'phone'];

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

        // Pass the tickets to the view for display
        return view('admin.tickets.index', compact('tickets'))->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    public function show(Ticket $ticket, Request $request)
    {
        $ticket = Ticket::where('tickets.id', $ticket->id)
            ->leftJoin('users', 'users.id', '=', 'tickets.user_id')
            ->select('tickets.id', 'tickets.title', 'tickets.status', 'tickets.content', 'tickets.file_name', 'users.first_name', 'users.last_name', 'users.email', 'users.phone', 'users.role')->first();

        $comments = Comment::where('comments.ticket_id', $ticket->id)
            ->leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.id', 'comments.comment_text', 'comments.created_at', 'comments.attachment', 'users.first_name', 'users.last_name', 'users.email', 'users.phone', 'users.role')
            ->orderBy('comments.id', 'ASC')->get();
        return view('admin.tickets.view', compact('ticket', 'comments'));
    }

    public function store(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);
        $comment = new Comment;
        $comment->comment_text = $request->comment_text;
        $comment->ticket_id = $ticket->id;
        $comment->user_id = Auth::id();
        if ($request->hasFile('attachment')) {
            $thumbnail_path = 'uploads/tickets/comment';
            if (!Storage::disk('public')->directoryExists($thumbnail_path)) {
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

        }
        $comment->save();
        $ticket->status = $request->status;
        $ticket->save();
//        $user = User::find($ticket->user_id);
//        $route = route('web.viewTicket', $ticket);
//        TicketCommandJob::dispatch($comment, $route, $user);
        return redirect()->back()->with('success', 'Comment successfully. Done');
    }
}
