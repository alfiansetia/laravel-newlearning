<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('setting.company');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'subtitle'  => 'required|max:1000',
            'link'      => 'required|max:200',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'show'      => 'required|in:yes,no',
        ]);
        $image = null;
        if ($files = $request->file('image')) {
            $image = 'slider_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('images/slider/'), $image);
        }
        Slider::create([
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'image'     => $image,
            'link'      => $request->link,
            'show'      => $request->show,
        ]);
        return redirect()->back()->with(['success' => 'Insert Data Success!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        $data = $slider;
        return view('slider.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $this->validate($request, [
            'title'     => 'required',
            'subtitle'  => 'required|max:1000',
            'link'      => 'required|max:200',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'show'      => 'required|in:yes,no',
        ]);

        $image = $slider->getRawOriginal('image');
        $path = public_path('images/slider/');

        if ($files = $request->file('image')) {
            if (!empty($image) && file_exists($path . $image)) {
                File::delete($path . $image);
            }
            $image = 'slider_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
            $files->move($path, $image);
        }

        $slider->update([
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'image'     => $image,
            'link'      => $request->link,
            'show'      => $request->show,
        ]);
        return redirect()->back()->with(['success' => 'Update Data Success!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $image = $slider->getRawOriginal('image');
        if (!empty($image) && file_exists(public_path('images/slider/' . $image))) {
            File::delete(public_path('images/slider/' . $image));
        }
        $slider->delete();
        return redirect()->back()->with(['success' => 'Delete Data Success!']);
    }
}
