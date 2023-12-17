<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quizzez = Quiz::all();
        foreach ($quizzez as $item) {
            $answ = rand(0, 4);
            for ($i = 0; $i < 5; $i++) {
                $is_answer = 'no';
                if ($i === $answ) {
                    $is_answer = 'yes';
                }
                QuizOption::factory()->create([
                    'quiz_id'   => $item->id,
                    'is_answer' => $is_answer
                ]);
            }
        }
    }
}
