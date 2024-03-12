<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questiontype_option')->insert([
            ['idQuestion' => 1, 'idAnswer' => 1, 'descr' => 'Xbox'],
            ['idQuestion' => 1, 'idAnswer' => 2, 'descr' => 'Playstation'],
            ['idQuestion' => 1, 'idAnswer' => 3, 'descr' => 'PC'],
            ['idQuestion' => 1, 'idAnswer' => 4, 'descr' => 'Nintendo'],
            ['idQuestion' => 2, 'idAnswer' => 1, 'descr' => 'Yes'],
            ['idQuestion' => 2, 'idAnswer' => 2, 'descr' => 'No'],
            ['idQuestion' => 4, 'idAnswer' => 1, 'descr' => 'PC'],
            ['idQuestion' => 4, 'idAnswer' => 2, 'descr' => 'Xbox'],
            ['idQuestion' => 4, 'idAnswer' => 3, 'descr' => 'Playstation'],
            ['idQuestion' => 4, 'idAnswer' => 4, 'descr' => 'Nintendo'],
        ]);
    }
}
