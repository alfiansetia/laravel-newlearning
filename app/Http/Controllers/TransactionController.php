<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Cart;
use App\Models\TransactionDetail;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{

    use CompanyTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $user = $this->getUser();
        $carts = Cart::with('course')->where('User_id', $user->id)->get();
        if (count($carts) < 1) {
            return redirect()->back()->with(['error' => 'Empty Cart!']);
        }
        $total = 0;
        foreach ($carts as $item) {
            $total += $item->course->price;
        }
        if ($user->point < $total) {
            return redirect()->back()->with(['error' => 'Not Enough Token!']);
        }
        $trx = Transaction::create([
            'user_id'   => $user->id,
            'date'      => date('Y-m-d H:i:s'),
            'number'    => Str::random(10),
            'total'     => $total,
            'status'    => 'success',
        ]);

        foreach ($carts as $item) {
            TransactionDetail::create([
                'transaction_id'    => $trx->id,
                'course_id'         => $item->course_id,
                'price'             => $item->course->price,
            ]);
            $item->delete();
        }
        $new_point = $user->point - $total;
        $user->update([
            'point' => $new_point,
        ]);
        return redirect()->back()->with(['success' => 'Payment Successfull !']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
