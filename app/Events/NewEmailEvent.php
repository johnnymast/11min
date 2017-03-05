<?php

namespace App\Events;

use App\Account;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\App;

class NewEmailEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    protected $emails = [];

    /**
     * @var Account
     */
    protected $account = null;

    /**
     * Create a new event instance.
     *
     * @param $emails
     */
    public function __construct(Account $account, $emails = [])
    {
        $this->account = $account;
        $this->emails = $emails;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('emails.pipepline.'.$this->account->unique_id);
    }
}
