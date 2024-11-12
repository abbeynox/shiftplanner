<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Shift;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Auth a plan over by the secrete Plan edit_id
     * @param Plan $plan
     */
    protected function auth(Plan $plan) {
        if (!strpos(\Request::url(), $plan->edit_id)) {
            abort(401);
        }
        // login the plan as a user. This is a hack to work with edit_id tokens only and the laravel auth Policies
        Auth::login($plan, false);
    }


    /**
     * Anonymous user can just subscribe to a known plan and shift
     * @param Plan $plan
     * @param Shift $shift
     */
    protected function authSubscriber(Plan $plan, Shift $shift) {
        // anonymous user can subscribe to the plan they have the link to
        // we can't use auth Policies to check this
        if($shift->plan->id !== $plan->id) {
            abort(403);
        }
    }
}
