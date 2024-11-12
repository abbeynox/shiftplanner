<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendLinksNotification extends Notification
{
    use Queueable;

    private string $editLink;
    private string $subscriberLink;
    private string $title;

    /**
     * Create a new notification instance.
     *
     * @param string $editLink The link to edit the plan
     * @param string $subscriberLink The link o view the pan
     */
    public function __construct(string $title, string $editLink, string $subscriberLink)
    {
        $this->title = $title;
        $this->editLink = $editLink;
        $this->subscriberLink = $subscriberLink;
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
            ->subject(__('plan.linksEmailSubject')." ".$this->title)
            ->line(__('plan.linksEmailSubscribers'))
            ->line($this->subscriberLink)
            ->line(__('plan.linksEmailAdmin'))
            ->action(__('plan.linksEmailEditPlan'), $this->editLink);
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
