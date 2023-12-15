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

    public function isPurchasedByUser()
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        return TransactionDetail::where('course_id', $this->id)
            ->whereRelation('transaction', 'user_id', $user->id)
            ->exists();
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function progres()
    {
        return $this->hasOne(Progres::class);
    }
}
