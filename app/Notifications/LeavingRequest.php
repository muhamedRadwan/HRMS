<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeavingRequest extends Notification
{
    use Queueable;

    protected $leaveReuest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($leaveReuest)
    {
        //
        $this->leaveReuest = $leaveReuest;
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
        if($this->leaveReuest->status == 0) //Notify Admin
            return  (new MailMessage)
                        ->subject(__("master.leave_request"))
                        ->greeting(__("master.hello"))
                        ->line(__("master.there_is_new_leaving_request"))
                        ->action(__("master.see_now"), route("leaverequests.edit", $this->leaveReuest->id))
                        ->line(__("master.thank_you"));
        else if($this->leaveReuest->status == 1) // Aproved
            return  (new MailMessage)
                        ->subject(__("master.leave_request"))
                        ->greeting(__("master.hello"))
                        ->line(__("master.your_request_is_approved"))
                        ->action(__("master.see_now"), route("leaverequests.index"))
                        ->line(__("master.thank_you"))
                        ->success();
                        
        else if($this->leaveReuest->status == 2) // Dis Approve
        return  (new MailMessage)
                    ->subject(__("master.leave_request"))
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
