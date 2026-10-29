<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ログインしていない場合はログイン画面へリダイレクト
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors([
                'user_email' => 'ログインが必要です。',
            ]);
        }

        return $next($request);
    }
}