<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PageController extends Controller
{
    // ==================================================
    // 1. 認証・アカウント管理アクション
    // ==================================================

    /**
     * ログイン画面の表示
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dselection');
        }

        return view('pages.login');
    }

    /**
     * ログイン処理を実行
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'user_email'    => ['required', 'string'],
            'user_password' => ['required', 'string'],
        ]);

        $authData = [
            'user_email' => $credentials['user_email'],
            'password'   => $credentials['user_password'],
        ];

        if (Auth::attempt($authData)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dselection'));
        }

        return back()->withErrors([
            'user_email' => 'ユーザーID/メールアドレスまたはパスワードが正しくありません。',
        ])->onlyInput('user_email');
    }

    /**
     * アカウント作成画面の表示
     */
    public function createAccount()
    {
        return view('pages.create_account');
    }

    /**
     * アカウント登録処理を実行
     */
    public function register(Request $request)
    {
        // 入力バリデーション
        $request->validate([
            'user_name'     => ['required', 'string', 'max:255'],
            'user_email'    => ['required', 'string', 'max:255', 'unique:users,user_email'],
            'user_password' => ['required', 'string', 'min:8', 'confirmed'], // user_password_confirmation との一致を確認
        ]);

        // ユーザーの作成（Userモデルのcasts機能により自動でハッシュ化されます）
        $user = User::create([
            'user_name'     => $request->user_name,
            'user_email'    => $request->user_email,
            'user_password' => $request->user_password,
        ]);

        // 作成したユーザーでそのまま自動ログイン
        Auth::login($user);

        // デバイス選択画面へ移動
        return redirect()->route('dselection');
    }

    /**
     * ログアウト処理
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ==================================================
    // 2. 画面表示アクション
    // ==================================================

    public function dselection()
    {
        return view('pages.dselection');
    }

    public function dtop()
    {
        return view('pages.dtop');
    }

    public function dprediction()
    {
        return view('pages.dprediction');
    }

    public function dsetting()
    {
        return view('pages.dsetting');
    }
}