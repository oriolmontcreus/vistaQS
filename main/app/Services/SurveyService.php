<?php
namespace App\Services;

use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

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
        $questions = $survey->questions()->with(['questionType', 'questionTypeOptions'])->get();

        return $questions->map(function ($question) {
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
    }
}