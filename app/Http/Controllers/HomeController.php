<?php

namespace App\Http\Controllers;

use App\Account;
use App\Events\AccountCreated;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Welcome's the user and create its account.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        try {

            if (Auth::guard('mailboxes')->guest()) {
                if (($account = Account::generate())) {
                    session([
                        'account' => $account->unique_id,
                        'email' => $account->email,
                    ]);

                    /**
                     * On windows this can give a timeout
                     */
                    event(new AccountCreated($account));
                    Auth::guard('mailboxes')->login($account);
                }
            } else {

                $account = Auth::guard('mailboxes')->user();

                if (! $account) {
                    throw new \Exception("Could not find user account. Maybe cookies are disabled.");
                }
            }

            $account['expires_at'] = date('Y-m-d H:i:s', strtotime($account['expires_at']));

            return view('home.show', [
                'account' => $account->toArray(),
            ]);
        } catch (\Exception $e) {
            \App::abort(500, 'Something bad happened');
        }
    }
}