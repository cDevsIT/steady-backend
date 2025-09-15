<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $company, $step, $status,$nextStep)
    {
        $this->user = $user;
        $this->step = $step;
        $this->company = $company;
        $this->status = $status;
        $this->nextStep = $nextStep;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $user = $this->user;
        $customer_name = $user->first_name . ' ' . $user->last_name;
        return (new MailMessage)
            ->subject($this->step.' has been successfully completed for ' . $this->company->company_name . ' '. $this->company->business_type)
            ->greeting('Dear ' . $customer_name . ",")
            ->line('We are pleased to inform you that the ' . $this->step . ' has been successfully completed.')
            ->line('Details:')
            ->line('Company Name: ' . $this->company->company_name)
            ->line($this->nextStep ? 'Next Step: ' .  $this->nextStep : '')
            ->line('You can access and download your relevant documents by logging into your dashboard.')
            ->line('👉 Dashboard Login: ' . env("APP_URL") . "/login")
            ->line('Should you have any questions or need further assistance, please do not hesitate to contact us. We are committed to ensuring your satisfaction and supporting your success throughout this process.')
            ->line('👉 To Contact Us: Please submit a support ticket through your dashboard.')
            ->line('👉 Follow Us on Facebook: ' . 'https://www.facebook.com/steadyformation')
            ->line("")
            ->line("")
            ->line("")
            ->line('Warm regards,')
            ->salutation("The Steady Formation Team");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
