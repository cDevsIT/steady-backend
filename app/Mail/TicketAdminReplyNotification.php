<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketAdminReplyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $customerName;
    public $ticketId;
    public $ticketTitle;
    public $ticketStatus;
    public $replyMessage;
    public $hasAttachment;
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
        $this->ticketStatus = (string) ($ticketData['ticketStatus'] ?? 'Open');
        $this->replyMessage = (string) ($ticketData['replyMessage'] ?? '');
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
        return $this->subject('New Reply on Your Support Ticket #' . $this->ticketId)
                    ->view('email_templates.ticket_admin_reply');
    }
}






