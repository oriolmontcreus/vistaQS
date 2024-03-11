<?php
namespace App\Services;

use App\Models\Survey;

class SurveyService
{
    public function getAllSurveys()
    {
        return Survey::all();
    }
}