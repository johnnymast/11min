<?php

namespace App\Console\Commands;

use App\Account;
use Illuminate\Console\Command;

class ExpireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire non-active mailboxes';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $accounts = (new Account())->getInactiveAccounts();
        foreach ($accounts as $account) {
            $account->expired = true;
            $account->save();
        }
        if (count($accounts) > 0) {
            echo 'Expired '.count($accounts).'accounts';
        }
    }
}
