<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreatedByAdminAdminConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $ticketId;
    public $customerName;
    public $companyName;
    public $ticketTitle;
    public $ticketStatus;
    public $ticketUrl;

    /**
     * Create a new message instance.
     *
     * @param array $ticketData
     */
    public function __construct(array $ticketData)
    {
        $this->ticketId = (string) ($ticketData['ticketId'] ?? '');
        $this->customerName = (string) ($ticketData['customerName'] ?? '');
        $this->companyName = (string) ($ticketData['companyName'] ?? '');
        $this->ticketTitle = (string) ($ticketData['ticketTitle'] ?? '');
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
        return $this->subject('Ticket Created Successfully - #' . $this->ticketId)
                    ->view('email_templates.ticket_created_by_admin_admin');
    }
}

