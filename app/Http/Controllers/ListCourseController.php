<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SubCategory;
use App\Models\User;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;

class ListCourseController extends Controller
{
    use CompanyTrait;

    public function index(Request $request)
    {
        $user = $this->getUser();
        $query = Course::query();
        if ($request->filled('search')) {
            $query->orWhere('name', 'like', "%$request->search%");
        }
        if ($request->filled('subcat')) {
            $query->where('subcategory_id', $request->subcat);
        }
        $data = $query->where('mentor_id', $user->id)->with('subcategory')->withCount('contents')->paginate(10)->withQueryString();
        $subcategories = SubCategory::all();
        return view('course.index', compact('data', 'subcategories', 'user'));
    }

    public function stepCreate()
    {
        $subcategories = SubCategory::all();
        return view('course.step.create', compact('subcategories'));
    }

    public function stepEdit(Course $course)
    {
        $subcategories = SubCategory::all();
        $data = $course->load('subcategory.category', 'mentor');
        return view('course.step.edit', compact('subcategories', 'data'));
    }

    public function stepContent(Course $course)
    {
        $course->load('contents');
        return view('course.step.content', compact('course'));
    }

    public function stepQuiz(Course $course)
    {
        $course->load('quizzes')->loadCount('quizzes');
        return view('course.step.quiz', compact('course'));
    }
}
