<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Content::query();
        if ($request->filled('search')) {
            $query->orWhere('title', 'like', "%$request->search%");
        }
        $data = $query->with('course')->paginate(10)->withQueryString();
        return view('content.index', compact('data'));
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
        $this->validate($request, [
            'course'    => 'required|integer|exists:courses,id',
            'title'     => 'required|max:200',
            'file'      => 'nullable|mimes:mp4,mov,avi,wmv|max:20480',
            'detail'    => 'nullable|max:500',
        ]);
        $file = $content->getRawOriginal('file');
        $path = public_path('videos/content/');
        if ($files = $request->file('file')) {
            if (!empty($file) && file_exists($path . $file)) {
                File::delete($path . $file);
            }
            $file = 'file_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('videos/content/'), $file);
        }
        $content->update([
            'course_id' => $request->course,
            'title'     => $request->title,
            'file'      => $file,
            'detail'    => $request->detail,
        ]);
        return redirect()->route('content.index')->with(['success' => 'Insert Data Success!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        $file = $content->getRawOriginal('file');
        $path = public_path('videos/content');
        if (!empty($file) && file_exists($path . $file)) {
            File::delete($path . $file);
        }
        $content->delete();
        return redirect()->route('content.index')->with(['success' => 'Delete Data Success!']);
    }
}
