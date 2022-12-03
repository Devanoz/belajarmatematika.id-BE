<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TeacherSeeder::class,
            StudentSeeder::class,
            KelasSeeder::class,
            TopikSeeder::class,
            MateriSeeder::class,
            VideoSeeder::class,
            ChallengeSeeder::class,
            QuestionSeeder::class,
            OptionSeeder::class,
            StudentChallengeSeeder::class,
        ]);
    }
}
