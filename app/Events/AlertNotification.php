<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AlertNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $alertName;
    public $alertType;
    public $value;

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param $alertName
     * @param $alertType
     * @param $value
     */
    public function __construct($user, $alertName, $alertType, $value)
    {
        $this->user = $user;
        $this->alertName = $alertName;
        $this->alertType = $alertType;
        $this->value = $value;
    }


    public function broadcastOn() {
        return new PrivateChannel('user.' . $this->user->id);
    }

    public function broadcastWith() {
        return [
            'alert_name' => $this->alertName,
            'alert_type' => $this->alertType,
            'value' => $this->value,
        ];
    }
}
