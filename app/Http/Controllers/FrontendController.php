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
use App\Models\Topup;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\UpgradeUser;
use App\Models\User;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    use CompanyTrait;

    public function index()
    {
        $categories = Category::all();
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

    public function upgrade()
    {
        $user = $this->getUser();
        $data = UpgradeUser::firstOrCreate([
            'user_id' => $user->id,
        ], [
            'user_id' => $user->id,
        ]);
        return view('frontend.upgrade', compact('data'));
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
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $image = $user->getRawOriginal('image');
        if ($files = $request->file('image')) {
            $image = 'user_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('images/user/'), $image);
        }

        $user->update([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'dob'       => $request->dob,
            'gender'    => $request->gender,
            'image'     => $image,
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
        if ($score_percentage == 100) {
            foreach ($course->contents as $key => $value) {
                Progres::updateOrCreate([
                    'user_id'    => $user->id,
                    'content_id' => $value->id,
                ], [
                    'user_id'    => $user->id,
                    'content_id' => $value->id,
                ]);
            }
            Progres::updateOrCreate([
                'user_id'   => $user->id,
                'course_id' => $course->id,
            ], [
                'user_id'   => $user->id,
                'course_id' => $course->id,
            ]);
            Progres::updateOrCreate([
                'user_id'   => $user->id,
                'quiz_id'   => $request->quiz,
            ], [
                'user_id'   => $user->id,
                'quiz_id'   => $course->id,
            ]);
            $user_point = $user->point;
            $user->update([
                'point' => $user_point + 25,
            ]);
        }
        QuizUserAnswer::updateOrCreate([
            'user_id'   => $user->id,
            'course_id' => $course->id
        ], [
            'user_id'   => $user->id,
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
            return redirect()->back()->with(['error' => 'Not Enough Point!']);
        }
        $trx = Transaction::create([
            'user_id'   => $user->id,
            'date'      => date('Y-m-d H:i:s'),
            'number'    => Str::random(10),
            'total'     => $total,
            'status'    => 'success',
        ]);

        foreach ($carts as $item) {
            $price = $item->course->price;
            $reward = ceil($price / 2);
            if ($price == 1) {
                $reward = 1;
            }
            $mentor = $item->course->mentor;
            if ($mentor) {
                $mentor->update([
                    'point' => $mentor->point + $reward
                ]);
            }
            TransactionDetail::create([
                'transaction_id'    => $trx->id,
                'course_id'         => $item->course_id,
                'price'             => $price,
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
        $price = $course->price;
        $reward = ceil($price / 2);
        if ($price == 1) {
            $reward = 1;
        }
        if ($mentor) {
            $mentor->update([
                'point' => $mentor->point + $reward
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
        $data = Chat::with('messages')->withCount('messages')
            ->orWhere('from_id', $user->id)
            ->orWhere('to_id', $user->id)->get();
        $detail = null;
        $ids = [];
        foreach ($data as $key => $value) {
            if ($value->from_id == $user->id) {
                array_push($ids, $value->to_id);
            }
            if ($value->to_id == $user->id) {
                array_push($ids, $value->from_id);
            }
        }
        $users = User::whereNotIn('id', $ids)
            ->where('role', '!=', 'admin')
            ->where('id', '!=', $user->id)
            ->get();
        return view('frontend.chat', compact([
            'data',
            'detail',
            'users'
        ]));
    }

    public function chatDetail(Chat $chat)
    {
        $user = $this->getUser();
        if ($chat->from_id != $user->id && $chat->to_id != $user->id) {
            abort(404);
        }
        $data = Chat::with('messages')->withCount('messages')
            ->orWhere('from_id', $user->id)
            ->orWhere('to_id', $user->id)->get();
        $detail = $chat->load('messages.sender', 'from', 'to');
        $ids = [];
        foreach ($data as $key => $value) {
            if ($value->from_id == $user->id) {
                array_push($ids, $value->to_id);
            }
            if ($value->to_id == $user->id) {
                array_push($ids, $value->from_id);
            }
        }
        $users = User::whereNotIn('id', $ids)
            ->where('role', '!=', 'admin')
            ->where('id', '!=', $user->id)
            ->get();
        return view('frontend.chat', compact([
            'data',
            'detail',
            'users',
        ]));
    }

    public function saveDetailChat(Request $request, Chat $chat)
    {
        $this->validate($request, [
            'message'   => 'required|max:250'
        ]);
        $user = $this->getUser();
        if ($chat->from_id != $user->id && $chat->to_id != $user->id) {
            abort(404);
        }
        ChatMessage::create([
            'chat_id'   => $chat->id,
            'message'   => $request->message,
            'sender_id' => $user->id,
        ]);
        $data = Chat::with('messages')->withCount('messages')
            ->orWhere('from_id', $user->id)
            ->orWhere('to_id', $user->id)->get();
        $detail = $chat->load('messages.sender', 'from', 'to');
        $ids = [];
        foreach ($data as $key => $value) {
            if ($value->from_id == $user->id) {
                array_push($ids, $value->to_id);
            }
            if ($value->to_id == $user->id) {
                array_push($ids, $value->from_id);
            }
        }
        $users = User::whereNotIn('id', $ids)
            ->where('role', '!=', 'admin')
            ->where('id', '!=', $user->id)
            ->get();
        return view('frontend.chat', compact([
            'data',
            'detail',
            'users',
        ]));
    }

    public function saveChat(Request $request)
    {
        $this->validate($request, [
            'to'        => 'required|integer|exists:users,id',
            'message'   => 'required|max:200'
        ]);
        $user = $this->getUser();
        $chat = Chat::firstOrCreate([
            'to_id'     => $request->to,
            'from_id'   => $user->id,
        ], [
            'to_id'     => $request->to,
            'from_id'   => $user->id,
        ]);
        ChatMessage::create([
            'chat_id'   => $chat->id,
            'sender_id' => $user->id,
            'message'   => $request->message
        ]);
        return redirect()->back()->with(['success' => 'Chat Send!']);
    }

    public function topup()
    {
        $user = $this->getUser();
        $data = Topup::where('user_id', $user->id)->get();
        return view('frontend.topup', compact([
            'data',
        ]));
    }
}
