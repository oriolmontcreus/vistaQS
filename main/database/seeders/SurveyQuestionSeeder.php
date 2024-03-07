<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $surveys = DB::table('survey')->get();
        $questions = DB::table('question')->get();

        foreach ($surveys as $survey) {
            foreach ($questions as $question) {
                DB::table('survey_question')->insert([
                    'idSurvey' => $survey->id,
                    'idQuestion' => $question->id,
                ]);
            }
        }
    }
}
