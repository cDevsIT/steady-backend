<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreatedByAdminClientNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $customerName;
    public $ticketId;
    public $ticketTitle;
    public $ticketContent;
    public $ticketStatus;
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
        $this->ticketContent = (string) ($ticketData['ticketContent'] ?? '');
        $this->ticketStatus = (string) ($ticketData['ticketStatus'] ?? 'Open');
        $this->ticketUrl = (string) ($ticketData['ticketUrl'] ?? '');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Support Ticket - #' . $this->ticketId)
                    ->view('email_templates.ticket_created_by_admin_client');
    }
}

