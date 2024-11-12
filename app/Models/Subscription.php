<?php

namespace App\Models;

use App\Notifications\SendUnsubscribeConfirmation;
use App\Notifications\SendShiftReminder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'comment',
        'notification',
        'locale'
    ];

    /**
     * Export a subscription
     */
    public function export() {
        return ['subscribed','','','','','','','', $this->name, $this->phone,
          $this->email, $this->comment, $this->notification, $this->locale];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'phone',
        'email',
        'comment',
        'confirmation',
        'locale'
    ];

    /**
     * Subscription belongs to a shift
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shift() {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Send an unsubscribe Email
     */
    public function sendUnsubscribeConfirmation() {
        $this->confirmation = Str::random(24);
        $this->save();
        $link = route('plan.subscription.confirmRemove', [
            'plan' => $this->shift->plan,
            'shift' => $this->shift,
            'confirmation' => $this->confirmation]);
        $this->notify(new SendUnsubscribeConfirmation($link));
    }

    /**
     * Send a reminder email
     * todo: merge with command logic
     */
    public function sendReminder() {
        $plan = $this->shift->plan;
        $viewLink = route('plan.show', ['plan' => $plan->view_id]);
        $summary = [];
        // send only one email for all shifts an email subscribed
        foreach ($plan->shifts as $shift) {
            foreach ($shift->subscriptions as $sub) {
                if ($sub->email == $this->email) {
                    $summary[] = $shift->title . ': '. 
                        explode(' ', $shift->start)[1].' - '.
                        explode(' ', $shift->end)[1];
                    break;
                }
            }
        }
        $this->notify(new SendShiftReminder($viewLink, join(', ', $summary), $this->locale ));
    }
}
