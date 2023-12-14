<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\SubCategory;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    use CompanyTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['home']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with(['company' => $this->getCompany()]);;
    }

    public function home()
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
}
