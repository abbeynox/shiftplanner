<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendAllLinksNotification extends Notification
{
    use Queueable;

    private array $links;

    /**
     * Create a new notification instance.
     *
     */
    public function __construct(array $links)
    {
        $this->links = $links;
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
        $msg = (new MailMessage)
            ->subject(__('plan.allLinksEmailSubject'))
            ->line(__('plan.allLinksEmail'));
        foreach ($this->links as $l) {
            $msg = $msg->line($l[0] . ':')
                        ->action(__('plan.linksEmailPlan'), $l[1]);
        }
        return $msg;
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
