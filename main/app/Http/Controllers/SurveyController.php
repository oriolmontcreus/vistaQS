<?php

namespace App\Http\Controllers;

use App\Services\SurveyService;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Answer;
use Carbon\Carbon;
use App\Models\Survey;
use App\Models\Question;
use App\Models\QuestionTypeOption;
use App\Models\User;


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

    public function postNewSurvey(Request $request)
    {
        $surveyRequest = $request->all();

        if (empty($surveyRequest)) return ApiResponse::error('No survey data provided');

        $survey = new Survey();
        $survey->descr = $surveyRequest['survey']['descr'];
        $survey->startDate = $surveyRequest['survey']['startDate'];
        $survey->endDate = $surveyRequest['survey']['endDate'];
        $survey->save();

        $questionIds = [];
        foreach ($surveyRequest['questions'] as $questionData) {
            $question = new Question();
            $question->question = $questionData['question'];
            $question->idQuestionType = $questionData['idQuestionType'];
            $question->save();
            $questionIds[] = $question->id;

            if (isset($questionData['options'])) {
                foreach ($questionData['options'] as $optionData) {
                    $option = new QuestionTypeOption();
                    $option->idQuestion = $question->id;
                    $option->idAnswer = $optionData['idAnswer'];
                    $option->descr = $optionData['descr'];
                    $option->save();
                }
            }
        }

        $survey->questions()->attach($questionIds);

        $user = User::find($surveyRequest['idSurveyor']);
        if ($user) {
            $user->surveys()->attach($survey->id);
        } else {
            return ApiResponse::error('Surveyor not found');
        }

        return ApiResponse::success('Survey created successfully');
    }
}
