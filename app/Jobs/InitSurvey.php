<?php

namespace App\Jobs;

use App\Http\Controllers\SurveyController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InitSurvey implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $surveyId;
    protected $userId;

    public function __construct($surveyId, $userId)
    {
        $this->surveyId = $surveyId;
        $this->userId = $userId;
    }

    public function handle()
    {
        $surveyController = new SurveyController();
        $surveyController->initSurvey($this->surveyId, $this->userId);
    }
}

