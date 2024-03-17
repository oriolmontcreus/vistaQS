<?php

namespace App\Http\Controllers;

use App\Services\SurveyService;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Answer;
use Carbon\Carbon;

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

    public function getSurveyGivenId($id)
    {
        $survey = $this->surveyService->getSurveyById($id);

        if (!$survey) 
            return ApiResponse::error('Survey not found', []);

        $questionDefinitions = $this->surveyService->getQuestionDefinitions($survey);

        if ($questionDefinitions === null) 
            return ApiResponse::error('Survey not assigned to the user', []);

        return ApiResponse::success('Questions retrieved successfully', ['survey' => $questionDefinitions]);
    }

    public function postSurveyAnswers(Request $request)
    {
        $answers = $request->all();

        if (empty($answers)) return ApiResponse::error('No answers provided');

        foreach ($answers as $answer) {
            $answerModel = new Answer();
            $answerModel->id = $answer['id'];
            $answerModel->answer = json_encode($answer['answer']);
            $answerModel->answeredDate = Carbon::now();
            $answerModel->idQuestion = $answer['question'];
            $answerModel->save();
        }

        return ApiResponse::success('Answers saved successfully');
    }
}
