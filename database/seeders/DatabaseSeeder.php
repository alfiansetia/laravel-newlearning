<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CompanySeeder::class,
            SliderSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            CourseSeeder::class,
            KeySeeder::class,
            CartSeeder::class,
            QuizSeeder::class,
            QuizOptionSeeder::class,
            ContentSeeder::class,

        ]);
    }
}
