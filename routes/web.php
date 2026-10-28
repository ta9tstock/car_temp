<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TempApiController;

// トップページ
Route::get('/', function () {
    return view('welcome');
})->name('home');

// テスト用サブページ
Route::get('/test', function () {
    return view('test');
})->name('test');

// ラズパイデータ受信用 API エンドポイント
Route::post('/api/temp', [TempApiController::class, 'store'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);