<?php

namespace App\Http\Controllers;

use App\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller
{

    /**
     * Retire this account and redirect to
     * the 'home' route.
     *
     * @param Request $request
     * @return mixed
     */
    public function retireAccount(Request $request)
    {
        $request->user()->expired = true;
        $request->user()->save();

        /**
         * These could be deprecated
         */
        session()->forget('account');
        session()->forget('email');

        Auth::logout();

        return \Redirect::route('home');
    }


    /**
     * Return a json array with information
     * of when this account will expire.
     *
     * @param Request $request
     * @return array
     */
    public function timeRemaining(Request $request)
    {
        $data = [
            'expires_at' => session('expires_at', Account::formatTimestamp())
        ];

        $data['expires_at'] = Account::formatTimestamp(strtotime($request->user()->expires_at));

        return $data;
    }


    /**
     * User pressed the "INCREASE TIME +10 MINUTES". This will give the user
     * 10 more minutes with his/hers mailbox. This function will return a json
     * array with information of when this account will expire.
     *
     * @param Request $request
     * @return array
     */
    public function addTime(Request $request)
    {
        $data = [
            'expires_at' => session('expires_at', Account::formatTimestamp())
        ];

        $newTime = strtotime("+10 MIN", strtotime($request->user()->expires_at));
        $request->user()->expires_at = Carbon::createFromTimestamp($newTime);
        $request->user()->save();

        $data['expires_at'] = Account::formatTimestamp(strtotime($request->user()->expires_at));

        return $data;
    }


    /**
     * When the account is expired the user will be promoted with a modal
     * dialog. This asks the user to reset the time to 0+10 minutes or retire
     * its account and create a new one. This function will return a json array
     * of when the account will expire (after the reset).
     *
     * @param Request $request
     * @return mixed
     */
    public function resetTime(Request $request)
    {
        $request->user()->expires_at = Carbon::now()->addMinutes(10);
        $request->user()->save();
        $data['expires_at'] = Account::formatTimestamp(strtotime($request->user()->expires_at));

        return $data;
    }


    /**
     * This function will display an email message to the user.
     *
     * @param Request $request
     * @param int     $mailId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function displayMail(Request $request, $mailId = 0)
    {
        if ($mailId > 0) {

            try {
                $reader = \App::make('MailReader');

                $reader->setMailbox($request->user()->unique_id);
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

        } else {
            abort(404);
        }
    }
}
