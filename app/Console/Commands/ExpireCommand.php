<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExpireCommand extends Command
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
    protected $description = 'Expire non-active mailboxes';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }
}
