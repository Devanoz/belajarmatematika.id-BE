<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Question_id = 1
        DB::table('options')->insert([
            'title_1' => 4,
            'title_2' => 5,
            'title_3' => 6,
            'title_4' => 7,
            'question_id' => 1,
        ]);

        // Question_id = 2
        DB::table('options')->insert([
            'title_1' => 8,
            'title_2' => 9,
            'title_3' => 10,
            'title_4' => 11,
            'question_id' => 2,
        ]);

        // Question_id = 4
        DB::table('options')->insert([
            'title_1' => 7,
            'title_2' => 8,
            'title_3' => 9,
            'title_4' => 10,
            'question_id' => 4,
        ]);

        // Question_id = 5
        DB::table('options')->insert([
            'title_1' => 13,
            'title_2' => 14,
            'title_3' => 15,
            'title_4' => 16,
            'question_id' => 5,
        ]);
    }
}
