<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('videos')->insert([
            'title' => 'Volume Kubus',
            'slug' => 'volume-kubus',
            'url' => 'https://www.youtube.com/watch?v=xBZV6mpcq2I',
            'materi_id' => 1,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Kubus',
            'slug' => 'volume-kubus',
            'url' => 'https://www.youtube.com/watch?v=f71arxkGh1o',
            'materi_id' => 2,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Kerucut',
            'slug' => 'volume-kerucut',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 3,
        ]);
    }
}
