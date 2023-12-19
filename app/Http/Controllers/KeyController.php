<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\User;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;

class KeyController extends Controller
{
    use CompanyTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Key::query();
        if ($request->filled('search')) {
            $query->orWhere('value', 'like', "%$request->search%");
        }
        $data = $query->with('user')->paginate(10)->withQueryString();
        return view('key.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('key.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user'  => 'required|exists:users,id',
            'qty'   => 'required|integer|min:1|max:100',
        ]);

        Key::factory($request->qty)->create([
            'user_id'   => $request->user,
            'status'    => 'available'
        ]);

        return redirect()->route('key.index')->with(['success' => 'Insert Data Success!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Key $key)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Key $key)
    {
        $data = $key->load('user');
        $users = User::all();
        return view('key.edit', compact('data', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Key $key)
    {
        $this->validate($request, [
            'user'      => 'required|exists:users,id',
            'status'    => 'required|in:available,unavailable',
        ]);
        $key->update([
            'user_id'   => $request->user,
            'status'    => $request->status,
        ]);
        return redirect()->route('key.index')->with(['success' => 'Update Data Success!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Key $key)
    {
        $key->delete();
        return redirect()->route('key.index')->with(['success' => 'Delete Data Success!']);
    }
}
