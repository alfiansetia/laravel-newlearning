<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $mentors = User::where('role', 'mentor')->where('status', 'active')->get();

        for ($i = 0; $i < 50; $i++) {
            Course::factory()->create([
                'category_id' => $categories->random()->id,
                'mentor_id' => $mentors->random()->id,
            ]);
        }
    }
}
