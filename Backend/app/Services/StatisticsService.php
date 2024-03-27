<?php
namespace App\Services;

use App\Models\Survey;
use App\Models\Answer;
use Carbon\Carbon;

class StatisticsService
{
    // public function getTotalSurveys()
    // {
    //     $totalSurveys = Survey::count();
    //     $totalSurveysLastWeek = Survey::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->count();

    //     return ['total' => $totalSurveys, 'lastWeek' => $totalSurveysLastWeek];
    // }

    // public function getTotalAnsweredQuestions()
    // {
    //     $totalAnsweredQuestions = Answer::count();
    //     $totalAnsweredQuestionsLastWeek = Answer::whereBetween('answeredDate', [Carbon::now()->subWeek(), Carbon::now()])->count();

    //     return ['total' => $totalAnsweredQuestions, 'lastWeek' => $totalAnsweredQuestionsLastWeek];
    // }

    // public function getTotalAnsweredSurveys()
    // {
    //     $totalAnsweredSurveys = Answer::select('idQuestion')->distinct()->count();
    //     $totalAnsweredSurveysLastWeek = Answer::whereBetween('answeredDate', [Carbon::now()->subWeek(), Carbon::now()])->select('idQuestion')->distinct()->count();

    //     return ['total' => $totalAnsweredSurveys, 'lastWeek' => $totalAnsweredSurveysLastWeek];
    // }
}