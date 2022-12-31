<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 20; $i++){
            DB::table('students')->insert([
            'name' => 'Student' . $i,
            'slug' => Str::slug('Student' . $i, '-'),
            'email' => 'student' . $i . '@gmail.com',
            'password' => Hash::make('password'),
        ]);

        }
    }
}
