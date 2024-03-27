<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Insert into users table
        $userId = DB::table('users')->insertGetId([
            'name' => 'Admin User',
            'email' => 'adminuser@gmail.com',
            'password' => bcrypt('1234'),
            'city' => 'Awesome City',
        ]);

        // Insert into questiontype table
        DB::table('questiontype')->insert([
            ['typeName' => 'text'],
            ['typeName' => 'multiple_select'],
            ['typeName' => 'solo_select'],
            ['typeName' => 'range'],
        ]);

        // Insert into survey table
        $surveyId = DB::table('survey')->insertGetId([
            'descr' => 'This is a test survey',
            'startDate' => now(),
            'endDate' => now()->addMonth(),
        ]);

        // Assign the survey to the user
        DB::table('survey_surveyor')->insert([
            'idSurvey' => $surveyId,
            'idSurveyor' => $userId,
        ]);

        // Insert into question table and assign them to the survey
        $questionIds = [];
        $questions = [
            ['question' => 'What is your favorite color?', 'idQuestionType' => 1],
            ['question' => 'Select your favorite fruits', 'idQuestionType' => 2],
            ['question' => 'Are you a human?', 'idQuestionType' => 3],
            ['question' => 'Rate your experience from 1 to 10', 'idQuestionType' => 4, 'min' => 1, 'max' => 10],
        ];
        foreach ($questions as $question) {
            $questionId = DB::table('question')->insertGetId($question);
            $questionIds[] = $questionId;
            DB::table('survey_question')->insert([
                'idSurvey' => $surveyId,
                'idQuestion' => $questionId,
            ]);
        }

        // Insert options for the 'Select your favorite fruits' question
        $fruitOptions = ['apple', 'banana', 'pineapple', 'orange'];
        foreach ($fruitOptions as $option) {
            DB::table('questiontype_option')->insert([
                'idQuestion' => $questionIds[1],
                'descr' => $option,
            ]);
        }

        // Insert options for the 'Are you a human?' question
        $humanOptions = ['Yes', 'No'];
        foreach ($humanOptions as $option) {
            DB::table('questiontype_option')->insert([
                'idQuestion' => $questionIds[2],
                'descr' => $option,
            ]);
        }
    }

    
}
