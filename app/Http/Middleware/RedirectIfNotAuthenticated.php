<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('/admin/login'); // Chuyển hướng đến trang đăng nhập nếu người dùng chưa đăng nhập
        }

        return $next($request);
    }
}
