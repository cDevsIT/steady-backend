<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $countryCode;
    public $subject;
    public $contactMessage;

    /**
     * Create a new message instance.
     *
     * @param array $contactData
     */
    public function __construct(array $contactData)
    {
        $this->firstName = (string) ($contactData['firstName'] ?? '');
        $this->lastName = (string) ($contactData['lastName'] ?? '');
        $this->email = (string) ($contactData['email'] ?? '');
        $this->phone = (string) ($contactData['phone'] ?? 'N/A');
        $this->countryCode = (string) ($contactData['countryCode'] ?? '+1');
        $this->subject = (string) ($contactData['subject'] ?? 'No Subject');
        $this->contactMessage = (string) ($contactData['message'] ?? 'No message');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact Form Email - ' . $this->subject)
                    ->view('email_templates.contact_form');
    }
}

