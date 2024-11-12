<?php

namespace App\Policies;

use App\Models\Plan;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user (a plan object) can view any plan
     * This is always false
     *
     * @param Plan $userPlan
     * @return Response|bool
     */
    public function viewAny(Plan $userPlan)
    {
        return false;
    }

    /**
     * Determine whether the user (a plan object) can view the selected plan.
     *
     * @param Plan $userPlan
     * @param Plan $plan
     * @return Response|bool
     */
    public function view(Plan $userPlan, Plan $plan)
    {
        return $userPlan->id === $plan->id;
    }

    /**
     * Determine whether the user (a plan object) can update the model.
     *
     * @param Plan $userPlan
     * @param Plan $plan
     * @return Response|bool
     */
    public function update(Plan $userPlan, Plan $plan)
    {
        return $userPlan->id === $plan->id;
    }

    /**
     * Determine whether the user (a plan object) can permanently delete the model.
     *
     * @param Plan $userPlan
     * @param Plan $plan
     * @return Response|bool
     */
    public function forceDelete(Plan $userPlan, Plan $plan)
    {
        return $userPlan->id === $plan->id;
    }
}
