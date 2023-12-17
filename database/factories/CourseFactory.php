<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => fake()->name(),
            'subtitle'      => fake()->text(100),
            'slug'          => fake()->slug(3),
            'price'         => fake()->randomDigitNotZero(),
            'image_materi'  => null,
            'header_materi' => fake()->title(),
            'materi_detail' => fake()->text(500),
        ];
    }
}
