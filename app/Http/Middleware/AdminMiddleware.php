<?php

namespace App\Http\Middleware;

use App\Traits\CompanyTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    use CompanyTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->getUser()->role != 'admin') {
            if ($request->ajax()) {
                return response()->json(['message' => 'Unauthorize!'], 403);
            }
            if ($this->getUser()->role === 'user') {
                return redirect()->route('index');
            }
            return redirect()->route('home')->with('error', 'Unauthorize!');
        }
        return $next($request);
    }
}
