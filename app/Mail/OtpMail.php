<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use SerializesModels;

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

        $appName = config('app.name', 'Apex');
        $appUrl = config('app.url', 'http://agrovet.test');

        return new Content(
            htmlString: "
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body {
                            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                            background-color: #f5f5f5;
                            margin: 0;
                            padding: 0;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 40px 20px;
                        }
                        .email-wrapper {
                            background-color: #ffffff;
                            border-radius: 8px;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                            overflow: hidden;
                        }
                        .header {
                            background-color: #2563eb;
                            padding: 30px;
                            text-align: center;
                        }
                        .brand-name {
                            color: #ffffff;
                            font-size: 28px;
                            font-weight: bold;
                            margin: 0;
                        }
                        .content {
                            padding: 40px 30px;
                        }
                        h1 {
                            color: #1f2937;
                            font-size: 24px;
                            margin: 0 0 20px 0;
                        }
                        .otp-box {
                            background-color: #f3f4f6;
                            border: 2px dashed #d1d5db;
                            border-radius: 8px;
                            padding: 20px;
                            text-align: center;
                            margin: 30px 0;
                        }
                        .otp-code {
                            color: #2563eb;
                            font-size: 36px;
                            font-weight: bold;
                            letter-spacing: 4px;
                            margin: 0;
                        }
                        .purpose-text {
                            color: #6b7280;
                            font-size: 14px;
                            margin: 10px 0 0 0;
                        }
                        .expiry-notice {
                            color: #dc2626;
                            font-size: 14px;
                            font-weight: 500;
                            margin: 20px 0 0 0;
                        }
                        .footer {
                            background-color: #f9fafb;
                            padding: 20px 30px;
                            text-align: center;
                            border-top: 1px solid #e5e7eb;
                        }
                        .footer-text {
                            color: #9ca3af;
                            font-size: 12px;
                            margin: 0;
                        }
                        .footer-link {
                            color: #2563eb;
                            text-decoration: none;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='email-wrapper'>
                            <div class='header'>
                                <h2 class='brand-name'>{$appName}</h2>
                            </div>
                            <div class='content'>
                                <h1>Your OTP Code</h1>
                                <p>Your OTP code for {$purposeText} is:</p>
                                <div class='otp-box'>
                                    <p class='otp-code'>{$this->otpCode}</p>
                                    <p class='purpose-text'>For {$purposeText}</p>
                                </div>
                                <p class='expiry-notice'>This code will expire in 10 minutes.</p>
                                <p>If you did not request this code, please ignore this email.</p>
                            </div>
                            <div class='footer'>
                                <p class='footer-text'>
                                    &copy; " . date('Y') . " {$appName}. All rights reserved.<br>
                                    <a href='{$appUrl}' class='footer-link'>{$appUrl}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            ",
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
