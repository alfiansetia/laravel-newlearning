<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    use CompanyTrait;

    public function index()
    {
        $data = $this->getCompany();
        $sliders = Slider::all();
        return view('setting.company', compact('data', 'sliders'));
    }

    public function update(Request $request)
    {
        $company = $this->getCompany();
        $this->validate($request, [
            'name'      => 'required|max:50',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $image = $company->getRawOriginal('logo');
        if ($files = $request->file('logo')) {
            if (!empty($image) && file_exists(public_path('images/logo/' . $image))) {
                File::delete(public_path('images/logo/' . $image));
            }
            $image = 'logo_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('images/logo/'), $image);
        }

        $company->update([
            'name'  => $request->name,
            'logo'  => $image,
        ]);
        return redirect()->route('setting.company')->with(['success' => 'Update data Success!']);
    }
}
