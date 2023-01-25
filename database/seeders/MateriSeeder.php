<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = "https://www.ima-jateng-diy.com/web/wp-content/uploads/2020/10/MATERI-MATEMATIKA-KELAS-4-BAB-6.pdf";
        $contents = file_get_contents($url);

        $materi = Hash::make(substr($url, strrpos($url, '/') + 1));
        $materi = hash('sha256', $materi) . '.png';
        Storage::put('\public\questions\\' . $materi, $contents);
        DB::table('materis')->insert([
            'title' => 'Keliling Segitiga',
            'slug' => 'keliling-segitiga',
            'content' => $materi,
            'topik_id' => 1,
        ]);

        $materi = Hash::make(substr($url, strrpos($url, '/') + 1));
        $materi = hash('sha256', $materi) . '.png';
        Storage::put('\public\questions\\' . $materi, $contents);
        DB::table('materis')->insert([
            'title' => 'Keliling Persegi',
            'slug' => 'keliling-persegi',
            'content' => $materi,
            'topik_id' => 1,
        ]);

        $materi = Hash::make(substr($url, strrpos($url, '/') + 1));
        $materi = hash('sha256', $materi) . '.png';
        Storage::put('\public\questions\\' . $materi, $contents);
        DB::table('materis')->insert([
            'title' => 'Keliling Persegi Panjang',
            'slug' => 'keliling-persegi-panjang',
            'content' => $materi,
            'topik_id' => 1,
        ]);

        $materi = Hash::make(substr($url, strrpos($url, '/') + 1));
        $materi = hash('sha256', $materi) . '.png';
        Storage::put('\public\questions\\' . $materi, $contents);
        DB::table('materis')->insert([
            'title' => 'Luas Segitiga',
            'slug' => 'luas-segitiga',
            'content' => $materi,
            'topik_id' => 2,
        ]);

        $materi = Hash::make(substr($url, strrpos($url, '/') + 1));
        $materi = hash('sha256', $materi) . '.png';
        Storage::put('\public\questions\\' . $materi, $contents);
        DB::table('materis')->insert([
            'title' => 'Luas Persegi',
            'slug' => 'luas-persegi',
            'content' => $materi,
            'topik_id' => 2,
        ]);

        $materi = Hash::make(substr($url, strrpos($url, '/') + 1));
        $materi = hash('sha256', $materi) . '.png';
        Storage::put('\public\questions\\' . $materi, $contents);
        DB::table('materis')->insert([
            'title' => 'Luas Persegi Panjang',
            'slug' => 'luas-persegi-panjang',
            'content' => $materi,
            'topik_id' => 2,
        ]);

        $materi = Hash::make(substr($url, strrpos($url, '/') + 1));
        $materi = hash('sha256', $materi) . '.png';
        Storage::put('\public\questions\\' . $materi, $contents);
        DB::table('materis')->insert([
            'title' => 'Volume Kubus',
            'slug' => 'volume-kubus',
            'content' => $materi,
            'topik_id' => 3,
        ]);

        $materi = Hash::make(substr($url, strrpos($url, '/') + 1));
        $materi = hash('sha256', $materi) . '.png';
        Storage::put('\public\questions\\' . $materi, $contents);
        DB::table('materis')->insert([
            'title' => 'Volume Balok',
            'slug' => 'volume-balok',
            'content' => $materi,
            'topik_id' => 3,
        ]);

        $materi = Hash::make(substr($url, strrpos($url, '/') + 1));
        $materi = hash('sha256', $materi) . '.png';
        Storage::put('\public\questions\\' . $materi, $contents);
        DB::table('materis')->insert([
            'title' => 'Volume Bola',
            'slug' => 'volume-bola',
            'content' => $materi,
            'topik_id' => 3,
        ]);
    }
}
