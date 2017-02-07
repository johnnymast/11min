<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CleanupReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var int
     */
    protected $total = 0;


    /**
     * CleanupReport constructor.
     *
     * @param int $total
     */
    public function __construct($total)
    {
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('email.cleanupreport')
            ->withTotal($this->total);
    }
}
