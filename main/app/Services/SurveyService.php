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
}