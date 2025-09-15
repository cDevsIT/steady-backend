<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\Ticket;
use App\Notifications\CommentEmailNotification;
use App\Notifications\TicketEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class TicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticket;
    public $route;
    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket, $route, $user)
    {
        $this->ticket = $ticket;
        $this->route = $route;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;

        $notification = new TicketEmailNotification($this->ticket, $this->route);
        Notification::send($user, $notification);
//        if ($this->ticket->user_id) {
//            Notification::route('mail', $this->ticket->user->emails)->notify($notification);
//        }
    }
}
