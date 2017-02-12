<?php

namespace App\Http\Controllers;

use App\Account;
use App\Notifications\WelcomeMail;

class HomeController extends Controller
{

    /**
     * Welcome's the user and create its account.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        try {

            if (session()->has('account') == false) {
                if (($account = Account::generate())) {

                    session([
                        'account' => $account->unique_id,
                        'email'   => $account->email
                    ]);

                    $account->notify(new WelcomeMail($account));
                }
            } else {

                $account = Account::where('unique_id', session('account'))->first();
                if ( ! $account) {
                    return \Redirect::route('retire');
                }
            }

            $account['expires_at'] = Account::formatTimestamp(strtotime($account['expires_at']));

            return view('home.show', [
                'account' => $account->toArray(),
            ]);

        } catch (\Exception $e) {
            return \Redirect::route('retire');
        }
    }
}
