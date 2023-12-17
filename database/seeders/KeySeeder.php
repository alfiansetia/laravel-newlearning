<?php

namespace Database\Seeders;

use App\Models\Key;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_ids = [1, 2, 3];

        foreach ($user_ids as $key => $value) {
            for ($i = 0; $i < 3; $i++) {
                Key::factory()->create([
                    'user_id'   => $value,
                    'status'    => 'available'
                ]);
            }
        }
    }
}
