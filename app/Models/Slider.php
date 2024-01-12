<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('/images/slider/' . $value))) {
            return url('/images/slider/' . $value);
        } else {
            return url('/images/default-slider.jpg');
        }
    }
}
