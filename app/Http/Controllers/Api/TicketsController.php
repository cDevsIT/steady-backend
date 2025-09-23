<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TicketsController extends Controller
{
    /**
     * Get user's tickets with pagination
     */
    public function getUserTickets(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated',
                    'data' => null
                ], 401);
            }

            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            $search = $request->get('search', '');
            $status = $request->get('status', '');

            $query = Ticket::where('user_id', $user->id)
                ->with(['user:id,first_name,last_name,email,phone'])
                ->orderBy('created_at', 'desc');

            // Apply search filter
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhere('content', 'LIKE', '%' . $search . '%');
                });
            }

            // Apply status filter
            if (!empty($status)) {
                $query->where('status', $status);
            }

            $tickets = $query->paginate($perPage, ['*'], 'page', $page);

            // Transform the data to match frontend expectations
            $transformedTickets = $tickets->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'user' => '#' . str_pad($ticket->id, 6, '0', STR_PAD_LEFT),
                    'avatar' => $ticket->user ? asset('assets/images/dummy.jpeg') : '',
                    'name' => $ticket->user ? $ticket->user->first_name . ' ' . $ticket->user->last_name : 'Unknown',
                    'subject' => $ticket->title,
                    'submitted' => $ticket->created_at ? \Carbon\Carbon::parse($ticket->created_at)->format('M d, Y') : '',
                    'updated' => $ticket->updated_at ? \Carbon\Carbon::parse($ticket->updated_at)->format('M d, Y') : '',
                    'assignee' => 'Support Team',
                    'status' => $ticket->status,
                    'priority' => $this->getPriorityFromStatus($ticket->status),
                    'content' => $ticket->content,
                    'file_name' => $ticket->file_name,
                    'file_url' => $ticket->file_name ? asset('storage/' . $ticket->file_name) : null,
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Tickets retrieved successfully',
                'data' => [
                    'tickets' => $transformedTickets,
                    'pagination' => [
                        'current_page' => $tickets->currentPage(),
                        'last_page' => $tickets->lastPage(),
                        'per_page' => $tickets->perPage(),
                        'total' => $tickets->total(),
                        'from' => $tickets->firstItem(),
                        'to' => $tickets->lastItem(),
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error retrieving tickets: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Get single ticket with comments
     */
    public function getTicket(Request $request, $ticketId)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated',
                    'data' => null
                ], 401);
            }

            $ticket = Ticket::where('id', $ticketId)
                ->where('user_id', $user->id)
                ->with(['user:id,first_name,last_name,email,phone', 'comments.user:id,first_name,last_name,email,role'])
                ->first();

            if (!$ticket) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ticket not found',
                    'data' => null
                ], 404);
            }

            // Transform ticket data
            $transformedTicket = [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'content' => $ticket->content,
                'status' => $ticket->status,
                'file_name' => $ticket->file_name,
                'file_url' => $ticket->file_name ? asset('storage/' . $ticket->file_name) : null,
                'created_at' => $ticket->created_at,
                'updated_at' => $ticket->updated_at,
                'user' => $ticket->user ? [
                    'id' => $ticket->user->id,
                    'name' => $ticket->user->first_name . ' ' . $ticket->user->last_name,
                    'email' => $ticket->user->email,
                    'phone' => $ticket->user->phone,
                ] : null,
                'comments' => $ticket->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'comment_text' => $comment->comment_text,
                        'attachment' => $comment->attachment,
                        'file_name' => $comment->file_name,
                        'file_url' => $comment->attachment ? asset('storage/' . $comment->attachment) : null,
                        'created_at' => $comment->created_at,
                        'user' => $comment->user ? [
                            'id' => $comment->user->id,
                            'name' => $comment->user->first_name . ' ' . $comment->user->last_name,
                            'email' => $comment->user->email,
                            'role' => $comment->user->role,
                        ] : null,
                    ];
                }),
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Ticket retrieved successfully',
                'data' => $transformedTicket
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error retrieving ticket: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Create a new ticket
     */
    public function createTicket(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated',
                    'data' => null
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'attachment' => 'sometimes|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:10240', // 10MB max
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'data' => $validator->errors()
                ], 422);
            }

            $ticket = new Ticket();
            $ticket->title = $request->title;
            $ticket->content = $request->content;
            $ticket->user_id = $user->id;
            $ticket->status = 'Open';

            // Handle file upload
            if ($request->hasFile('attachment')) {
                $thumbnail_path = 'uploads/tickets';
                if (!Storage::disk('public')->directoryExists($thumbnail_path)) {
                    Storage::disk('public')->makeDirectory($thumbnail_path);
                }
                
                $file = $request->file('attachment');
                $filenameWithExt = $file->getClientOriginalName();
                $generate_name = time() . '_' . $filenameWithExt;
                $fileNameToStore = $thumbnail_path . "/" . $generate_name;

                Storage::disk("public")->put($fileNameToStore, file_get_contents($request->file('attachment')));
                $ticket->file_name = $fileNameToStore;
            }

            $ticket->save();

            // Load the created ticket with user data
            $ticket->load('user:id,first_name,last_name,email,phone');

            return response()->json([
                'status' => 'success',
                'message' => 'Ticket created successfully',
                'data' => [
                    'id' => $ticket->id,
                    'title' => $ticket->title,
                    'content' => $ticket->content,
                    'status' => $ticket->status,
                    'file_name' => $ticket->file_name,
                    'file_url' => $ticket->file_name ? asset('storage/' . $ticket->file_name) : null,
                    'created_at' => $ticket->created_at,
                    'user' => $ticket->user ? [
                        'id' => $ticket->user->id,
                        'name' => $ticket->user->first_name . ' ' . $ticket->user->last_name,
                        'email' => $ticket->user->email,
                        'phone' => $ticket->user->phone,
                    ] : null,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating ticket: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Add comment to ticket
     */
    public function addComment(Request $request, $ticketId)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated',
                    'data' => null
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'comment_text' => 'required|string',
                'attachment' => 'sometimes|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:10240', // 10MB max
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'data' => $validator->errors()
                ], 422);
            }

            // Check if ticket exists and belongs to user
            $ticket = Ticket::where('id', $ticketId)
                ->where('user_id', $user->id)
                ->first();

            if (!$ticket) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ticket not found',
                    'data' => null
                ], 404);
            }

            $comment = new Comment();
            $comment->comment_text = $request->comment_text;
            $comment->ticket_id = $ticket->id;
            $comment->user_id = $user->id;

            // Handle file upload
            if ($request->hasFile('attachment')) {
                $thumbnail_path = 'uploads/tickets/comment';
                if (!Storage::disk('public')->directoryExists($thumbnail_path)) {
                    Storage::disk('public')->makeDirectory($thumbnail_path);
                }
                
                $file = $request->file('attachment');
                $filenameWithExt = $file->getClientOriginalName();
                $generate_name = time() . '_' . $filenameWithExt;
                $fileNameToStore = $thumbnail_path . "/" . $generate_name;

                Storage::disk("public")->put($fileNameToStore, file_get_contents($request->file('attachment')));
                $comment->attachment = $fileNameToStore;
            }

            $comment->save();

            // If ticket status is 'admin_ticket' and client is replying, change to 'Open'
            if ($ticket->status === 'admin_ticket' && $user->role === 2) {
                $ticket->status = 'Open';
                $ticket->save();
            }

            // Load the created comment with user data
            $comment->load('user:id,first_name,last_name,email,role');

            return response()->json([
                'status' => 'success',
                'message' => 'Comment added successfully',
                'data' => [
                    'id' => $comment->id,
                    'comment_text' => $comment->comment_text,
                    'attachment' => $comment->attachment,
                    'file_name' => $comment->file_name,
                    'file_url' => $comment->attachment ? asset('storage/' . $comment->attachment) : null,
                    'created_at' => $comment->created_at,
                    'user' => $comment->user ? [
                        'id' => $comment->user->id,
                        'name' => $comment->user->first_name . ' ' . $comment->user->last_name,
                        'email' => $comment->user->email,
                        'role' => $comment->user->role,
                    ] : null,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error adding comment: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Download ticket attachment
     */
    public function downloadAttachment($ticketId, $type = 'ticket')
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated',
                    'data' => null
                ], 401);
            }

            if ($type === 'ticket') {
                $ticket = Ticket::where('id', $ticketId)
                    ->where('user_id', $user->id)
                    ->first();

                if (!$ticket || !$ticket->file_name) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'File not found',
                        'data' => null
                    ], 404);
                }

                $filePath = storage_path('app/public/' . $ticket->file_name);
                if (!file_exists($filePath)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'File not found on server',
                        'data' => null
                    ], 404);
                }

                return response()->download($filePath, basename($ticket->file_name));
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid download type',
                'data' => null
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error downloading file: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Download comment attachment
     */
    public function downloadCommentAttachment($commentId)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated',
                    'data' => null
                ], 401);
            }

            $comment = Comment::where('id', $commentId)
                ->whereHas('ticket', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->first();

            if (!$comment || !$comment->attachment) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File not found',
                    'data' => null
                ], 404);
            }

            $filePath = storage_path('app/public/' . $comment->attachment);
            if (!file_exists($filePath)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File not found on server',
                    'data' => null
                ], 404);
            }

            return response()->download($filePath, basename($comment->attachment));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error downloading file: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Helper method to determine priority based on status
     */
    private function getPriorityFromStatus($status)
    {
        switch ($status) {
            case 'Open':
                return 'High';
            case 'In Progress':
                return 'Medium';
            case 'Closed':
                return 'Low';
            default:
                return 'Medium';
        }
    }
}
