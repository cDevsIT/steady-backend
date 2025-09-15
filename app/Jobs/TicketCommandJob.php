<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Notifications\CommentEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class TicketCommandJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;
    public $route;
    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct(Comment $comment, $route, $user)
    {
        $this->comment = $comment;
        $this->route = $route;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;
        $notification = new CommentEmailNotification($this->comment, $this->route);
        Notification::send($user, $notification);
//        if ($this->comment->user_id) {
//            Notification::route('mail', $this->comment->user->emails)->notify($notification);
//        }
    }
}
