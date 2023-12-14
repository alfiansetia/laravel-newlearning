<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('admin12345'),
            'role'      => 'admin',
            'email_verified_at' => now(),
            'status'    => 'active',
            'point'     => 100,
        ]);

        User::create([
            'name'      => 'User',
            'email'     => 'user@gmail.com',
            'password'  => Hash::make('user12345'),
            'role'      => 'user',
            'email_verified_at' => now(),
            'status'    => 'active',
            'point'     => 100,
        ]);

        User::create([
            'name'      => 'Mentor',
            'email'     => 'mentor@gmail.com',
            'password'  => Hash::make('mentor12345'),
            'role'      => 'mentor',
            'email_verified_at' => now(),
            'status'    => 'active',
            'point'     => 100,
        ]);

        User::factory(50)->create();
    }
}
