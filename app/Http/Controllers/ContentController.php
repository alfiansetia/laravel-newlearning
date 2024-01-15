<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ContentController extends Controller
{

    use CompanyTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Content::query();
        if ($request->filled('search')) {
            $query->orWhere('title', 'like', "%$request->search%");
        }
        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }
        $data = $query->with('course')->paginate(10)->withQueryString();
        $courses = Course::all();
        return view('content.index', compact('data', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('content.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'course'    => 'required|integer|exists:courses,id',
            'title'     => 'required|max:200',
            'file'      => 'required|mimes:mp4,mov,avi,wmv|max:20480',
            'detail'    => 'nullable|max:500',
        ]);
        $file = null;
        if ($files = $request->file('file')) {
            $file = 'file_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('videos/content/'), $file);
        }
        Content::create([
            'course_id' => $request->course,
            'title'     => $request->title,
            'file'      => $file,
            'detail'    => $request->detail,
        ]);
        return redirect()->route('content.index')->with(['success' => 'Insert Data Success!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content)
    {
        $courses = Course::all();
        $data = $content->load('course');
        return view('content.edit', compact('courses', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Content $content)
    {
        $user = $this->getUser();
        if ($user->role != 'admin' && $content->course->mentor_id != $user->id) {
            abort(403, 'Unauthorize!');
        }
        $valid =  [
            'title'     => 'required|max:200',
            'file'      => 'nullable|mimes:mp4,mov,avi,wmv|max:20480',
            'detail'    => 'nullable|max:500',
        ];
        if ($user->role == 'admin') {
            $valid['course'] = 'required|integer|exists:courses,id';
        }
        $this->validate($request, $valid);
        $file = $content->getRawOriginal('file');
        $path = public_path('videos/content/');
        if ($files = $request->file('file')) {
            if (!empty($file) && file_exists($path . $file)) {
                File::delete($path . $file);
            }
            $file = 'file_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('videos/content/'), $file);
        }
        $param = [
            'title'     => $request->title,
            'file'      => $file,
            'detail'    => $request->detail,
        ];
        if ($user->role == 'admin') {
            $param['course_id'] = $request->course;
        }
        $content->update($param);
        if ($user->role != 'admin') {
            return redirect()->route('list.course.step.content', $content->course_id)->with(['success' => 'Update Data Success!']);
        }
        return redirect()->back()->with(['success' => 'Insert Data Success!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        $user = $this->getUser();
        if ($user->role != 'admin' && $content->course->mentor_id != $user->id) {
            abort(403, 'Unauthorize!');
        }
        $file = $content->getRawOriginal('file');
        $path = public_path('videos/content');
        if (!empty($file) && file_exists($path . $file)) {
            File::delete($path . $file);
        }
        $content->delete();
        return redirect()->back()->with(['success' => 'Delete Data Success!']);
    }
}
