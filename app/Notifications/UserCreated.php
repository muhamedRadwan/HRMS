<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCreated extends Notification 
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
                    ->subject(__('master.your_email_created'))
                    ->greeting(__('master.Hello', ["name" => $notifiable->name]))
                    ->line(__("master.Congratulations_your_account_created_successfully"))
                    ->action(__('master.Login_now'), url('/login'))
                    ->line(__('master.Email_user', ['email' => $notifiable->email] ))
                    ->line(__('master.Passowrd_user', ['password' => $notifiable->password]))
                    ->line(__('master.you_will_found_attached_file_with_qrcode_for_quick_attendance_and_leave'))
                    ->attach(base_path("public/qrcodes/". $notifiable->token . '.png'));
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
