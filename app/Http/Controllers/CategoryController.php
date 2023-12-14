<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use CompanyTrait;

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
        ]);
        Category::create(['name' => $request->name]);
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
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('category.index')->with(['success' => 'Update Data Success!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with(['success' => 'Delete Data Success!']);
    }
}
