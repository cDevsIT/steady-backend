<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OwnersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $owner;
    protected $history;

    public function __construct($owner, $history)
    {
        $this->owner = $owner;
        $this->history = $history;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $owner = $this->owner;
        $history = $this->history;
        $to = $owner->email;

        try {
            Mail::send('email_templates.owner_email', compact('history', 'owner'), function ($message) use ($history, $to) {
                $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                $message->to($to); //$to
                $message->subject($history->subject);
                $history->status_at =  now();
                $history->status = 'success';
                $history->save();

            });
        }catch (\Exception $e){
            $history->status_at =  now();
            $history->status = 'rejected';
            $history->error = $e->getMessage();
            $history->save();
        }
    }
}
