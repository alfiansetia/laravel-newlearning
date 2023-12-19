<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\QuizOption;
use App\Models\QuizUserAnswer;
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
        ]);

        $user->update([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'dob'       => $request->dob,
            'gender'    => $request->gender,
        ]);
        return redirect()->route('index.profile')->with(['success' => 'Update Profile Success']);
    }

    public function saveAnswer(Request $request, Course $course)
    {
        $this->validate($request, [
            'answer'    => 'array|required',
            'answer.*' => 'required|integer|exists:quiz_options,id'
        ]);
        $user = $this->getUser();
        $correct_answer = 0;
        foreach ($request->answer as $key => $value) {
            $option = QuizOption::find($value);
            if ($option) {
                if ($option->is_answer === 'yes') {
                    $correct_answer += 1;
                }
            }
        }
        $total_questions = count($course->quizzes ?? []);
        $score_percentage = ($correct_answer / $total_questions) * 100;
        $score_percentage = min($score_percentage, 100);
        QuizUserAnswer::updateOrCreate([
            'user_id'   => $user->id,
            'course_id' => $course->id
        ], [
            'iser_id'   => $user->id,
            'course_id' => $course->id,
            'value'     => $score_percentage,
        ]);
        return redirect()->back()->with(['success' => 'Answer Saved! Your Score : ' . $score_percentage]);
    }
}
