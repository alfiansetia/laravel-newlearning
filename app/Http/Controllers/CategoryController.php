<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use CompanyTrait;

    public function __construct()
    {
        $this->middleware('is.admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();
        if ($request->filled('search')) {
            $query->orWhere('name', 'like', "%$request->search%");
        }
        $data = $query->paginate(10)->withQueryString();
        return view('category.index', compact('data'))->with(['company' => $this->getCompany()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create')->with(['company' => $this->getCompany()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:200',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $image = null;
        if ($files = $request->file('image')) {
            $image = 'category_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('images/category/'), $image);
        }
        Category::create([
            'name'  => $request->name,
            'image' => $image,
            'slug'  => Str::slug($request->name),
        ]);
        return redirect()->route('category.index')->with(['success' => 'Insert Data Success!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Category $category)
    {
        $data = $category;
        return view('category.edit', compact('data'))->with(['company' => $this->getCompany()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name'      => 'required',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $image = $category->getRawOriginal('image');
        $path = public_path('images/category/');

        if ($files = $request->file('image')) {
            if (!empty($image) && file_exists($path . $image)) {
                File::delete($path . $image);
            }
            $image = 'category_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move($path, $image);
        }

        $category->update([
            'name'  => $request->name,
            'image' => $image,
            'slug'  => Str::slug($request->name),
        ]);

        return redirect()->route('category.index')->with(['success' => 'Update Data Success!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $image = $category->getRawOriginal('image');
        if (!empty($image) && file_exists(public_path('images/category/' . $image))) {
            File::delete(public_path('images/category/' . $image));
        }
        $category->delete();
        return redirect()->route('category.index')->with(['success' => 'Delete Data Success!']);
    }
}
