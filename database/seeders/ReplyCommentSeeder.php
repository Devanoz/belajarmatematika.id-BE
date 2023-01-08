<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ReplyCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 15; $i++){
            DB::table('reply_comments')->insert([
                'comment_id' => $i,
                'teacher_id' => 1,
                'title' => 'kamu naenya?',
            ]);
        }

        for($i = 1; $i <= 15; $i++){
            DB::table('reply_comments')->insert([
                'comment_id' => $i,
                'student_id' => 1,
                'title' => 'kamu bertaenya-taenya?',
            ]);
        }
    }
}
