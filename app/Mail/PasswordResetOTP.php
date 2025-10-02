<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetOTP extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $userName;
    public $expiresIn;

    /**
     * Create a new message instance.
     */
    public function __construct($otp, $userName, $expiresIn = 10)
    {
        $this->otp = $otp;
        $this->userName = $userName;
        $this->expiresIn = $expiresIn;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Reset - Verification Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email_templates.password-reset-otp',
            with: [
                'otp' => $this->otp,
                'userName' => $this->userName,
                'expiresIn' => $this->expiresIn,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}