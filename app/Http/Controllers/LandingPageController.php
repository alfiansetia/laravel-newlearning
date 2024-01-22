<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Slider;
use App\Models\User;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    use CompanyTrait;

    public function index()
    {
        $user = $this->getUser();
        if ($user) {
            if ($user->role == 'admin') {
                return redirect('home');
            }
        }
        $courses = Course::where('status', 'publish')->with('mentor')->withCount('rates', 'comments', 'transaction_details')->orderBy('id', 'DESC')->paginate(3);
        $categories = Category::with(['subcategories' => function ($query) {
            $query->withCount('courses');
        }])
            ->orderBy('id', 'DESC')
            ->take(4)
            ->get();

        $categories->each(function ($category) {
            $totalCourses = $category->subcategories->sum('courses_count');
            $category->total_courses = $totalCourses;
        });

        $mentors = User::where('role', 'mentor')->orderBy('id', 'DESC')->paginate(4);
        $comments = Comment::with('user')->orderBy('id', 'DESC')->paginate(4);
        $sliders = Slider::where('show', 'yes')->get();
        return view('landing.index', compact('courses', 'categories', 'mentors', 'comments', 'sliders'));
    }

    public function course()
    {
        $courses = Course::where('status', 'publish')->with('mentor')->withCount('rates', 'comments', 'transaction_details')->orderBy('id', 'DESC')->paginate(3);
        $categories = Category::with(['subcategories' => function ($query) {
            $query->withCount('courses');
        }])->orderBy('id', 'DESC')->take(4)->get();

        $categories->each(function ($category) {
            $totalCourses = $category->subcategories->sum('courses_count');
            $category->total_courses = $totalCourses;
        });
        $comments = Comment::with('user')->orderBy('id', 'DESC')->paginate(4);
        return view('landing.course', compact('courses', 'categories', 'comments'));
    }

    public function about()
    {
        $company = $this->getCompany();
        $mentors = User::where('role', 'mentor')->orderBy('id', 'DESC')->paginate(4);
        return view('landing.about', compact('mentors', 'company'));
    }

    public function team()
    {
        $mentors = User::where('role', 'mentor')->orderBy('id', 'DESC')->paginate(8);
        return view('landing.team', compact('mentors'));
    }

    public function contact()
    {
        return view('landing.contact');
    }

    public function testi()
    {
        $comments = Comment::with('user')->orderBy('id', 'DESC')->paginate(4);
        return view('landing.testi', compact('comments'));
    }
}
