<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Course;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use CompanyTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::with('course')->where('User_id', $this->getUser()->id)->get();
        return view('frontend.cart', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'course' => 'required|integer|exists:courses,id'
        ]);
        $exist = Cart::where('user_id', $this->getUser()->id)->where('course_id', $request->course)->first();
        if ($exist) {
            return redirect()->back()->with(['error' => 'Course Exsist on your Cart!']);
        }
        Cart::create([
            'user_id' => $this->getUser()->id,
            'course_id' => $request->course,
        ]);
        return redirect()->back()->with(['success' => 'Success Insert to Cart!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->route('cart.index')->with(['success' => 'Delete Data Success!']);
    }
}
