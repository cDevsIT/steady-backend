<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketClosedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $customerName;
    public $ticketId;
    public $ticketTitle;
    public $closingMessage;
    public $ticketUrl;

    /**
     * Create a new message instance.
     *
     * @param array $ticketData
     */
    public function __construct(array $ticketData)
    {
        $this->customerName = (string) ($ticketData['customerName'] ?? '');
        $this->ticketId = (string) ($ticketData['ticketId'] ?? '');
        $this->ticketTitle = (string) ($ticketData['ticketTitle'] ?? '');
        $this->closingMessage = (string) ($ticketData['closingMessage'] ?? '');
        $this->ticketUrl = (string) ($ticketData['ticketUrl'] ?? '');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Support Ticket Closed - #' . $this->ticketId)
                    ->view('email_templates.ticket_closed');
    }
}

