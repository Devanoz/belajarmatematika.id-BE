<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Teachers
        DB::table('teachers')->insert([
            'name' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make('password'),
        ]);

        //Students
        DB::table('students')->insert([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => Hash::make('password'),
        ]);

        //Kelas
        for ($i = 4; $i <= 6; $i++) {
            DB::table('kelas')->insert([
                'title' => 'Kelas ' . $i,
                'slug' => 'kelas-' . $i,
            ]);
        }

        //Topiks
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

        //Materis
        DB::table('materis')->insert([
            'title' => 'Volume Kubus',
            'slug' => 'volume-kubus',
            'content' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic, atque a. Deserunt maxime facilis delectus, beatae accusantium eius enim soluta temporibus vel sit ab quasi harum tempore eos? Natus nulla beatae tempore vitae error numquam reprehenderit aliquid iste eum illum blanditiis corporis aspernatur adipisci, quia quibusdam vel, culpa dicta laboriosam architecto iure enim! Beatae animi rem nihil fugiat rerum quis, ullam dolorum quaerat! Consequuntur labore distinctio dolores reprehenderit aperiam. Eius placeat iste harum minima libero excepturi dolore suscipit eos non facilis, incidunt architecto, quo accusamus autem, nesciunt cumque eum tempore sequi quis consequuntur consectetur enim. Nesciunt eaque iste ad cumque?',
            'topik_id' => 3,
        ]);

        DB::table('materis')->insert([
            'title' => 'Volume Balok',
            'slug' => 'volume-balok',
            'content' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic, atque a. Deserunt maxime facilis delectus, beatae accusantium eius enim soluta temporibus vel sit ab quasi harum tempore eos? Natus nulla beatae tempore vitae error numquam reprehenderit aliquid iste eum illum blanditiis corporis aspernatur adipisci, quia quibusdam vel, culpa dicta laboriosam architecto iure enim! Beatae animi rem nihil fugiat rerum quis, ullam dolorum quaerat! Consequuntur labore distinctio dolores reprehenderit aperiam. Eius placeat iste harum minima libero excepturi dolore suscipit eos non facilis, incidunt architecto, quo accusamus autem, nesciunt cumque eum tempore sequi quis consequuntur consectetur enim. Nesciunt eaque iste ad cumque?',
            'topik_id' => 3,
        ]);

        DB::table('materis')->insert([
            'title' => 'Volume Kerucut',
            'slug' => 'volume-kerucut',
            'content' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic, atque a. Deserunt maxime facilis delectus, beatae accusantium eius enim soluta temporibus vel sit ab quasi harum tempore eos? Natus nulla beatae tempore vitae error numquam reprehenderit aliquid iste eum illum blanditiis corporis aspernatur adipisci, quia quibusdam vel, culpa dicta laboriosam architecto iure enim! Beatae animi rem nihil fugiat rerum quis, ullam dolorum quaerat! Consequuntur labore distinctio dolores reprehenderit aperiam. Eius placeat iste harum minima libero excepturi dolore suscipit eos non facilis, incidunt architecto, quo accusamus autem, nesciunt cumque eum tempore sequi quis consequuntur consectetur enim. Nesciunt eaque iste ad cumque?',
            'topik_id' => 3,
        ]);

        DB::table('materis')->insert([
            'title' => 'Volume Limas',
            'slug' => 'volume-limas',
            'content' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic, atque a. Deserunt maxime facilis delectus, beatae accusantium eius enim soluta temporibus vel sit ab quasi harum tempore eos? Natus nulla beatae tempore vitae error numquam reprehenderit aliquid iste eum illum blanditiis corporis aspernatur adipisci, quia quibusdam vel, culpa dicta laboriosam architecto iure enim! Beatae animi rem nihil fugiat rerum quis, ullam dolorum quaerat! Consequuntur labore distinctio dolores reprehenderit aperiam. Eius placeat iste harum minima libero excepturi dolore suscipit eos non facilis, incidunt architecto, quo accusamus autem, nesciunt cumque eum tempore sequi quis consequuntur consectetur enim. Nesciunt eaque iste ad cumque?',
            'topik_id' => 3,
        ]);

        DB::table('materis')->insert([
            'title' => 'Volume Bola',
            'slug' => 'volume-bola',
            'content' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic, atque a. Deserunt maxime facilis delectus, beatae accusantium eius enim soluta temporibus vel sit ab quasi harum tempore eos? Natus nulla beatae tempore vitae error numquam reprehenderit aliquid iste eum illum blanditiis corporis aspernatur adipisci, quia quibusdam vel, culpa dicta laboriosam architecto iure enim! Beatae animi rem nihil fugiat rerum quis, ullam dolorum quaerat! Consequuntur labore distinctio dolores reprehenderit aperiam. Eius placeat iste harum minima libero excepturi dolore suscipit eos non facilis, incidunt architecto, quo accusamus autem, nesciunt cumque eum tempore sequi quis consequuntur consectetur enim. Nesciunt eaque iste ad cumque?',
            'topik_id' => 3,
        ]);

        //Videos
        DB::table('videos')->insert([
            'title' => 'Volume Kubus',
            'slug' => 'volume-kubus',
            'url' => 'https://www.youtube.com/watch?v=xBZV6mpcq2I',
            'materi_id' => 1,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Kubus',
            'slug' => 'volume-kubus',
            'url' => 'https://www.youtube.com/watch?v=f71arxkGh1o',
            'materi_id' => 2,
        ]);

        DB::table('videos')->insert([
            'title' => 'Volume Kerucut',
            'slug' => 'volume-kerucut',
            'url' => 'https://www.youtube.com/watch?v=ZWP4qyZPRE4',
            'materi_id' => 3,
        ]);
    }
}
