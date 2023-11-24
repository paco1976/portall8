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
        info('2. Entra al Event ClientRegistered');
        $this->surveyId = $surveyId;
        $this->userId = $userId;
    }
}
