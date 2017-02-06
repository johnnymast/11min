<?php

namespace App\Console\Commands;

use App\Mail\CleanupReport;
use Illuminate\Console\Command;

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
     *
     * @return mixed
     */
    public function handle()
    {
        $accounts = (new \App\Account)->getExpiredAccounts();
        $admin = \App\User::whereAdmin(false)->first();
        $cleaned = count($account);

        if (is_array($accounts) == true) {
            foreach ($accounts as $account) {

            }
        }

        if ($admin) {
            Mail::to($admin)
                ->send(new CleanupReport($cleaned));
        }
        
    }
}
