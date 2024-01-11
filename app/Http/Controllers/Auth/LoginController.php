<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Key;
use App\Models\Subscribtion;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role != 'admin') {
            $date = date('Y-m-d');
            $date_parse = Carbon::parse($date);
            $now = now();
            $user_sub = Subscribtion::where('user_id', $user->id)->whereDate('date', $date_parse)->first();
            if ($user_sub) {
                $user_sub->update([
                    'last_update' => $now,
                ]);
            } else {
                $new_sub = Subscribtion::create([
                    'user_id'       => $user->id,
                    'date'          => $date,
                    'last_update'   => $now,
                ]);
                $remove = Subscribtion::where('user_id', $user->id)->get();
                if (count($remove) > 7) {
                    $new_all_user_sub = Subscribtion::where('user_id', $user->id)->orderBy('date', 'asc')->get();
                    for ($i = 0; $i < 7; $i++) {
                        $new_all_user_sub[$i]->delete();
                    }
                }
                $all_user_sub = Subscribtion::where('user_id', $user->id)->get();
                $count_sub = count($all_user_sub);
                $point = 0;
                if ($count_sub == 1 || $count_sub == 2 || $count_sub == 3 || $count_sub == 4) {
                    $point = 25;
                }
                if ($count_sub == 5 || $count_sub == 6) {
                    $point = 50;
                }
                $user->point += $point;
                $user->save();
                $get_key = false;
                if ($count_sub == 7) {
                    Key::create([
                        'user_id'   => $user->id,
                        'value'     => Str::random(20),
                        'status'    => 'available'
                    ]);
                    $get_key = true;
                }
            }
        }
        if ($user->role == 'user') {
            if ($point > 0) {
                return redirect()->route('index.category')->with(['success' => 'Congratulation! You Get ' . $point . ' Point!']);
            }
            if ($get_key > 0) {
                return redirect()->route('index.category')->with(['success' => 'Congratulation! You Get 1 Key!']);
            }
            return redirect()->route('index.category');
        }
    }
}
