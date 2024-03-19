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
use App\Models\QuestionType;
use Illuminate\Support\Facades\DB;


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
        try {
            DB::beginTransaction(); // Start a new database transaction

            $surveyRequest = $request->all();

            if (empty($surveyRequest)) return ApiResponse::error('No survey data provided');

            $survey = new Survey();
            $survey->descr = $surveyRequest['survey']['descr'];
            $survey->startDate = date('Y-m-d H:i:s', strtotime($surveyRequest['survey']['startDate']));
            $survey->endDate = date('Y-m-d H:i:s', strtotime($surveyRequest['survey']['endDate']));
            $survey->save();

            $questionIds = [];
            foreach ($surveyRequest['questions'] as $questionData) {
                $questionType = QuestionType::where('typeName', $questionData['type'])->first();
                if (!$questionType) return ApiResponse::error('Question type not found');

                $question = new Question();
                $question->question = $questionData['question'];
                $question->idQuestionType = $questionType->id;
                $question->save();
                $questionIds[] = $question->id;

                if ($questionData['type'] != 'text' && isset($questionData['options']) && is_array($questionData['options'])) {
                    foreach ($questionData['options'] as $optionData) {
                        $answer = new Answer();
                        $answer->answer = $optionData;
                        $answer->idQuestion = $question->id;
                        $answer->save();

                        $option = new QuestionTypeOption();
                        $option->idQuestion = $question->id;
                        $option->idAnswer = $answer->id;
                        $option->descr = $optionData;
                        $option->save();
                    }
                }
            }

            $survey->questions()->attach($questionIds);

            if (isset($surveyRequest['idSurveyors']) && is_array($surveyRequest['idSurveyors'])) {
                foreach ($surveyRequest['idSurveyors'] as $idSurveyor) {
                    $user = User::find($idSurveyor);
                    if ($user) {
                        $user->surveys()->attach($survey->id);
                    } else {
                        return ApiResponse::error('Surveyor with id ' . $idSurveyor . ' not found');
                    }
                }
            }

            DB::commit(); // Commit the transaction

        } catch (\Exception $e) {
            DB::rollBack(); // Roll back the transaction

            return ApiResponse::error('An error occurred: ' . $e->getMessage());
        }

        return ApiResponse::success('Survey created successfully');
    }
}
