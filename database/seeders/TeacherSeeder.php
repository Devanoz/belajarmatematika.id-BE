<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->insert([
            'name' => 'Admin',
            'slug' => Str::slug('Admin', '-'),
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        for($i = 1; $i <= 3; $i++){
            DB::table('teachers')->insert([
                'name' => 'Teacher ' . $i,
                'slug' => Str::slug('Teacher ' . $i, '-'),
                'email' => 'teacher' . $i . '@gmail.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
