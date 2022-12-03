<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 4; $i <= 6; $i++) {
            DB::table('kelas')->insert([
                'title' => 'Kelas ' . $i,
                'slug' => 'kelas-' . $i,
            ]);
        }
    }
}
