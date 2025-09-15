<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TicketEmailNotification extends Notification
{
    use Queueable;

    public function __construct($ticket, $route)
    {
        $this->ticket = $ticket;
        $this->route = $route;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage =  (new MailMessage)
            ->subject('New Ticket: ' . $this->ticket->title)
            ->greeting('Hi,')
            ->line('New Ticket: ' . $this->ticket->title)
            ->line('')
            ->line(Str::limit($this->ticket->content, 500))
            ->action('View full ticket', $this->route)
            ->line('Thank you')
            ->line(config('app.name') . ' Team')
            ->salutation(' ');

        if (!empty($this->ticket->file_name)) {
            $mailMessage->attach(storage_path('app/public/' . $this->ticket->file_name));
        }

        return $mailMessage;
    }
}
