<?php

namespace App\Console\Commands;

use App\Account;
use App\Events\NewEmailEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use JM\MailReader\MailReader;

class NewEmailCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for new emails for all accounts.';

    /**
     * Execute the console command.
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $accounts = Account::getActiveAccounts();
        $reader = new MailReader();
        $reader->connect([
            'server'   => env('MAILREADER_HOST'),
            'username' => env('MAILREADER_USERNAME'),
            'password' => env('MAILREADER_PASSWORD'),
            'post'     => env('MAILREADER_PORT'),
        ]);

        if (count($accounts) > 0) {
            foreach ($accounts as $account) {
                $reader->setMailbox('INBOX');
                $reader->readMailbox();

                if ( ! $account) {
                    throw new \Exception("No saved account found");
                }

                $mailbox = $account->unique_id;
                $targetEmailAddress = $mailbox.'@'.config('custom.mail_domain');

                echo "Checking ".$mailbox." (".$targetEmailAddress.")\n";

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
                        'from'    => $email['header']->fromaddress,
                        'to'      => $email['header']->to,
                        'subject' => $email['header']->subject,
                        'when'    => Carbon::createFromTimestamp(strtotime($email['header']->date))->diffForHumans(),
                        'unread'  => $email['header']->Unseen == 'U',
                        'msgid'   => $email['index']
                    ];
                }

                if (count($data) > 0) {
                    event(new NewEmailEvent($data));
                    echo "Pushed ".count($data)." mails for ".$account->unique_id."\n";
                }
            }
        }
    }
}