<?php

namespace App\Console\Commands;

use App\Events\NewEmailEvent;
use Illuminate\Console\Command;
use JM\MailReader\MailReader;
use Carbon\Carbon;
use App\Account;

class CheckNewMailCommand extends Command
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


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
            foreach($accounts as $account) {

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
                        'from'    => $email['header']->fromaddress,
                        'to'      => $email['header']->to,
                        'subject' => $email['header']->subject,
                        'when'    => Carbon::createFromTimestamp(strtotime($email['header']->date))->diffForHumans(),
                        'unread'  => $email['header']->Unseen == 'U',
                        'msgid'   => $email['index']
                    ];
                }

                broadcast(new NewEmailEvent($account, $emails));
                echo "Pushed ".count($emails)." mails for "."\n";
            }
        }
    }
}
