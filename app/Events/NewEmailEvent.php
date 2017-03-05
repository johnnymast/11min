<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewEmailEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    protected $emails = [];


    /**
     * Create a new event instance.
     *
     * @param $emails
     */
    public function __construct($emails)
    {
        $this->emails = $emails;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('emails.pipepline');
    }
}
