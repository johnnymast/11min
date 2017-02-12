<?php

namespace App\Http\Controllers;

use App\Account;
use Carbon\Carbon;

class SystemController extends Controller
{

    /**
     * Retire this account and redirect to
     * the 'home' route.
     *
     * @return mixed
     */
    public function retireAccount()
    {
        if (($account = Account::where('unique_id', session('account'))->first())) {

            $account->expired = true;
            $account->save();
        }

        session()->forget('account');
        session()->forget('email');

        return \Redirect::route('home');
    }


    /**
     * Return a json array with information
     * of when this account will expire.
     *
     * @return array
     */
    public function timeRemaining()
    {
        $data = [
            'expires_at' => session('expires_at', Account::formatTimestamp())
        ];
        if (($account = Account::where('unique_id', session('account', null))->first())) {
            $data['expires_at'] = Account::formatTimestamp(strtotime($account->expires_at));
        }

        return $data;
    }


    /**
     * User pressed the "INCREASE TIME +10 MINUTES". This will give the user
     * 10 more minutes with his/hers mailbox. This function will return a json
     * array with information of when this account will expire.
     *
     * @return array
     */
    public function addTime()
    {
        $data = [
            'expires_at' => session('expires_at', Account::formatTimestamp())
        ];

        if (($account = Account::where('unique_id', session('account', null))->first())) {
            $newTime = strtotime("+10 MIN", strtotime($account->expires_at));
            $account->expires_at = Carbon::createFromTimestamp($newTime);
            $account->save();

            $data['expires_at'] = Account::formatTimestamp(strtotime($account->expires_at));
        }

        return $data;
    }


    /**
     * When the account is expired the user will be promoted with a modal
     * dialog. This asks the user to reset the time to 0+10 minutes or retire
     * its account and create a new one. This function will return a json array
     * of when the account will expire (after the reset).
     *
     * @return mixed
     */
    public function resetTime()
    {
        if (($account = Account::where('unique_id', session('account', null))->first())) {
            $account->expires_at = Carbon::now()->addMinutes(10);
            $account->save();
            $data['expires_at'] = Account::formatTimestamp(strtotime($account->expires_at));

            return $data;
        }
    }


    /**
     * Return a json array of (un)read messages in the user's
     * mailbox.
     *
     * @return array
     */
    public function messages()
    {

        try {
            $reader = \App::make('MailReader');

            $accountIdentifier = session('account', null);
            $account = Account::where('unique_id', $accountIdentifier)->first();

            if ( ! $account) {
                throw new \Exception("No saved account found");
            }

            $mailbox = $account->unique_id;
            $targetEmailAddress = $mailbox.'@'.config('custom.mail_domain');

            if ($reader->mailboxExists($mailbox) === false) {
                $reader->createMailbox($mailbox);
                $reader->subscribeMailbox($mailbox);
            }

            $messages = $reader->filterUnReadMessagesTo($targetEmailAddress);

            if (is_array($messages) && count($messages) > 0) {
                foreach ($messages as $message) {
                    $reader->moveMessage($message['index'], $mailbox);
                }
            }

            $reader->setMailbox($mailbox);
            $emails = $reader->readMailbox();
            $data = [];

            $account->last_check = Carbon::createFromTimestamp(time());
            $account->save();

            foreach ($emails as $email) {
                $data[] = [
                    'from'    => $email['header']->from[0]->personal,
                    'to'      => $email['header']->to,
                    'subject' => $email['header']->subject,
                    'when'    => Carbon::createFromTimestamp(strtotime($email['header']->date))->diffForHumans(),
                    'unread'  => $email['header']->Unseen == 'U',
                    'msgid'   => $email['index']
                ];
            }

            return $data;

        } catch (\Exception $e) {
            dd($e);
            return [];
        }
    }


    /**
     * This function will display an email message to the user.
     *
     * @param int $mailId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function displayMail($mailId = 0)
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
                    abort(500);
                }
            }
        } else {
            abort(404);
        }
    }
}
