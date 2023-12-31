<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('/images/category/' . $value))) {
            return url('/images/category/' . $value);
        } else {
            return url('/images/default.jpg');
        }
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
