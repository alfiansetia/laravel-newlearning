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
        ]))->with(['company' => $this->getCompany()]);;
    }

    public function courseList()
    {
        $courses = Course::with('subcategory.category')->paginate(9);
        return view('frontend.course_list', compact([
            'courses',
        ]))->with(['company' => $this->getCompany()]);;
    }

    public function courseDetail(Course $course)
    {
        $data = $course->load('subcategory.category');
        return view('frontend.course_detail', compact([
            'data',
        ]))->with(['company' => $this->getCompany()]);;
    }

    public function category(Category $category)
    {
        $data = $category->load('subcategories.courses');
        return view('frontend.subcategory_list', compact([
            'data',
        ]))->with(['company' => $this->getCompany()]);
    }

    public function profile()
    {
        return view('frontend.profile')->with(['company' => $this->getCompany()]);
    }
}
