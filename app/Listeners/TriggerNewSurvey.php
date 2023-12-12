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
        info('3. Entra al Listener TriggerNewSurvey');
        $surveyId = $event->surveyId;
        $userId = $event->userId;

        //TODO: dejar addWeek cuando se termine de testear
        // InitSurvey::dispatch($surveyId, $userId)->delay(now()->addWeek());
        //InitSurvey::dispatch($surveyId, $userId)->delay(now()->addMinutes(1));
        InitSurvey::dispatch($surveyId, $userId)->delay(now());
        info('  3.1 Pasa el dispatch');
    }
}