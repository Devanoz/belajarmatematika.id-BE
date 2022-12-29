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

        for($i = 1; $i <= 3; $i++){
            DB::table('challenges')->insert([
                'title' => 'Volume Kubus ' . $i,
                'slug' => Str::slug('Volume Kubus ' . $i, '-'),
                'materi_id' => 1,
            ]);
        }

        for($i = 1; $i <= 3; $i++){
            DB::table('challenges')->insert([
                'title' => 'Volume Balok ' . $i,
                'slug' => Str::slug('Volume Balok ' . $i, '-'),
                'materi_id' => 2,
            ]);
        }
        
        for($i = 1; $i <= 3; $i++){
            DB::table('challenges')->insert([
                'title' => 'Volume Kerucut ' . $i,
                'slug' => Str::slug('Volume Kerucut ' . $i, '-'),
                'materi_id' => 3,
            ]);
        }

        for($i = 1; $i <= 3; $i++){
            DB::table('challenges')->insert([
                'title' => 'Volume Limas ' . $i,
                'slug' => Str::slug('Volume Limas ' . $i, '-'),
                'materi_id' => 4,
            ]);
        }

        for($i = 1; $i <= 3; $i++){
            DB::table('challenges')->insert([
                'title' => 'Volume Bola ' . $i,
                'slug' => Str::slug('Volume Bola ' . $i, '-'),
                'materi_id' => 5,
            ]);
        }
    }
}
