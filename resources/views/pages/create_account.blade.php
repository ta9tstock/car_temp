<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント作成</title>
</head>
<body>
    <h1>アカウント作成</h1>

    <!-- バリデーションエラーメッセージの表示 -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- アカウント作成フォーム -->
    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div>
            <label for="user_name">ユーザー名:</label><br>
            <input type="text" id="user_name" name="user_name" value="{{ old('user_name') }}" required autofocus>
        </div>

        <br>

        <div>
            <label for="user_email">ユーザーID / メールアドレス:</label><br>
            <input type="text" id="user_email" name="user_email" value="{{ old('user_email') }}" required>
        </div>

        <br>

        <div>
            <label for="user_password">パスワード (8文字以上):</label><br>
            <input type="password" id="user_password" name="user_password" required>
        </div>

        <br>

        <div>
            <label for="user_password_confirmation">パスワード (確認用):</label><br>
            <input type="password" id="user_password_confirmation" name="user_password_confirmation" required>
        </div>

        <br>

        <button type="submit">アカウントを作成</button>
    </form>

    <hr>

    <p>
        すでにアカウントをお持ちの方:
        <a href="{{ route('login') }}">ログイン画面へ戻る</a>
    </p>
</body>
</html>