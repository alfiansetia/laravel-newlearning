<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SubCategory;
use App\Models\User;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CourseController extends Controller
{

    use CompanyTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Course::query();
        if ($request->filled('search')) {
            $query->orWhere('name', 'like', "%$request->search%");
        }
        if ($request->filled('subcat')) {
            $query->where('subcategory_id', $request->subcat);
        }
        $data = $query->with('subcategory')->withCount('contents')->paginate(10)->withQueryString();
        $subcategories = SubCategory::all();
        return view('course.index', compact('data', 'subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategories = SubCategory::all();
        $mentors = User::where('role', 'mentor')->get();
        return view('course.create', compact('subcategories', 'mentors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|max:100|unique:courses,name',
            'subcategory'   => 'required|integer|exists:sub_categories,id',
            'mentor'        => 'required|integer|exists:users,id',
            'image'         => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'price'         => 'required|integer|gte:1',
            'subtitle'      => 'required|max:1000',
            'header'        => 'required|max:255',
            'image_materi'  => 'required|image|mimes:jpg,jpeg,png|max:5120',
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
        Course::create([
            'name'              => $request->name,
            'subcategory_id'    => $request->subcategory,
            'mentor_id'         => $request->mentor,
            'image'             => $image,
            'price'             => $request->price,
            'subtitle'          => $request->subtitle,
            'header_materi'     => $request->input('header'),
            'image_materi'      => $image_materi,
            'detail_materi'     => $request->detail,
            'slug'              => Str::slug($request->name),
        ]);
        return redirect()->route('course.index')->with(['success' => 'Insert Data Success!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $subcategories = SubCategory::all();
        $mentors = User::where('role', 'mentor')->get();
        $data = $course->load('subcategory.category', 'mentor');
        return view('course.edit', compact('subcategories', 'mentors', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $this->validate($request, [
            'name'          => 'required|max:100|unique:courses,name,' . $course->id,
            'subcategory'   => 'required|integer|exists:sub_categories,id',
            'mentor'        => 'required|integer|exists:users,id',
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
            'mentor_id'         => $request->mentor,
            'image'             => $image,
            'price'             => $request->price,
            'subtitle'          => $request->subtitle,
            'header_materi'     => $request->input('header'),
            'image_materi'      => $image_materi,
            'detail_materi'     => $request->detail,
            'slug'              => Str::slug($request->name),
        ]);
        return redirect()->route('course.index')->with(['success' => 'Update Data Success!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $image = $course->getRawOriginal('image');
        $image_materi = $course->getRawOriginal('image_materi');
        if (!empty($image) && file_exists(public_path('images/course/' . $image))) {
            File::delete(public_path('images/course/' . $image));
        }
        if (!empty($image_materi) && file_exists(public_path('images/course/' . $image_materi))) {
            File::delete(public_path('images/course/' . $image_materi));
        }
        $course->delete();
        return redirect()->route('course.index')->with(['success' => 'Delete Data Success!']);
    }
}
