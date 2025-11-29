<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $lastName;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param array $contactData
     */
    public function __construct(array $contactData)
    {
        $this->firstName = (string) ($contactData['firstName'] ?? '');
        $this->lastName = (string) ($contactData['lastName'] ?? '');
        $this->subject = (string) ($contactData['subject'] ?? 'Contact Form');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thank You for Contacting Steady Formation')
                    ->view('email_templates.contact_confirmation');
    }
}

