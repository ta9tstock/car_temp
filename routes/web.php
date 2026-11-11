<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TempApiController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\CheckAuth;

// ----------------------------------------------
// 未ログインアクセス可能画面
// ----------------------------------------------

// トップページ
Route::get('/', function () {
    return view('welcome');
})->name('home');

// テスト用サブページ
Route::get('/test', function () {
    return view('test');
})->name('test');

// ゲスト向け画面
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [PageController::class, 'authenticate']);
Route::get('/create-account', [PageController::class, 'createAccount'])->name('create.account');
Route::post('/register', [PageController::class, 'register'])->name('register');

// ログアウト処理
Route::post('/logout', [PageController::class, 'logout'])->name('logout');

// ログイン必須画面
Route::middleware([CheckAuth::class])->group(function () {
    Route::redirect('/', '/dselection');

    // デバイス選択 (POST: look_device)
    Route::post('/select-device', [PageController::class, 'selectDevice'])->name('select.device');

    Route::get('/dselection', [PageController::class, 'dselection'])->name('dselection');
    Route::get('/dtop', [PageController::class, 'dtop'])->name('dtop');
    Route::get('/dprediction', [PageController::class, 'dprediction'])->name('dprediction');

    // 快適温度設定 CRUD ルート
    Route::get('/dsetting', [PageController::class, 'dsetting'])->name('dsetting');
    Route::post('/temp-settings', [PageController::class, 'storeTempSetting'])->name('temp_settings.store');
    Route::put('/temp-settings/{id}', [PageController::class, 'updateTempSetting'])->name('temp_settings.update');
    Route::delete('/temp-settings/{id}', [PageController::class, 'destroyTempSetting'])->name('temp_settings.destroy');
});

// ラズパイデータ受信用 API エンドポイント
Route::post('/api/temp', [TempApiController::class, 'store'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);