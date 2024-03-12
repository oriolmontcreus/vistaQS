<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('question')->insert([
            ['question' => 'What is your favorite color?', 'idQuestionType' => 1],
            ['question' => 'Do you like programming?', 'idQuestionType' => 2],
            ['question' => 'From what range are you willing to pay?', 'idQuestionType' => 3],
            ['question' => 'In what platforms do you play videogames?', 'idQuestionType' => 4],
        ]);
    }
}
