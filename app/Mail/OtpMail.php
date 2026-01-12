<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $otpCode;
    protected $purpose;

    /**
     * Create a new message instance.
     */
    public function __construct($otpCode, $purpose = 'login')
    {
        $this->otpCode = $otpCode;
        $this->purpose = $purpose;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $purposeText = match($this->purpose) {
            'login' => 'login verification',
            'email_verification' => 'email verification',
            'password_reset' => 'password reset',
            'security' => 'security verification',
            'register' => 'registration verification',
            default => 'verification'
        };

        return new Envelope(
            subject: 'Your OTP Code for ' . ucfirst($purposeText),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $purposeText = match($this->purpose) {
            'login' => 'login verification',
            'email_verification' => 'email verification',
            'password_reset' => 'password reset',
            'security' => 'security verification',
            'register' => 'registration verification',
            default => 'verification'
        };

        return new Content(
            htmlString: "
                <h1>Your OTP Code</h1>
                <p>Your OTP code for {$purposeText} is: <strong>{$this->otpCode}</strong></p>
                <p>This code will expire in 10 minutes.</p>
                <p>If you did not request this code, please ignore this email.</p>
            ",
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
