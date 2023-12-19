<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Key;
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
    public function index(Request $request)
    {
        $query = Transaction::query();
        if ($request->filled('search')) {
            $query->orWhere('number', 'like', "%$request->search%");
        }
        $data = $query->paginate(10)->withQueryString();
        return view('transaction.index', compact('data'));
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
        // 
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $data = $transaction->load('details', 'user');
        return view('transaction.show', compact('data'));
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
        $transaction->update([
            'status' => 'cancel'
        ]);
        return redirect()->route('transaction.index')->with(['success' => 'Cancel Data Success!']);
    }
}
