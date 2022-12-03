<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('challenges')->insert([
            'title' => 'Volume Kerucut',
            'slug' => Str::slug('Volume Kerucut', '-'),
            'materi_id' => 1,
        ]);

        DB::table('challenges')->insert([
            'title' => 'Volume Bola',
            'slug' => Str::slug('Volume Bola', '-'),
            'materi_id' => 1,
        ]);

        DB::table('challenges')->insert([
            'title' => 'Volume Limas',
            'slug' => Str::slug('Volume Limas', '-'),
            'materi_id' => 1,
        ]);
    }
}
