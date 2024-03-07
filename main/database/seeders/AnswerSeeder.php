<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('answer')->insert([
            ['answer' => 'Blue', 'answeredDate' => '2022-01-01 00:00:00', 'idQuestion' => 1],
            ['answer' => 'True', 'answeredDate' => '2022-02-01 00:00:00', 'idQuestion' => 2],
            ['answer' => '100;200', 'answeredDate' => '2022-03-01 00:00:00', 'idQuestion' => 3],
            ['answer' => 'PC;Xbox', 'answeredDate' => '2022-04-01 00:00:00', 'idQuestion' => 4],
        ]);
    }
}
