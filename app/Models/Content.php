<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getFileAttribute($value)
    {
        if ($value && file_exists(public_path('/videos/content/' . $value))) {
            return url('/videos/content/' . $value);
        } else {
            return url('/videos/default.mp4');
        }
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
