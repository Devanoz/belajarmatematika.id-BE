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
            'title' => 'Volume Kubus Part 1',
            'slug' => 'volume-kubus-part-1',
            'url' => 'https://www.youtube.com/watch?v=xBZV6mpcq2I',
            'materi_id' => 1,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Kubus Part 2',
            'slug' => 'volume-kubus-part-2',
            'url' => 'https://www.youtube.com/watch?v=xBZV6mpcq2I',
            'materi_id' => 1,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Kubus Part 3',
            'slug' => 'volume-kubus-part-3',
            'url' => 'https://www.youtube.com/watch?v=xBZV6mpcq2I',
            'materi_id' => 1,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Balok Part 1',
            'slug' => 'volume-balok-part-1',
            'url' => 'https://www.youtube.com/watch?v=f71arxkGh1o',
            'materi_id' => 2,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Balok Part 2',
            'slug' => 'volume-balok-part-2',
            'url' => 'https://www.youtube.com/watch?v=f71arxkGh1o',
            'materi_id' => 2,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Balok Part 3',
            'slug' => 'volume-balok-part-3',
            'url' => 'https://www.youtube.com/watch?v=f71arxkGh1o',
            'materi_id' => 2,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Kerucut Part 1',
            'slug' => 'volume-kerucut-part-1',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 3,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Kerucut Part 2',
            'slug' => 'volume-kerucut-part-2',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 3,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Kerucut Part 3',
            'slug' => 'volume-kerucut-part-3',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 3,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Limas Part 1',
            'slug' => 'volume-limas-part-1',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 4,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Limas Part 2',
            'slug' => 'volume-limas-part-2',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 4,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Limas Part 3',
            'slug' => 'volume-limas-part-3',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 4,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Bola Part 1',
            'slug' => 'volume-bola-part-1',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 5,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Bola Part 2',
            'slug' => 'volume-bola-part-2',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 5,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Bola Part 3',
            'slug' => 'volume-bola-part-3',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 5,
        ]);
    }
}
