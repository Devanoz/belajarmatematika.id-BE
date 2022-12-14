<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materis')->insert([
            'title' => 'Volume Kubus',
            'slug' => 'volume-kubus',
            'content' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit.',
            'topik_id' => 3,
        ]);

        DB::table('materis')->insert([
            'title' => 'Volume Balok',
            'slug' => 'volume-balok',
            'content' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit.',
            'topik_id' => 3,
        ]);

        DB::table('materis')->insert([
            'title' => 'Volume Kerucut',
            'slug' => 'volume-kerucut',
            'content' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit.',
            'topik_id' => 3,
        ]);

        DB::table('materis')->insert([
            'title' => 'Volume Limas',
            'slug' => 'volume-limas',
            'content' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit.',
            'topik_id' => 3,
        ]);

        DB::table('materis')->insert([
            'title' => 'Volume Bola',
            'slug' => 'volume-bola',
            'content' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit.',
            'topik_id' => 3,
        ]);
    }
}
