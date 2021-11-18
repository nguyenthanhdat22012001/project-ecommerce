<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    { 
        if (Auth::check())
        {
     
             if(Auth::user()->isAdmin())
             {
                 return $next($request);
             }
        }
        return response()->json([
            'success' => false,
            'message' => 'bạn không có quyền truy cập',
        ], 403);
    }
}
