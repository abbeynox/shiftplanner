<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\Shift;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ShiftPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create a shit.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Plan $plan)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Plan $userPlan
     * @param Shift $shift
     * @return Response|bool
     */
    public function update(Plan $userPlan, Shift $shift)
    {
        return $userPlan->id == $shift->plan->id;
    }


    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param Plan $userPlan
     * @param Shift $shift
     * @return Response|bool
     */
    public function forceDelete(Plan $userPlan, Shift $shift)
    {
        return $userPlan->id == $shift->plan->id;
    }
}
