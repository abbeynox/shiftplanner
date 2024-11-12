<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     * Set the session language key as the current language
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
            // Small hack to set the LC_TIME. de or en does no work on all systems
            $local = "en_US";
            if(Session::get('locale') === "de") {
                $local = "de_DE";
            }
            setlocale(LC_TIME, $local);
        }
        return $next($request);
    }
}
