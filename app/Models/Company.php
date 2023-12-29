<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getLogoAttribute($value)
    {
        if ($value && file_exists(public_path('/images/' . $value))) {
            return url('/images/logo/' . $value);
        } else {
            return url('/images/logo.jpg');
        }
    }
}
