<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!file_exists(public_path('images/course'))) {
            File::makeDirectory(public_path('images/course'));
        } else {
            File::cleanDirectory(public_path('images/course'));
        }
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
