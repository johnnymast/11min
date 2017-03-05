<?php

namespace App\Http\Middleware;

use App\Account;
use Closure;
use Illuminate\Support\Facades\Auth;

class isValidAcount
{
    /**
     * If the account is unknown respond with a 401
     * else continue the request. We also check if the
     * account is expired or not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {
            $request->request->add(['user' => Auth::user()]);
        } else {
           // return response('Unauthorized', 401);
        }
        return $next($request);
    }
}
