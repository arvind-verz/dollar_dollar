<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
      $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Greetings, name')
                    ->line('You are reading this email because we have received a request from you to change your password. Please see your')
                    ->line('To reset your password, you click the button below and follow the instructions stated there.')
                    ->action('Reset Password', route('admin.password.reset', $this->token))
                    ->line('We recommend that you keep your password confidential for extra security measures.');
                    ->line('If you did not make such request, you can ignore this email. We assure you that your account is safe.');
                    ->line('For general enquiries or concerns, you may get in touch with us here. [contact details]');
                    ->line('Have a good day.');
                    ->line('Dollar Dollar');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
