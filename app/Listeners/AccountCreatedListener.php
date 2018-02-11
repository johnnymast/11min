<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\AccountCreated;
use Illuminate\Support\Facades\Mail;

class AccountCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle(AccountCreated $event)
    {
        Mail::to($event->account)->send(new WelcomeMail($event->account));
    }
}
