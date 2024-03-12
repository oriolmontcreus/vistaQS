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

    public function getSurveysForUser()
    {
        /** @var \App\Models\Survey $surveys */
        $surveys = $this->surveyService->getSurveysForUser();

        return ApiResponse::success('Surveys retrieved successfully', ['surveys' => $surveys]);
    }

    public function getSurveysGivenId($id)
    {
        $survey = $this->surveyService->getSurveyById($id);

        if (!$survey) 
            return ApiResponse::error('Survey not found', []);

        $questionDefinitions = $this->surveyService->getQuestionDefinitions($survey);

        if ($questionDefinitions === null) 
            return ApiResponse::error('Survey not assigned to the user', []);

        return ApiResponse::success('Questions retrieved successfully', ['questions' => $questionDefinitions]);
    }
}
