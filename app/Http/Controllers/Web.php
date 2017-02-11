<?php

namespace App\Http\Controllers;

use App\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Web extends Controller
{

    const EXPIRATION_TIME_FORMAT = 'D M d Y H:i:s';


    public function index()
    {
        try {

            if (session()->has('account') == false) {
                if (($account = Account::generate())) {

                    session([
                        'account' => $account->unique_id,
                        'email'   => $account->email
                    ]);

                    //$account->notify(new WelcomeMail($account));
                }
            } else {

                $account = Account::where('unique_id', session('account'))->first();
                if ( ! $account) {
                    return \Redirect::route('retire');
                }

            }
            $account['expires_at'] = date(self::EXPIRATION_TIME_FORMAT, strtotime($account['expires_at']));

            return view('home.show', [
                'account' => $account->toArray(),
            ]);
        } catch (\Exception $e) {
            return \Redirect::route('retire');
        }
    }


    public function retire()
    {
        if (($account = Account::where('unique_id', session('account'))->first())) {

            $account->expired = true;
            $account->save();
        }

        session()->forget('account');
        session()->forget('email');

        return \Redirect::route('home');
    }


    public function displayMail(Request $request, $mailId = 0)
    {
        if ($mailId > 0) {
            if (($account = Account::where('unique_id', session('account'))->first())) {
                try {
                    $reader = \App::make('MailReader');

                    $reader->setMailbox($account->unique_id);
                    $reader->readMailbox();

                    $email = $reader->getMessage($mailId);

                    if ( ! $email) {
                        throw new \Exception("Email not found", 200);
                    }

                    /**
                     * Todo filter script tags
                     */
                    $data = [
                        'from'    => $email['header']->fromaddress,
                        'to'      => $email['header']->toaddress,
                        'subject' => $email['header']->subject,
                        'when'    => Carbon::createFromTimestamp(strtotime($email['header']->date))->diffForHumans(),
                        'body'    => $email['body']
                    ];

                    return view('email.show', [
                        'email' => $data,
                    ]);

                } catch (\Exception $e) {

                    dd($e);
                    abort(500);
                }
            }
        } else {
            abort(404);
        }
    }
}
