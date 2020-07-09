<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeavingRequest extends Notification
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
        if($notifiable->status == 0) //Notify Admin
            return  (new MailMessage)
                        ->subject(__("master.leave_request"))
                        ->greeting(__("master.hello"))
                        ->line(__("master.there_is_new_leaving_request"))
                        ->action(__("master.see_now"), route("leaverequests.edit", $notifiable->id))
                        ->line(__("master.thank_you"));
        else if($notifiable->status == 1) // Aproved
            return  (new MailMessage)
                        ->greeting(__("master.hello"))
                        ->line(__("master.your_request_is_approved"))
                        ->action(__("master.see_now"), route("leaverequests.index"))
                        ->line(__("master.thank_you"))
                        ->success();
                        
        else if($notifiable->status == 2) // Dis Approve
        return  (new MailMessage)
                    ->greeting(__("master.hello"))
                    ->line(__("master.your_request_is_disapproved"))
                    ->action(__("master.see_now"), route("leaverequests.index"))
                    ->line(__("master.thank_you"))
                    ->error();
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
