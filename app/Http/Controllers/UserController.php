<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\Type\NullType;

class UserController extends Controller
{
    use CompanyTrait;

    public function __construct()
    {
        $this->middleware('is.admin');
    }

    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('search')) {
            $query->orWhere('name', 'like', "%$request->search%");
            $query->orWhere('email', 'like', "%$request->search%");
        }
        $data = $query->paginate(10)->withQueryString();
        return view('user.index', compact('data'))->with(['company' => $this->getCompany()]);
    }

    public function show(User $user)
    {
        // 
    }

    public function create()
    {
        return view('user.create')->with(['company' => $this->getCompany()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|unique:users,email',
            'role'      => 'required|in:admin,user,mentor',
            'gender'    => 'required|in:Male,Female',
            'dob'       => 'required|date_format:Y-m-d|before:today',
            'country'   => 'required|max:25',
            'phone'     => 'required|max:15|min:8',
            'password'  => 'required|min:5',
            'verify'    => 'required|in:yes,no',
            'status'    => 'required|in:active,nonactive',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'gender'    => $request->gender,
            'dob'       => $request->dob,
            'country'   => $request->country,
            'phone'     => $request->phone,
            'email_verified_at'    => $request->verify === 'yes' ? now() : null,
            'active'    => $request->active,
            'status'    => $request->status,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with(['success' => 'Insert Data Success!']);
    }

    public function edit(User $user)
    {
        $data = $user;
        return view('user.edit', compact('data'))->with(['company' => $this->getCompany()]);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin,user,mentor',
            'gender'    => 'required|in:Male,Female',
            'dob'       => 'required|date_format:Y-m-d|before:today',
            'country'   => 'required|max:25',
            'phone'     => 'required|max:15|min:8',
            'password'  => 'nullable|min:5',
            'verify'    => 'required|in:yes,no',
            'status'    => 'required|in:active,nonactive',
        ]);

        $param = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'gender'    => $request->gender,
            'dob'       => $request->dob,
            'country'   => $request->country,
            'phone'     => $request->phone,
            'email_verified_at'    => $request->verify === 'yes' ? now() : null,
            'active'    => $request->active,
            'status'    => $request->status,
        ];
        if ($request->filled('password')) {
            $param['password'] = Hash::make($request->password);
        }
        $user->update($param);

        return redirect()->route('user.index')->with(['success' => 'Update Data Success!']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with(['success' => 'Delete Data Success!']);
    }
}
