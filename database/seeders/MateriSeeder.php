<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MateriSeeder extends Seeder
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

        $url = "https://www.ima-jateng-diy.com/web/wp-content/uploads/2020/10/MATERI-MATEMATIKA-KELAS-4-BAB-6.pdf";
        $contents = file_get_contents($url);

        for($i = 0; $i < count($title); $i++){
            $materi = Hash::make(substr($url, strrpos($url, '/') + $i + 1));
            $materi = hash('sha256', $materi) . '.pdf';
            Storage::put('\public\materis\\' . $materi, $contents);
            DB::table('materis')->insert([
                'title' =>  $title[$i],
                'slug' => Str::slug($title[$i], '-'),
                'content' => $materi,
                'topik_id' => (int) ($i / 3) + 1,
            ]);
        }
    }
}
