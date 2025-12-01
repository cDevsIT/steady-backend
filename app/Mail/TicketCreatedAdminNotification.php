<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreatedAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ticketId;
    public $customerName;
    public $customerEmail;
    public $customerPhone;
    public $companyName;
    public $ticketTitle;
    public $ticketContent;
    public $ticketStatus;
    public $createdAt;
    public $hasAttachment;
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
        $this->customerEmail = (string) ($ticketData['customerEmail'] ?? '');
        $this->customerPhone = (string) ($ticketData['customerPhone'] ?? '');
        $this->companyName = (string) ($ticketData['companyName'] ?? '');
        $this->ticketTitle = (string) ($ticketData['ticketTitle'] ?? '');
        $this->ticketContent = (string) ($ticketData['ticketContent'] ?? '');
        $this->ticketStatus = (string) ($ticketData['ticketStatus'] ?? 'Open');
        $this->createdAt = (string) ($ticketData['createdAt'] ?? '');
        $this->hasAttachment = (bool) ($ticketData['hasAttachment'] ?? false);
        $this->ticketUrl = (string) ($ticketData['ticketUrl'] ?? '');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Support Ticket Created - #' . $this->ticketId)
                    ->view('email_templates.ticket_created_admin');
    }
}

