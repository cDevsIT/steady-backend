<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
class RegistrationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $user;
    protected $password;
    public function __construct($user,$password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $user = $this->user;
        $password = $this->password;
        $to = $user->email;
        $subject = env("APP_NAME");

        Mail::send('email_templates.registration', compact('user','password'), function ($message) use ( $subject, $to) {
            $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            $message->to($to); //$to
            $message->subject($subject);

        });
    }
}
