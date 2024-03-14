<?php
namespace App\Services;

use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyService
{
    public function getSurveysForUser()
    {
        $user = Auth::user();
    
        return Survey::whereHas('surveyors', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->get();
    }
    public function getSurveyById($id)
    {
        return Survey::find($id);
    }
    public function getQuestionDefinitions(Survey $survey)
    {
        $user = auth()->user();

        $isAssigned = DB::table('survey_surveyor')
            ->where('idSurvey', $survey->id)
            ->where('idSurveyor', $user->id)
            ->exists();

        if (!$isAssigned) return null;

        $questions = $survey->questions()->with(['questionType', 'questionTypeOptions'])->get();

        $questionDefinitions = $questions->map(function ($question) {
            $questionDefinition = [
                'id' => $question->id,
                'question' => $question->question,
                'type' => $question->questionType->typeName,
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
}