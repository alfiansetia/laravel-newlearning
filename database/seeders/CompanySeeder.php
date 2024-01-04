<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name'      => 'C Study',
            'email'     => 'cs@gmail.com',
            'phone'     => '6288822222255',
            'desc'      => 'Platform Learning Free',
            'address'   => 'Jl. 123 Street, New York, USA',
            'title'     => 'Halo World',
            'subtitle'  => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatem, nisi recusandae, ab ea praesentium fugiat dicta rerum nemo unde dolorum tempora cumque nihil qui fuga optio rem velit quos tenetur!',
        ]);
    }
}
