<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizOption;
use App\Models\SubCategory;
use App\Models\User;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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

    public function stepCreateSave(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|max:100|unique:courses,name',
            'subcategory'   => 'required|integer|exists:sub_categories,id',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'price'         => 'required|integer|gte:1',
            'subtitle'      => 'required|max:1000',
            'header'        => 'required|max:255',
            'image_materi'  => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'detail'        => 'required|max:2000',
        ]);
        $image = null;
        if ($files = $request->file('image')) {
            $image = 'course_' . Str::random(5) . '_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('images/course/'), $image);
        }
        $image_materi = null;
        if ($files_materi = $request->file('image_materi')) {
            $image_materi = 'materi_' . Str::random(5) . '_' . date('dmyHis') . '.' . $files_materi->getClientOriginalExtension();
            $files_materi->move(public_path('images/course/'), $image_materi);
        }
        $course = Course::create([
            'name'              => $request->name,
            'subcategory_id'    => $request->subcategory,
            'mentor_id'         => auth()->id(),
            'image'             => $image,
            'price'             => $request->price,
            'subtitle'          => $request->subtitle,
            'header_materi'     => $request->input('header'),
            'image_materi'      => $image_materi,
            'detail_materi'     => $request->detail,
            'slug'              => Str::slug($request->name),
        ]);
        return redirect()->route('list.course.step.edit', $course->id)->with(['success' => 'Insert Data Success!']);
    }

    public function stepEdit(Course $course)
    {
        $subcategories = SubCategory::all();
        $data = $course->load('subcategory.category', 'mentor');
        return view('course.step.edit', compact('subcategories', 'data'));
    }

    public function stepEditSave(Request $request, Course $course)
    {
        $this->validate($request, [
            'name'          => 'required|max:100|unique:courses,name,' . $course->id,
            'subcategory'   => 'required|integer|exists:sub_categories,id',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'price'         => 'required|integer|gte:1',
            'subtitle'      => 'required|max:1000',
            'header'        => 'required|max:255',
            'image_materi'  => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'detail'        => 'required|max:2000',
        ]);
        $path = public_path('images/course/');
        $image = $course->getRawOriginal('image');
        if ($files = $request->file('image')) {
            if (!empty($image) && file_exists($path . $image)) {
                File::delete($path . $image);
            }
            $image = 'course_' . Str::random(5) . '_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move($path, $image);
        }
        $image_materi = $course->getRawOriginal('image');
        if ($files_materi = $request->file('image_materi')) {
            if (!empty($image_materi) && file_exists($path . $image_materi)) {
                File::delete($path . $image_materi);
            }
            $image_materi = 'materi_' . Str::random(5) . '_' . date('dmyHis') . '.' . $files_materi->getClientOriginalExtension();
            $files_materi->move($path, $image_materi);
        }
        $course->update([
            'name'              => $request->name,
            'subcategory_id'    => $request->subcategory,
            'mentor_id'         => auth()->id(),
            'image'             => $image,
            'price'             => $request->price,
            'subtitle'          => $request->subtitle,
            'header_materi'     => $request->input('header'),
            'image_materi'      => $image_materi,
            'detail_materi'     => $request->detail,
            'slug'              => Str::slug($request->name),
        ]);
        return redirect()->back()->with(['success' => 'Update Data Success!']);
    }

    public function stepContent(Course $course)
    {
        $course->load('contents');
        return view('course.step.content', compact('course'));
    }

    public function stepContentSave(Request $request, Course $course)
    {
        $this->validate($request, [
            'title'     => 'required|max:200',
            'file'      => 'required|mimes:mp4,mov,avi,wmv|max:20480',
            'detail'    => 'nullable|max:1000',
        ]);
        $file = null;
        if ($files = $request->file('file')) {
            $file = 'file_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('videos/content/'), $file);
        }
        Content::create([
            'course_id' => $course->id,
            'title'     => $request->title,
            'file'      => $file,
            'detail'    => $request->detail,
        ]);
        return redirect()->back()->with(['success' => 'Insert Data Success!']);
    }

    public function stepQuiz(Course $course)
    {
        $course->load('quizzes')->loadCount('quizzes');
        return view('course.step.quiz', compact('course'));
    }

    public function stepQuizSave(Request $request, Course $course)
    {
        $this->validate($request, [
            'question'  => 'required|max:2000',
            'value'     => 'required|array|min:1',
            'answer'    => 'nullable|array|min:1',
            'value.*'   => 'required|max:250',
            'answer.*'  => 'nullable|in:yes,no',
        ]);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'question'  => $request->question,
        ]);
        foreach ($request->value as $i => $item) {
            QuizOption::create([
                'quiz_id'   => $quiz->id,
                'value'     => $item,
                'is_answer' => $request->answer[$i] ?? 'no',
            ]);
        }
        return redirect()->back()->with(['success' => 'Insert Data Success!']);
    }
}
