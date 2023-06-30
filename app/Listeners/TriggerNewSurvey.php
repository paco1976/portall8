<?php

namespace App\Listeners;

use App\Events\ClientRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Controllers\SurveyController;

class TriggerNewSurvey
{
    protected $surveyController;

    public function __construct(SurveyController $surveyController)
    {
        $this->surveyController = $surveyController;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ClientRegistered  $event
     * @return void
     */
    public function handle(ClientRegistered $event)
    {
        $surveyId = $event->surveyId;
        $userId = $event->userId;

        // Call the function from the SurveyController
        $this->surveyController->initSurvey($surveyId, $userId);
    }
}
