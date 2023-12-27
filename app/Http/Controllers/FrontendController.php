<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Key;
use App\Models\Progres;
use App\Models\QuizOption;
use App\Models\QuizUserAnswer;
use App\Models\Rate;
use App\Models\SubCategory;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $data = $course->load('subcategory.category', 'rates', 'comments')->loadCount('rates', 'comments');
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
            'date'      => date('Y-m-d H:i:s'),
            'course_id' => $course->id,
            'value'     => $score_percentage,
        ]);
        return redirect()->back()->with(['success' => 'Answer Saved! Your Score : ' . $score_percentage]);
    }

    public function saveProgres(Request $request)
    {
        $this->validate($request, [
            'type'      => 'required|in:content,course,quiz',
        ]);
        $user = $this->getUser();
        if ($request->type === 'content') {
            Progres::updateOrCreate([
                'user_id' => $user->id,
                'content_id' => $request->content,
            ], [
                'user_id' => $user->id,
                'content_id' => $request->content,
            ]);
        } else if ($request->type === 'course') {
            Progres::updateOrCreate([
                'user_id'   => $user->id,
                'course_id' => $request->course,
            ], [
                'user_id'   => $user->id,
                'course_id' => $request->course,
            ]);
        } else if ($request->type === 'quiz') {
            Progres::updateOrCreate([
                'user_id'   => $user->id,
                'quiz_id' => $request->quiz,
            ], [
                'user_id'   => $user->id,
                'quiz_id' => $request->quiz,
            ]);
        }
        return redirect()->back()->with(['success' => 'Progres Saved!']);
    }

    public function saveTransaction(Request $request)
    {
        $user = $this->getUser();
        $carts = Cart::with('course')->where('User_id', $user->id)->get();
        if (count($carts) < 1) {
            return redirect()->back()->with(['error' => 'Empty Cart!']);
        }
        $total = 0;
        foreach ($carts as $item) {
            $total += $item->course->price;
        }
        if ($user->point < $total) {
            return redirect()->back()->with(['error' => 'Not Enough Token!']);
        }
        $trx = Transaction::create([
            'user_id'   => $user->id,
            'date'      => date('Y-m-d H:i:s'),
            'number'    => Str::random(10),
            'total'     => $total,
            'status'    => 'success',
        ]);

        foreach ($carts as $item) {
            TransactionDetail::create([
                'transaction_id'    => $trx->id,
                'course_id'         => $item->course_id,
                'price'             => $item->course->price,
            ]);
            $item->delete();
        }
        $new_point = $user->point - $total;
        $user->update([
            'point' => $new_point,
        ]);
        return redirect()->back()->with(['success' => 'Payment Successfull !']);
    }

    public function withKey(Request $request, Course $course)
    {
        $user = $this->getUser();
        $key = Key::where('user_id', $user->id)->where('status', 'available')->find($request->key);
        if (!$key) {
            return redirect()->back()->with(['error' => 'Key not Valid!']);
        }

        $trx = Transaction::create([
            'user_id'   => $user->id,
            'date'      => date('Y-m-d H:i:s'),
            'number'    => Str::random(10),
            'total'     => $course->price,
            'status'    => 'success',
        ]);

        TransactionDetail::create([
            'transaction_id'    => $trx->id,
            'course_id'         => $course->id,
            'price'             => $course->price,
        ]);
        $mentor = $course->mentor;
        if ($mentor) {
            $mentor->update([
                'point' => $mentor->point + ($course->price / 2)
            ]);
        }
        $key->update([
            'status' => 'unavailable',
        ]);
        return redirect()->back()->with(['success' => 'Reedem Success!']);
    }

    public function rate(Request $request, Course $course)
    {
        $this->validate($request, [
            'comment'   => 'required|max:250',
            'rate'      => 'required|min:1|max:5',
        ]);
        $user = $this->getUser();
        if ($course->userRate() || $course->userComment()) {
            return redirect()->back()->with(['error' => 'Your Rate or Comment is already!']);
        }
        Comment::create([
            'user_id'   => $user->id,
            'course_id' => $course->id,
            'value'     => $request->comment,
        ]);
        Rate::create([
            'user_id'   => $user->id,
            'course_id' => $course->id,
            'value'     => $request->rate,
        ]);
        return redirect()->back()->with(['success' => 'Comment and Rate Saved!']);
    }

    public function chat()
    {
        $user = $this->getUser();
        $data = Chat::with('messages')->withCount('messages')->orWhere('from_id', $user->id)->orWhere('to_id', $user->id)->get();
        $detail = null;
        return view('frontend.chat', compact([
            'data',
            'detail'
        ]));
    }

    public function chatDetail(Chat $chat)
    {
        $user = $this->getUser();
        $data = Chat::with('messages')->withCount('messages')->orWhere('from_id', $user->id)->orWhere('to_id', $user->id)->get();
        $detail = $chat->load('messages.sender');
        return view('frontend.chat', compact([
            'data',
            'detail'
        ]));
    }

    public function saveChat(Request $request, Chat $chat)
    {
        $this->validate($request, [
            'message'   => 'required|max:250'
        ]);
        $user = $this->getUser();
        ChatMessage::create([
            'chat_id'   => $chat->id,
            'message'   => $request->message,
            'sender_id' => $user->id,
        ]);
        $data = Chat::with('messages')->withCount('messages')->orWhere('from_id', $user->id)->orWhere('to_id', $user->id)->get();
        $detail = $chat->load('messages.sender');
        return view('frontend.chat', compact([
            'data',
            'detail'
        ]));
    }
}
