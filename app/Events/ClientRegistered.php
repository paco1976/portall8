<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientRegistered
{
    use Dispatchable, SerializesModels;

    public $surveyId;
    public $userId;

    public function __construct($surveyId, $userId)
    {
        $this->surveyId = $surveyId;
        $this->userId = $userId;
    }
}
