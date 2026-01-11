<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $otpCode;
    protected $purpose;

    /**
     * Create a new notification instance.
     */
    public function __construct($otpCode, $purpose = 'login')
    {
        $this->otpCode = $otpCode;
        $this->purpose = $purpose;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $purposeText = match($this->purpose) {
            'login' => 'login verification',
            'email_verification' => 'email verification',
            'password_reset' => 'password reset',
            'security' => 'security verification',
            default => 'verification'
        };

        return (new MailMessage)
                    ->subject('Your OTP Code for ' . ucfirst($purposeText))
                    ->line('Your OTP code for ' . $purposeText . ' is: ' . $this->otpCode)
                    ->line('This code will expire in 10 minutes.')
                    ->line('If you did not request this code, please ignore this email.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'otp_code' => $this->otpCode,
        ];
    }
}
