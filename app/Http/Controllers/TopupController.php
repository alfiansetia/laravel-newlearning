<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;

class TopupController extends Controller
{
    use CompanyTrait;

    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized  = config('services.midtrans.isSanitized');
        Config::$is3ds        = config('services.midtrans.is3ds');
    }

    public function callback(Request $request)
    {
        $requestData = $request->all();
        $serverKey = config('services.midtrans.serverKey');
        $signatureKey = $requestData['signature_key'];
        $orderId = $requestData['order_id'];
        $amount = $requestData['gross_amount'];
        $statusCode = $requestData['status_code'];

        $topup = Topup::with('user')->where('code', $orderId)->first();
        if ($topup) {
            $input = $orderId . $statusCode . $amount . $serverKey;
            $signature = openssl_digest($input, 'sha512');
            if ($signatureKey !== $signature) {
                return response()->json([
                    'error' => 'Invalid signature',
                ], 400);
            }
            $transactionId = $requestData['transaction_id'];
            $transactionStatus = $requestData['transaction_status'];
            $topup->transaction_id = $transactionId;
            if ($transactionStatus === 'settlement') {
                $topup->status = 'done';
                $tuser = $topup->user;
                $tuser->update([
                    'point' => $tuser->point + $topup->point,
                ]);
            } elseif ($transactionStatus == 'pending') {
                $topup->status = 'pending';
            } else {
                $topup->status = 'cancel';
            }
            $topup->save();
            return response()->json(['message' => 'Transaction status updated'], 200);
        }
        return response()->json(['error' => 'Topup not found'], 404);
    }

    public function payment(Request $request)
    {
        $user = $this->getUser();
        $topup = Topup::where('code', $request->order_id)->first();
        if (!$topup) {
            abort(404);
        }
        $message = ['error' => 'Topup Failed'];
        if ($request->filled('transaction_status')) {
            if ($request->transaction_status == 'success' || $request->transaction_status == 'settlement') {
                $message = ['success' => 'Topup Success'];
            }
        }
        if ($user) {
            if ($user->role == 'admin' || $user->role == 'mentor') {
                return redirect()->route('topup.index')->with($message);
            }
        }
        return redirect()->route('index.topup')->with($message);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = $this->getUser();
        if ($user->role != 'admin') {
            return redirect()->route('index.topup');
        }
        $query = Topup::query();
        if ($user->role == 'mentor') {
            $query->where('user_id', $user->id);
        }
        $data =  $query->paginate(10);
        return view('topup.index', compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|integer|min:200'
        ]);
        $user = $this->getUser();
        $company = $this->getCompany();
        $pending = Topup::where('user_id', $user->id)->where('status', 'pending')->count();
        if (($pending ?? 0) > 0) {
            if ($user->role == 'admin' || $user->role == 'mentor') {
                return redirect()->route('topup.index')->with(['error' => 'Topup Failed, Any pending transaction!']);
            }
            return redirect()->route('index.topup')->with(['error' => 'Topup Failed, Any pending transaction!']);
        }
        $amount = $request->amount * 100;
        DB::beginTransaction();
        try {
            $code = Str::random(15);
            $payload = [
                'transaction_details' => [
                    'order_id'      => $code,
                    'gross_amount'  => $amount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email'      => $user->email,
                ],
                'item_details' => [
                    [
                        'id'            => $code,
                        'price'         => $amount,
                        'quantity'      => 1,
                        'name'          => 'Topup Point to ' . $company->name,
                    ],
                ],
            ];
            $snap = Snap::createTransaction($payload);

            $topup = Topup::create([
                'code'          => $code,
                'user_id'       => $user->id,
                'amount'        => $amount,
                'point'         => $request->amount,
                'note'          => $request->note,
                'snap_token'    => $snap->token,
                'snap_url'      => $snap->redirect_url
            ]);

            DB::commit();
            return redirect($snap->redirect_url);
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($user->role == 'admin' || $user->role == 'mentor') {
                return redirect()->route('topup.index')->with(['error', 'Error : ' . $th->getMessage(),]);
            }
            return redirect()->route('index.topup')->with(['error', 'Error : ' . $th->getMessage(),]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topup $topup)
    {
        if ($topup->status == 'cancel') {
            return redirect()->route('topup.index')->with(['error' => 'Transaction Already Cancel!']);
        }
        $topup->update([
            'status' => 'cancel'
        ]);
        return redirect()->route('topup.index')->with(['success' => 'Cancel transaction Success!']);
    }
}
