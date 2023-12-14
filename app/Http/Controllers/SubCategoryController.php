<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
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
        $query = SubCategory::query();
        if ($request->filled('search')) {
            $query->orWhere('name', 'like', "%$request->search%");
        }
        $data = $query->with('category')->paginate(10)->withQueryString();
        return view('subcategory.index', compact('data'))->with(['company' => $this->getCompany()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('subcategory.create', compact('categories'))->with(['company' => $this->getCompany()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:200',
            'category'  => 'required|integer|exists:categories,id',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $image = null;
        if ($files = $request->file('image')) {
            $image = 'category_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('images/category/'), $image);
        }
        SubCategory::create([
            'name'          => $request->name,
            'category_id'   => $request->category,
            'image'         => $image,
            'slug'          => Str::slug($request->name),
        ]);
        return redirect()->route('subcategory.index')->with(['success' => 'Insert Data Success!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subcategory)
    {
        $data = $subcategory;
        $categories = Category::all();
        return view('subcategory.edit', compact('data', 'categories'))->with(['company' => $this->getCompany()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subcategory)
    {
        $this->validate($request, [
            'name'      => 'required',
            'category'  => 'required|integer|exists:categories,id',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $image = $subcategory->getRawOriginal('image');
        $path = public_path('images/subcategory/');

        if ($files = $request->file('image')) {
            if (!empty($image) && file_exists($path . $image)) {
                File::delete($path . $image);
            }
            $image = 'subcategory_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move($path, $image);
        }

        $subcategory->update([
            'name'          => $request->name,
            'category_id'   => $request->category,
            'image'         => $image,
            'slug'          => Str::slug($request->name),
        ]);

        return redirect()->route('subcategory.index')->with(['success' => 'Update Data Success!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subcategory)
    {
        $image = $subcategory->getRawOriginal('image');
        if (!empty($image) && file_exists(public_path('images/subcategory/' . $image))) {
            File::delete(public_path('images/subcategory/' . $image));
        }
        $subcategory->delete();
        return redirect()->route('subcategory.index')->with(['success' => 'Delete Data Success!']);
    }
}
