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
            'A' => 4,
            'B' => 5,
            'C' => 6,
            'D' => 7,
            'question_id' => 1,
        ]);

        // Question_id = 2
        DB::table('options')->insert([
            'A' => 8,
            'B' => 9,
            'C' => 10,
            'D' => 11,
            'question_id' => 2,
        ]);

        // Question_id = 4
        DB::table('options')->insert([
            'A' => 7,
            'B' => 8,
            'C' => 9,
            'D' => 10,
            'question_id' => 4,
        ]);

        // Question_id = 5
        DB::table('options')->insert([
            'A' => 13,
            'B' => 14,
            'C' => 15,
            'D' => 16,
            'question_id' => 5,
        ]);
    }
}
