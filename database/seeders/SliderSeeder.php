<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!file_exists(public_path('images/slider'))) {
            File::makeDirectory(public_path('images/slider'));
        } else {
            File::cleanDirectory(public_path('images/slider'));
        }
        Slider::factory(2)->create([
            'show' => 'yes'
        ]);
    }
}
