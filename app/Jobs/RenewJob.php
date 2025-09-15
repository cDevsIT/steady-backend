<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\RenewalHistory;
use App\Models\Transition;
use App\Notifications\CommentEmailNotification;
use App\Notifications\RenewEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class RenewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $transition;
    public $route;
    public $user;
    public $history;

    /**
     * Create a new job instance.
     */
    public function __construct(Transition $transition, $route, $user, $history)
    {
        $this->transition = $transition;
        $this->route = $route;
        $this->user = $user;
        $this->history = $history;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;
        $customer_name = $user->first_name ." ". $user->last_name;
        $notification = new RenewEmailNotification($this->transition, $this->route,$this->history,$customer_name);
        Notification::send($user, $notification);
    }
}
