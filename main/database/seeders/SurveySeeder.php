<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('survey')->insert([
            ['descr' => 'Survey 1', 'startDate' => '2022-01-01 00:00:00', 'endDate' => '2022-01-31 23:59:59'],
            ['descr' => 'Survey 2', 'startDate' => '2022-02-01 00:00:00', 'endDate' => '2022-02-28 23:59:59'],
            ['descr' => 'Survey 3', 'startDate' => '2022-03-01 00:00:00', 'endDate' => '2022-03-31 23:59:59'],
        ]);
    }
}
