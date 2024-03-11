<?php

namespace App\Http\Controllers;

use App\Services\SurveyService;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    protected $surveyService;

    public function __construct(SurveyService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    public function getSurveysForUser()
    {
        /** @var \App\Models\Survey $surveys */
        $surveys = $this->surveyService->getSurveysForUser();

        return ApiResponse::success('Surveys retrieved successfully', ['surveys' => $surveys]);
    }
}
