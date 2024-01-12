<?php

namespace App\Http\Controllers;

use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    use CompanyTrait;

    public function profile()
    {
        $data = $this->getUser();
        if ($data->role != 'admin') {
            return redirect()->route('index.profile');
        }
        return view('setting.profile', compact('data'));
    }

    public function profileUpdate(Request $request)
    {
        $data = $this->getUser();
        if ($data->role != 'admin') {
            return redirect()->route('index.profile');
        }
        $this->validate($request, [
            'name'      => 'required',
            'gender'    => 'required|in:Male,Female',
            'dob'       => 'required|date_format:Y-m-d|before:today',
            'phone'     => 'required|max:15|min:8',
            'password'  => 'nullable|min:5',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $user = auth()->user();
        $image = $user->getRawOriginal('image');
        if ($files = $request->file('image')) {
            if (!empty($image) && file_exists(public_path('images/user/' . $image))) {
                File::delete(public_path('images/user/' . $image));
            }
            $image = 'user_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('images/user/'), $image);
        }
        $param = [
            'name'      => $request->name,
            'gender'    => $request->gender,
            'dob'       => $request->dob,
            'phone'     => $request->phone,
            'image'     => $image,
        ];
        if ($request->filled('password')) {
            $param['password'] = Hash::make($request->password);
        }
        $user->update($param);
        return redirect()->route('setting.profile')->with(['success' => 'Update Data Success!']);
    }
}
