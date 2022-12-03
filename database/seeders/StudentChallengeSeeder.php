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
        for($i = 1; $i <= 3; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                DB::table('student_challenges')->insert([
                    'student_id'    => $i,
                    'challenge_id'  => $j,
                    'score' => $i * $j * 10
                ]);
            }
        }
    }
}
