<?php

namespace App\Http\Controllers;

use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    use CompanyTrait;

    public function profile()
    {
        $data = $this->getUser();
        return view('setting.profile', compact('data'))->with(['company' => $this->getCompany()]);
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'gender'    => 'required|in:Male,Female',
            'dob'       => 'required|date_format:Y-m-d|before:today',
            'phone'     => 'required|max:15|min:8',
            'password'  => 'nullable|min:5',
        ]);
        $user = auth()->user();
        $param = [
            'name'      => $request->name,
            'gender'    => $request->gender,
            'dob'       => $request->dob,
            'phone'     => $request->phone,
        ];
        if ($request->filled('password')) {
            $param['password'] = Hash::make($request->password);
        }
        $user->update($param);
        return redirect()->route('setting.profile')->with(['success' => 'Update Data Success!']);
    }
}
