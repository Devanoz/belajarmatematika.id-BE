<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = [
            'Keliling Segitiga',
            'Keliling Persegi',
            'Keliling Persegi Panjang',
            'Luas Segitiga',
            'Luas Persegi',
            'Luas Persegi Panjang',
            'Volume Kubus',
            'Volume Balok',
            'Volume Bola',
        ];

        for($i = 1; $i <= count($title); $i++){
            for($j = 1; $j <= 3; $j++){
                DB::table('videos')->insert([
                    'title' => $title[$i - 1] . ' Part ' . $j,
                    'slug' => Str::slug($title[$i - 1] . ' Part ' . $j, '-'),
                    'url' => 'https://www.youtube.com/watch?v=xBZV6mpcq2I',
                    'materi_id' => $i,
                ]);
            }
        }   
    }
}
