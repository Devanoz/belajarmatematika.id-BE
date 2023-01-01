<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StudentChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 2; $i <= 20; $i++) {
            for ($j = 1; $j <= 15; $j++) {
                DB::table('student_challenges')->insert([
                    'student_id'    => $i,
                    'challenge_id'  => $j,
                    'score' => ($i + $j) + 65
                ]);
            }
        }
    }
}
