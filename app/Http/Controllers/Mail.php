<?php

namespace App\Http\Controllers;

use App\Account;
use Carbon\Carbon;

class Mail extends Controller
{

    const EXPIRATION_TIME_FORMAT = 'D M d Y H:i:s';


    public function dataSource()
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

            $account->last_check = \Carbon\Carbon::createFromTimestamp(time());
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
            return [];
        }
    }


    /**
     *
     */
    public function resetTime()
    {
        if (($account = Account::where('unique_id', session('account', null)))) {
            $account->expires_at = date(self::EXPIRATION_TIME_FORMAT, strtotime("+10 MIN"));
            $account->save();
        }
    }


    /**
     * @return array
     */
    public function getRemainingTime()
    {
        $data = [
            'expires_at' => session('expires_at', date(self::EXPIRATION_TIME_FORMAT))
        ];
        if (($account = Account::where('unique_id', session('account', null))->first())) {
            $data['expires_at'] = date(self::EXPIRATION_TIME_FORMAT, strtotime($account->expires_at));
        }

        return $data;
    }


    public function addTime()
    {
        $data = [
            'expires_at' => session('expires_at', date(self::EXPIRATION_TIME_FORMAT))
        ];

        if (($account = Account::where('unique_id', session('account', null))->first())) {
            $newTime = strtotime("+10 MIN", strtotime($account->expires_at));
            $account->expires_at = \Carbon\Carbon::createFromTimestamp($newTime);
            $account->save();

            $data['expires_at'] = date(self::EXPIRATION_TIME_FORMAT, strtotime($account->expires_at));
        }

        return $data;
    }


    public function readEmail($mailId = 0)
    {
        if ($mailId > 0) {
            try {
                $reader = \App::make('MailReader');

                $account = $account = session('account', null);
                $reader->setMailbox($account);
                $reader->readMailbox();

                $email = $reader->getMessage($mailId);
                if ( ! $email) {
                    throw new \Exception("Email not found", 200);
                }

                return $email;

            } catch (\Exception $e) {
                if ($e->getCode() == 200) {
                    return ['status' => 'error', 'message' => $e->getMessage()];
                } else {
                    return ['status' => 'error', 'message' => "internal error"];
                }
            }
        } else {
            return ['status' => 'error', 'message' => "Email not found"];
        }
    }
}
