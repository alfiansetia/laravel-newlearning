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

    public function getImageMateriAttribute($value)
    {
        if ($value && file_exists(public_path('/images/content/' . $value))) {
            return url('/images/content/' . $value);
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

    public function userScore()
    {
        $user = auth()->user();
        if (!$user) {
            return 0;
        }
        $quiz = QuizUserAnswer::where('course_id', $this->id)
            ->where('user_id', $user->id)->first();
        return $quiz->value ?? 0;
    }

    public function userProgres()
    {
        $user = auth()->user();
        if (!$user) {
            return 0;
        }
        $content = $this->contents;
        $total  = count($content) + 2;
        $progres_content = 0;
        if (!$content->isEmpty()) {
            $progres_content = Progres::whereHas('content', function ($query) use ($content) {
                $query->whereIn('id', $content->pluck('id'));
            })->where('user_id', $user->id)->count();
        }
        $progres_course = Progres::where('course_id', $this->id)->where('user_id', $user->id)->exists() ? 1 : 0;
        $progres_quiz = Progres::where('quiz_id', $this->id)->where('user_id', $user->id)->exists() ? 1 : 0;

        $total_progress = $progres_content + $progres_course + $progres_quiz;

        $percentage = ($total_progress / $total) * 100;
        return $percentage;
    }

    public function isCourseDoneUser()
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        return Progres::where('course_id', $this->id)
            ->where('user_id', $user->id)->exists();
    }

    public function isContentDoneUser($id)
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        return Progres::where('content_id', $id)
            ->where('user_id', $user->id)->exists();
    }

    public function isQuizDoneUser($id)
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        return Progres::where('quiz_id', $id)
            ->where('user_id', $user->id)->exists();
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
