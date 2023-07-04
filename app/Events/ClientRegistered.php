<?php

namespace App\Events;

use App\Models\Survey;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $surveyId;
    public $userId;
    public $client_cellphone;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($surveyId, $userId)
    {
        $this->surveyId = $surveyId;
        $this->userId = $userId;
    }

}
