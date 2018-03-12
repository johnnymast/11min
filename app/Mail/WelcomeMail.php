<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Account;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Account
     */
    public $account = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to '.config('app.name').'!')->markdown('emails.client.welcome');
    }
}
