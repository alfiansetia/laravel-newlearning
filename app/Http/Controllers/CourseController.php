<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;

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
        $data = $query->with('subcategory')->paginate(10)->withQueryString();
        return view('course.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
