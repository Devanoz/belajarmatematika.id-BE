<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 15; $i++){
            DB::table('comments')->insert([
                'video_id' => $i,
                'student_id' => 20,
                'title' => 'apaan tuh?',
            ]);
        }
    }
}
