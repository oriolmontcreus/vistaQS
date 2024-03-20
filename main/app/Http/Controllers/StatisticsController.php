<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use App\Helpers\ApiResponse;

class StatisticsController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    // public function getTotalSurveys()
    // {
    //     $surveys = $this->statisticsService->getTotalSurveys();

    //     return ApiResponse::success('Total surveys retrieved successfully', $surveys);
    // }

    // public function getTotalAnsweredQuestions()
    // {
    //     $answeredQuestions = $this->statisticsService->getTotalAnsweredQuestions();

    //     return ApiResponse::success('Total answered questions retrieved successfully', $answeredQuestions);
    // }

    // public function getTotalAnsweredSurveys()
    // {
    //     $answeredSurveys = $this->statisticsService->getTotalAnsweredSurveys();

    //     return ApiResponse::success('Total answered surveys retrieved successfully', $answeredSurveys);
    // }
}
