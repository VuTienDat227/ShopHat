<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
//        if ($request->session()->has('id')) {
//            // Người dùng đã đăng nhập, tiếp tục thực hiện route tiếp theo
//            return $next($request);
//        }
//
//        // Người dùng chưa đăng nhập, trả về lỗi hoặc chuyển hướng đến trang đăng nhập
//        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
