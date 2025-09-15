<?php

namespace App\Jobs;

use App\Notifications\CommentEmailNotification;
use App\Notifications\StatusNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class StatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $step;
    public $company;
    public $status;
    public $nextStep;

    /**
     * Create a new job instance.
     */
    public function __construct($user,$company, $currentStep, $status, $nextStep)
    {
        $this->user = $user;
        $this->step = $currentStep;
        $this->company = $company;
        $this->status = $status;
        $this->nextStep = $nextStep;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;
        $notification = new StatusNotification($user, $this->company,$this->step,$this->status,$this->nextStep);
        Notification::send($user, $notification);
    }
}
