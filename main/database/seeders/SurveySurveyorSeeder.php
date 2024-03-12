<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SurveySurveyorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $surveys = DB::table('survey')->get();
        $surveyorId = 1;

        foreach ($surveys as $survey) {
            DB::table('survey_surveyor')->insert([
                'idSurvey' => $survey->id,
                'idSurveyor' => $surveyorId,
            ]);
        }
    }
}
