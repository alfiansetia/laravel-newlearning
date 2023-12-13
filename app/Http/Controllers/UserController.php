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

    public function index()
    {
        $data = User::paginate(10)->withQueryString();
        return view('user.index', compact('data'))->with(['company' => $this->getCompany()]);
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
            'verify'    => 'nullable',
            'password'  => 'nullable|min:5',
        ]);

        $param = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'gender'    => $request->gender,
            'dob'       => $request->dob,
            'country'   => $request->country,
            'phone'     => $request->phone,
            'verify'    => !empty($request->verify) ? now() : null,
        ];
        if ($request->filled('password')) {
            $param['password'] = Hash::make($request->password);
        }
        $user->update($param);

        return redirect()->route('user.index')->with(['success' => 'Update Data Success!']);
    }
}
