<?php

namespace App\Http\Controllers;

use App\Services\SurveyService;
use App\Helpers\ApiResponse;

class SurveyController extends Controller
{
    protected $surveyService;

    public function __construct(SurveyService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    public function getSurveys()
    {
        /** @var \App\Models\Survey $surveys */
        $surveys = $this->surveyService->getAllSurveys();

        return ApiResponse::success('Surveys retrieved successfully', ['surveys' => $surveys]);
    }
}
