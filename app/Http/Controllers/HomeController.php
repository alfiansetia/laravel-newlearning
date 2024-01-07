<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\Course;
use App\Models\Key;
use App\Models\SubCategory;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // $this->middleware('auth')->except(['home']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_login = $this->getUser();
        if ($user_login->role == 'user') {
            return redirect()->route('index.category');
        }
        if ($user_login->role == 'admin') {
            $user = User::count();
            $category = Category::count();
            $subcategory = SubCategory::count();
            $course = Course::count();
            $courses = Course::select('courses.*', DB::raw('COUNT(transaction_details.id) as purchase_count'))
                ->leftJoin('transaction_details', 'courses.id', '=', 'transaction_details.course_id')
                ->groupBy('courses.id')
                ->orderByDesc('purchase_count')
                ->take(5)->get();
            $transactions = Transaction::latest('id')->take(10)->get();
            return view('home', compact([
                'courses',
                'course',
                'category',
                'subcategory',
                'user',
                'transactions',
            ]));
        } else {
            $key = Key::where('user_id', $user_login->id)->count();
            $course = Course::where('mentor_id', $user_login->id)->count();
            $courses = Course::where('mentor_id', $user_login->id)->latest('id')->take(5)->get();
            $transactions = Transaction::where('user_id', $user_login->id)->latest('id')->take(10)->get();
            $user = $user_login;
            $chat = Chat::orWhere('from_id', $user->id)->orWhere('to_id', $user->id)->count();
            return view('home_mentor', compact([
                'key',
                'courses',
                'course',
                'transactions',
                'user',
                'chat'
            ]));
        }
    }
}
