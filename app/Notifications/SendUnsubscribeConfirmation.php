<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendUnsubscribeConfirmation extends Notification
{
    use Queueable;

    private string $unsubscribeLink;
    private string $title;

    /**
     * Create a new notification instance.
     *
     */
    public function __construct(string $unsubscribeLink)
    {
        $this->unsubscribeLink = $unsubscribeLink;
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
            ->subject(__('subscription.unsubscribeConfirmation'))
            ->line(__('subscription.confirmUnsubscribe'))
            ->action(__('subscription.unsubscribe'), $this->unsubscribeLink)
            ->line(__('subscription.confirmUnsubscribeEnd'));
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
