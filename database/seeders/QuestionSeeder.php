<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = "https://www.meme-arsenal.com/memes/467270f378675f0ed531fdb3a7983ac8.jpg";
        $contents = file_get_contents($url);

        for($i = 1; $i <= 27; $i++){
            $image = Hash::make(substr($url, strrpos($url, '/') + $i));
            $image = hash('sha256', $image) . '.png';
            Storage::put('\public\questions\\' . $image, $contents);
            $title = '3 + 3 = ?';
            DB::table('questions')->insert([
                'title' => $title,
                'slug' => Str::slug($title, '-'),
                'image' => $image, 
                'answer_key' => 'C',
                'is_pilihan_ganda' => true,
                'challenge_id' => $i,
                'created_at' => Carbon::now()->addSecond($i + 1),
            ]);

            $title = '4 + 4 = ?';
            DB::table('questions')->insert([
                'title' => $title,
                'slug' => Str::slug($title, '-'),
                'answer_key' => 'A',
                'is_pilihan_ganda' => true,
                'challenge_id' => $i,
                'created_at' => Carbon::now()->addSecond($i + 2),
            ]);

            $image = Hash::make(substr($url, strrpos($url, '/') + $i));
            $image = hash('sha256', $image) . '.png';
            Storage::put('\public\questions\\' . $image, $contents);
            $title = '5 + 5 = ?';
            DB::table('questions')->insert([
                'title' => $title,
                'slug' => Str::slug($title, '-'),
                'image' => $image, 
                'answer_key' => '10',
                'is_pilihan_ganda' => false,
                'challenge_id' => $i,
                'created_at' => Carbon::now()->addSecond($i + 3),
            ]);

            $title = '3 x 3 = ?';
            DB::table('questions')->insert([
                'title' => $title,
                'slug' => Str::slug($title, '-'),
                'answer_key' => 'C',
                'is_pilihan_ganda' => true,
                'challenge_id' => $i,
                'created_at' => Carbon::now()->addSecond($i + 4),
            ]);

            $image = Hash::make(substr($url, strrpos($url, '/') + $i));
            $image = hash('sha256', $image) . '.png';
            Storage::put('\public\questions\\' . $image, $contents);
            $title = '4 x 4 = ?';
            DB::table('questions')->insert([
                'title' => $title,
                'slug' => Str::slug($title, '-'),
                'image' => $image,
                'answer_key' => 'D',
                'is_pilihan_ganda' => true,
                'challenge_id' => $i,
                'created_at' => Carbon::now()->addSecond($i + 5),
            ]);
            
            $title = '5 x 5 = ?';
            DB::table('questions')->insert([
                'title' => $title,
                'slug' => Str::slug($title, '-'),
                'answer_key' => '25',
                'is_pilihan_ganda' => false,
                'challenge_id' => $i,
                'created_at' => Carbon::now()->addSecond($i + 6),
            ]);
        }
    }
}