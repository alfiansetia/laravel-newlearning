<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\SubCategory;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    use CompanyTrait;

    public function index()
    {
        $categories = Category::paginate(8);
        $subcategories = SubCategory::all();
        $courses = Course::all();
        return view('welcome', compact([
            'categories',
            'subcategories',
            'courses',
        ]));
    }

    public function courseList()
    {
        $courses = Course::with('subcategory.category')->paginate(9);
        return view('frontend.course_list', compact([
            'courses',
        ]));
    }

    public function courseDetail(Course $course)
    {
        $data = $course->load('subcategory.category');
        return view('frontend.course_detail', compact([
            'data',
        ]));
    }

    public function courseOpen(Course $course)
    {
        $data = $course->load('subcategory.category', 'contents', 'quizzes.options')->loadCount('contents', 'quizzes');
        return view('frontend.course_open', compact([
            'data',
        ]));
    }

    public function category(Category $category)
    {
        $data = $category->load('subcategories.courses');
        return view('frontend.subcategory_list', compact([
            'data',
        ]));
    }

    public function profile()
    {
        return view('frontend.profile');
    }

    public function profileUpdate(Request $request)
    {
        $user = $this->getUser();
        $this->validate($request, [
            'name'      => 'required|max:50',
            'phone'     => 'required|max:15',
            'dob'       => 'required|date_format:Y-m-d',
            'gender'    => 'required|in:Male,Female',
            'country'   => 'required|max:30',
        ]);

        $user->update([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'dob'       => $request->dob,
            'gender'    => $request->gender,
            'country'   => $request->country,
        ]);
        return redirect()->route('index.profile')->with(['success' => 'Update Profile Success']);
    }
}
