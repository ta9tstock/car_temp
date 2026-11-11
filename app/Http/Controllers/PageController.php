<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DeviceMember;
use App\Models\TempSetting;
use App\Models\Temp;

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
        $request->validate([
            'user_name'     => ['required', 'string', 'max:255'],
            'user_email'    => ['required', 'string', 'max:255', 'unique:users,user_email'],
            'user_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'user_name'     => $request->user_name,
            'user_email'    => $request->user_email,
            'user_password' => $request->user_password,
        ]);

        Auth::login($user);

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
    // 2. デバイス選択・設定管理アクション
    // ==================================================

    /**
     * 選択中デバイスの保持 (POST: look_device)
     */
    public function selectDevice(Request $request)
    {
        $request->validate([
            'look_device' => ['required', 'integer'],
        ]);

        // セッションに選択中のデバイスIDを保存
        session(['look_device' => $request->look_device]);

        // 遷移先を dtop (デバイスTOP画面) に変更
        return redirect()->route('dtop');
    }

    /**
     * 設定画面の表示（選択中デバイスのメンバー温度設定一覧）
     */
    public function dsetting()
    {
        $deviceId = session('look_device');

        // デバイス未選択の場合は選択画面へリダイレクト
        if (!$deviceId) {
            return redirect()->route('dselection')->withErrors([
                'look_device' => 'デバイスを選択してください。',
            ]);
        }

        // デバイスに所属するユーザーID一覧を取得
        $userIds = DeviceMember::where('device_id', $deviceId)->pluck('user_id');

        // 所属メンバー全員の温度設定を取得
        $tempSettings = TempSetting::with('user')
            ->whereIn('user_id', $userIds)
            ->get();

        // フォーム選択用メンバー一覧
        $members = User::whereIn('user_id', $userIds)->get();

        return view('pages.dsetting', compact('deviceId', 'tempSettings', 'members'));
    }

    /**
     * 快適温度設定の新規作成
     */
    public function storeTempSetting(Request $request)
    {
        $request->validate([
            'user_id'  => ['required', 'exists:users,user_id'],
            'MAX_temp' => ['required', 'integer', 'gte:MIN_temp'],
            'MIN_temp' => ['required', 'integer'],
        ]);

        TempSetting::create([
            'user_id'  => $request->user_id,
            'MAX_temp' => $request->MAX_temp,
            'MIN_temp' => $request->MIN_temp,
        ]);

        return back();
    }

    /**
     * 快適温度設定の更新
     */
    public function updateTempSetting(Request $request, $id)
    {
        $request->validate([
            'MAX_temp' => ['required', 'integer', 'gte:MIN_temp'],
            'MIN_temp' => ['required', 'integer'],
        ]);

        $setting = TempSetting::findOrFail($id);
        $setting->update([
            'MAX_temp' => $request->MAX_temp,
            'MIN_temp' => $request->MIN_temp,
        ]);

        return back();
    }

    /**
     * 快適温度設定の削除
     */
    public function destroyTempSetting($id)
    {
        $setting = TempSetting::findOrFail($id);
        $setting->delete();

        return back();
    }

    // ==================================================
    // 3. その他画面表示アクション
    // ==================================================

    public function dselection()
    {
        return view('pages.dselection');
    }

    public function dtop()
    {
        $deviceId = session('look_device');

        // デバイス未選択の場合はデバイス選択画面へリダイレクト
        if (!$deviceId) {
            return redirect()->route('dselection')->withErrors([
                'look_device' => 'デバイスを選択してください。',
            ]);
        }

        // 選択中デバイスの最新温度データを1件取得
        $latestTemp = Temp::where('device_id', $deviceId)
            ->orderBy('created_time', 'desc')
            ->first();

        return view('pages.dtop', compact('deviceId', 'latestTemp'));
    }

    public function dprediction()
    {
        return view('pages.dprediction');
    }
}