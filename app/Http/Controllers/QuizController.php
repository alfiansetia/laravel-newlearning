<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizOption;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Quiz::query();
        if ($request->filled('search')) {
            $query->orWhere('title', 'like', "%$request->search%");
        }
        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }
        $data = $query->with('course')->withCount('options')->paginate(10)->withQueryString();
        $courses = Course::all();
        return view('quiz.index', compact('data', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('quiz.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'course'    => 'required|integer|exists:courses,id',
            'title'     => 'required|max:200',
            'question'  => 'required|max:200',
            'value'     => 'required|array|min:1',
            'answer'    => 'nullable|array|min:1',
            'value.*'   => 'required|max:250',
            'answer.*'  => 'nullable|in:yes,no',
        ]);
        $quiz = Quiz::create([
            'course_id' => $request->course,
            'title'     => $request->title,
            'question'  => $request->question,
        ]);
        foreach ($request->value as $i => $item) {
            QuizOption::create([
                'quiz_id'   => $quiz->id,
                'value'     => $item,
                'is_answer' => $request->answer[$i] ?? 'no',
            ]);
        }
        return redirect()->route('quiz.index')->with(['success' => 'Insert Data Success!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        $courses = Course::all();
        $data = $quiz->load('course', 'options');
        return view('quiz.edit', compact('courses', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $this->validate($request, [
            'course'    => 'required|integer|exists:courses,id',
            'title'     => 'required|max:200',
            'question'  => 'required|max:200',
            'value'     => 'required|array|min:1',
            'answer'    => 'nullable|array|min:1',
            'value.*'   => 'required|max:250',
            'answer.*'  => 'nullable|in:yes,no',
        ]);
        $quiz->update([
            'course_id' => $request->course,
            'title'     => $request->title,
            'question'  => $request->question,
        ]);
        foreach ($quiz->options ?? [] as $item) {
            $item->delete();
        }
        foreach ($request->value as $i => $item) {
            QuizOption::create([
                'quiz_id'   => $quiz->id,
                'value'     => $item,
                'is_answer' => $request->answer[$i] ?? 'no',
            ]);
        }
        return redirect()->route('quiz.index')->with(['success' => 'Update Data Success!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quiz.index')->with(['success' => 'Delete Data Success!']);
    }
}
