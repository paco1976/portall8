<?php

namespace App\Listeners;

use App\Events\ClientRegistered;
use App\Jobs\InitSurvey; // Import the new job
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TriggerNewSurvey
{
    public function handle(ClientRegistered $event)
    {
        $surveyId = $event->surveyId;
        $userId = $event->userId;

        //TODO: dejar addWeek cuando se termine de testear
        // InitSurvey::dispatch($surveyId, $userId)->delay(now()->addWeek());
        InitSurvey::dispatch($surveyId, $userId)->delay(now()->addMinutes(1));
    }
}