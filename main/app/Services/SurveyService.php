<?php
namespace App\Services;

use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\QuestionTypeOption;
use App\Models\User;
use App\Models\Answer;
use Carbon\Carbon;

class SurveyService
{
    public function getSurveysForUser()
    {
        $user = Auth::user();

        return Survey::whereHas('surveyors', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->where('endDate', '>', now())->get();
    }

    public function getSurveyById($id)
    {
        $survey = Survey::find($id);

        if ($survey && $survey->endDate > now()) return $survey;

        return null;
    }

    public function getQuestionDefinitions(Survey $survey)
    {
        $user = auth()->user();

        $isAssigned = DB::table('survey_surveyor')
            ->where('idSurvey', $survey->id)
            ->where('idSurveyor', $user->id)
            ->exists();

        if (!$isAssigned || $survey->endDate < now()) return null;

        $questions = $survey->questions()->with(['questionType', 'questionTypeOptions'])->get();

        $questionDefinitions = $questions->map(function ($question) {
            $questionDefinition = [
                'id' => $question->id,
                'question' => $question->question,
                'type' => $question->questionType->typeName,
                'min' => $question->min,
                'max' => $question->max,
            ];

            if ($question->questionTypeOptions->isNotEmpty()) {
                $questionDefinition['options'] = $question->questionTypeOptions->pluck('descr')->toArray();
            }

            return $questionDefinition;
        });

        return [
            'descr' => $survey->descr,
            'questions' => $questionDefinitions
        ];
    }

    public function postSurveyAnswers($answers)
    {
        foreach ($answers as $answer) {
            $answerModel = new Answer();
            $answerModel->id = $answer['id'];
            $answerModel->answer = json_encode($answer['answer']);
            $answerModel->answeredDate = Carbon::now();
            $answerModel->idQuestion = $answer['question'];
            $answerModel->save();
        }

        return true;
    }

    public function createSurvey($surveyRequest)
    {
        DB::beginTransaction(); // Start a new database transaction

        $survey = new Survey();
        $survey->descr = $surveyRequest['survey']['descr'];
        $survey->startDate = date('Y-m-d H:i:s', strtotime($surveyRequest['survey']['startDate']));
        $survey->endDate = date('Y-m-d H:i:s', strtotime($surveyRequest['survey']['endDate']));
        $survey->save();

        $questionIds = [];
        foreach ($surveyRequest['questions'] as $questionData) {
            $questionType = QuestionType::where('typeName', $questionData['type'])->first();
            if (!$questionType) return null;

            $question = new Question();
            $question->question = $questionData['question'];
            $question->idQuestionType = $questionType->id;

            // Handle min and max for range question type
            if ($questionData['type'] == 'range' && isset($questionData['options']) && count($questionData['options']) == 2) {
                $question->min = $questionData['options'][0];
                $question->max = $questionData['options'][1];
            }

            $question->save();
            $questionIds[] = $question->id;

            if ($questionData['type'] != 'text' && isset($questionData['options']) && is_array($questionData['options'])) {
                foreach ($questionData['options'] as $optionData) {
                    $option = new QuestionTypeOption();
                    $option->idQuestion = $question->id;
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
                    return null;
                }
            }
        }

        DB::commit(); // Commit the transaction

        return $survey;
    }
}