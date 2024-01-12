<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!file_exists(public_path('images/logo'))) {
            File::makeDirectory(public_path('images/logo'));
        } else {
            File::cleanDirectory(public_path('images/logo'));
        }
        Company::create([
            'name'      => 'CStudy',
            'email'     => 'cs@gmail.com',
            'phone'     => '6288822222255',
            'desc'      => 'Platform Learning Free',
            'address'   => 'Jl. 123 Street, New York, USA',
            'title'     => 'Halo World',
            'subtitle'  => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatem, nisi recusandae, ab ea praesentium fugiat dicta rerum nemo unde dolorum tempora cumque nihil qui fuga optio rem velit quos tenetur!',
        ]);
    }
}
