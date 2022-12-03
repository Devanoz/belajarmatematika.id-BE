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
        DB::table('students')->insert([
            'name' => 'Student1',
            'slug' => Str::slug('Student1', '-'),
            'email' => 'student1@gmail.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('students')->insert([
            'name' => 'Student2',
            'slug' => Str::slug('Student2', '-'),
            'email' => 'student2@gmail.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('students')->insert([
            'name' => 'Student3',
            'slug' => Str::slug('Student3', '-'),
            'email' => 'student3@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
