<?php

namespace App\Jobs;

use App\Http\Controllers\SurveyController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Survey;

class InitSurvey implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $surveyId;
    public function __construct($surveyId)
    {
        $this->surveyId = $surveyId;
    }

    public function handle()
    {
        $survey = Survey::find($this->surveyId);
    
        $surveyController = new SurveyController();
        $surveyController->initSurvey($survey->id, $survey->user_id);
    }
}
