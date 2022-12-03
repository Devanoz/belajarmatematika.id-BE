<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TopikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topiks')->insert([
            'title' => 'Keliling Bangun Datar',
            'slug' => 'keliling-bangun-datar',
            'kelas_id' => 2,
        ]);

        DB::table('topiks')->insert([
            'title' => 'Luas Bangun Datar',
            'slug' => 'luas-bangun-datar',
            'kelas_id' => 2,
        ]);

        DB::table('topiks')->insert([
            'title' => 'Volume Bangun Ruang',
            'slug' => 'volume-bangun-ruang',
            'kelas_id' => 2,
        ]);
    }
}
