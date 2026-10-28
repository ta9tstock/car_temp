<?php

use Illuminate\Support\Facades\Route;

// トップページ
Route::get('/', function () {
    return view('welcome');
})->name('home');

// テスト用サブページ
Route::get('/test', function () {
    return view('test');
})->name('test');