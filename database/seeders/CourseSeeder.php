<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\SubCategory;
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
        $subcategories = SubCategory::all();
        $mentors = User::where('role', 'mentor')->where('status', 'active')->get();

        foreach ($subcategories as $key => $value) {
            for ($i = 0; $i < 4; $i++) {
                Course::factory()->create([
                    'subcategory_id' => $value->id,
                    'mentor_id'      => $mentors->random()->id,
                ]);
            }
        }
    }
}
