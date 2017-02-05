<?php

namespace App\Http\Middleware;

use App\Account;
use Closure;

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
        if (! $request->session()->get('account', null)) {
            return response('Unauthorized', 401);
        } else {
            $account = Account::where('unique_id',$request->session()->get('account' ))->first();
            if ($account->expired == true) {
                return response('Unauthorized', 401);
            }
        }
        return $next($request);
    }
}
