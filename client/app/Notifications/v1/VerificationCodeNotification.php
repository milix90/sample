<?php

namespace App\Notifications\v1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationCodeNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    private string $code;


    /**
     * @param $verificationCode
     */
    public function __construct($verificationCode)
    {
        $this->code = $verificationCode;
    }


    /**
     * @param $notifiable
     * @return string[]
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }


    /**
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $ttl = floor(((int)config('redis.ttl.verify')) / 60);

        return (new MailMessage)
            ->subject("account verification")
            ->line("Click on the link below to verify your account.\nIt will expire in the next $ttl minute(s).")
            ->action('Click here to verify', url('/auth/verify?action=') . $this->code)
            ->line("Thank you!");
    }


    /**
     * @param $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
