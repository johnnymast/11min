<?php

namespace App\Console\Commands;

use App\Mail\CleanupReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CleanupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old accounts and emails';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $accounts = (new \App\Account)->getExpiredAccounts();
        $admin = \App\User::whereAdmin(true)->first();
        $cleaned = 0;

        if ($accounts) {
            foreach ($accounts as $account) {
                $mailbox = $account->unique_id;
                $reader = \App::make('MailReader');

                $reader->setMailbox($mailbox);
                $messages = $reader->readMailbox();

                if (is_array($messages) == true) {
                    foreach ($messages as $message) {
                        $reader->deleteMessage($message['index']);
                    }
                }

                $reader->removeMailbox($mailbox);
                $account->delete();

                $cleaned++;
            }
        }

        if ($admin) {
            Mail::to($admin)
                ->send(new CleanupReport($cleaned));
        }
    }
}
