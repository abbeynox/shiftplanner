<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendShiftReminder extends Notification
{
    use Queueable;

    private string $planLink;
    private string $shifts;

    /**
     * Create a new notification instance.
     *
     */
    public function __construct(string $planLink, string $shifts, string $locale)
    {
        $this->planLink = $planLink;
        $this->shifts = $shifts;
        app()->setLocale($locale);
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
            ->subject(__('subscription.reminder'))
            ->line(__('subscription.reminderBody'))
            ->line($this->shifts)
            ->action(__('plan.linksEmailPlan'), $this->planLink);
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
