<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $key => $value) {
            for ($i = 0; $i < 5; $i++) {
                Quiz::factory()->create([
                    'course_id' => $value->id
                ]);
            }
        }
    }
}
