<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntrianUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id_jadwal;
    public $no_antrian_sekarang;

    /**
     * Create a new event instance.
     */
    public function __construct($id_jadwal, $no_antrian_sekarang)
    {
        $this->id_jadwal = $id_jadwal;
        $this->no_antrian_sekarang = $no_antrian_sekarang;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('antrian'),
        ];
    }

    public function broadcastAs()
    {
        return 'AntrianUpdated';
    }
}
