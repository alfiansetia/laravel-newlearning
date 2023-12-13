<?php

namespace App\Http\Middleware;

use App\Traits\CompanyTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MentorMiddleware
{
    use CompanyTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->getUser()->role != 'mentor') {
            if ($request->ajax()) {
                return response()->json(['message' => 'Unauthorize!'], 403);
            }
            return redirect()->route('home')->with('error', 'Unauthorize!');
        }
        return $next($request);
    }
}
