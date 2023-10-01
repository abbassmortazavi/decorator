<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class VerifyLogin
{

    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return RedirectResponse|Redirector|mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //check banned clients
        $arrayBannedNumbers = config('base.settings.fixed_banned_numbers', []);
        if (Auth::check() && in_array(user()->mobile, $arrayBannedNumbers, true)) {
            return redirect(guard_url('locked'));
        }

        if (user()->is_new && config('auth.verify_email')) {
            return redirect(guard_url('verify'));
        }

        if (user()->is_locked || user()->is_archived ||  user()->is_inactivated)
            return redirect(guard_url('locked'));

        if (user()->is_unsubscribed)
            return redirect(guard_url('unsubscribed'));

        $guard = !empty($guard) ? $guard : get_guard();
        $forceGuard = get_guard_alias(config('base.guards.admin'));
        if (($guard === $forceGuard) && (!user()->is_admin)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect(guard_url('logout'));
            }
        }

        return $next($request);
    }
}
