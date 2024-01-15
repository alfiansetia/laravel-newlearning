<?php

namespace Database\Seeders;

use App\Models\Mutation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!file_exists(public_path('images/user'))) {
            File::makeDirectory(public_path('images/user'));
        } else {
            File::cleanDirectory(public_path('images/user'));
        }
        $admin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('admin12345'),
            'role'      => 'admin',
            'email_verified_at' => now(),
            'status'    => 'active',
            'point'     => 50,
            'phone'     => '62855552222555',
            'dob'       => '2002-05-01',
        ]);

        Mutation::create([
            'date'      => now(),
            'user_id'   => $admin->id,
            'type'      => 'plus',
            'value'     => 50,
            'before'    => 0,
            'after'     => 50,
            'desc'      => 'First Point Reward!'
        ]);

        $user =  User::create([
            'name'      => 'User',
            'email'     => 'user@gmail.com',
            'password'  => Hash::make('user12345'),
            'role'      => 'user',
            'email_verified_at' => now(),
            'status'    => 'active',
            'point'     => 50,
            'phone'     => '62855552222555',
            'dob'       => '2002-05-02',
        ]);
        Mutation::create([
            'date'      => now(),
            'user_id'   => $user->id,
            'type'      => 'plus',
            'value'     => 50,
            'before'    => 0,
            'after'     => 50,
            'desc'      => 'First Point Reward!'
        ]);

        $mentor = User::create([
            'name'      => 'Mentor',
            'email'     => 'mentor@gmail.com',
            'password'  => Hash::make('mentor12345'),
            'role'      => 'mentor',
            'email_verified_at' => now(),
            'status'    => 'active',
            'point'     => 50,
            'phone'     => '62855552222555',
            'dob'       => '2002-05-03',
        ]);

        Mutation::create([
            'date'      => now(),
            'user_id'   => $mentor->id,
            'type'      => 'plus',
            'value'     => 50,
            'before'    => 0,
            'after'     => 50,
            'desc'      => 'First Point Reward!'
        ]);

        // User::factory(50)->create();
    }
}
