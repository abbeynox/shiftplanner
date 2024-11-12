<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\Shift;
use App\Models\Subscription;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class SubscriptionPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Plan  $plan
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Plan $plan, Subscription $subscription)
    {
        return $subscription->shift->plan->id === $plan->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Plan  $plan
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Plan $plan, Subscription $subscription)
    {
        return $subscription->shift->plan->id === $plan->id;
    }
}
