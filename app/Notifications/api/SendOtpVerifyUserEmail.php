<?php

namespace App\Notifications\api;

use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpVerifyUserEmail extends Notification
{
    use Queueable;

    public $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }


    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $otp = $this->otp->generate($notifiable->email , 'numeric' , 5 , 40);
        return (new MailMessage)
                    ->greeting('Otp Code')
                    ->line('Email Verification Code .')
                    ->line('Code : '.$otp->token );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
