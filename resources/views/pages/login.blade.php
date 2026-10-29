<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h1>ログイン</h1>

    <!-- エラーメッセージ表示 -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ログインフォーム -->
    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div>
            <label for="user_email">ユーザーID / メールアドレス:</label><br>
            <!-- email形式チェックを外し、通常のテキスト入力として受け付けます -->
            <input type="text" id="user_email" name="user_email" value="{{ old('user_email') }}" required autofocus>
        </div>

        <br>

        <div>
            <label for="user_password">パスワード:</label><br>
            <input type="password" id="user_password" name="user_password" required>
        </div>

        <br>

        <button type="submit">ログイン</button>
    </form>

    <hr>

    <p>
        アカウントをお持ちでない方:
        <a href="{{ route('create.account') }}">アカウント作成画面へ</a>
    </p>
</body>
</html>