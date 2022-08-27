<?php

namespace App\Notifications\v1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    /**
     * @var Model
     */
    private Model $user;
    /**
     * @var string
     */
    private string $resetCode;


    /**
     * @param $user
     * @param $resetCode
     */
    public function __construct($user, $resetCode)
    {
        //
        $this->user = $user;
        $this->resetCode = $resetCode;
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
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Reset password")
            ->line("Dear {$this->user->name}\nyou can reset your password by clicking on the link below:")
            ->action('click to reset your password', url("/auth/rest-password?action={$this->resetCode}"))
            ->line('Thank you!');
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
