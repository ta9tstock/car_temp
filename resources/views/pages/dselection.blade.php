<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>デバイス選択</title>
</head>
<body>
    <h1>デバイス選択画面 (dselection)</h1>
    
    <!-- 選択したとしてデバイスTOPへ -->
    <p><a href="{{ route('dtop') }}">デバイス1を選択してTOPへ</a></p>
    <hr>
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" onclick="return confirm('ログアウトしますか？')">ログアウト</button>
</form>
</body>
</html>