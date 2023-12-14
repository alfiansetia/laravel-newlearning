<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('/images/course/' . $value))) {
            return url('/images/course/' . $value);
        } else {
            return url('/images/default.jpg');
        }
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
