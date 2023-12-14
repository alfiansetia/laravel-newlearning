<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();
        for ($i = 0; $i < 5; $i++) {
            Cart::create([
                'user_id'   => 1,
                'course_id' => $courses->random()->id,
            ]);
        }
    }
}
