<?php

namespace App\Http\Controllers;

use App\Account;
use App\Notifications\WelcomeMail;
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
            //Auth::logout();

            if (Auth::guard('mailboxes')->guest()) {
                if (($account = Account::generate())) {
                    session([
                        'account' => $account->unique_id,
                        'email' => $account->email
                    ]);

                    /**
                     * At Timeout of 30 sec check the email settings in .env
                     */
                    //$account->notify(new WelcomeMail($account));

                    Auth::guard('mailboxes')->login($account);
                }

            } else {
                $account = Auth::guard('mailboxes')->user();

                if (!$account) {
                    return \Redirect::route('retire');
                }
            }

            $account['expires_at'] = date('Y-m-d H:i:s', strtotime($account['expires_at']));

            return view('home.show', [
                'account' => $account->toArray(),
            ]);
        } catch (\Exception $e) {
            exit;
            return \Redirect::route('retire');
        }
    }
}
