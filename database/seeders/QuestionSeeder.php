<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // challenge_id = 1
        $title = '3 + 3 = ?';
        DB::table('questions')->insert([
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'answer_key' => 6,
            'challenge_id' => 1,
        ]);

        $title = '4 + 4 = ?';
        DB::table('questions')->insert([
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'answer_key' => 8,
            'challenge_id' => 1,
        ]);

        $title = '5 + 5 = ?';
        DB::table('questions')->insert([
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'answer_key' => 10,
            'challenge_id' => 1,
        ]);

        // challenge_id = 2
        $title = '3 x 3 = ?';
        DB::table('questions')->insert([
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'answer_key' => 9,
            'challenge_id' => 2,
        ]);

        $title = '4 x 4 = ?';
        DB::table('questions')->insert([
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'answer_key' => 16,
            'challenge_id' => 2,
        ]);

        $title = '5 x 5 = ?';
        DB::table('questions')->insert([
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'answer_key' => 25,
            'challenge_id' => 2,
        ]);
    }
}
