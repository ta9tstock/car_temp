<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>デバイス選択</title>
</head>
<body>
    <h1>デバイス選択画面 (dselection)</h1>

    <!-- POST送信で look_device を指定してデバイス切り替え -->
    <form action="{{ route('select.device') }}" method="POST">
        @csrf
        <label for="look_device">デバイス番号を選択/入力:</label>
        <input type="number" name="look_device" value="1" required>
        <button type="submit">このデバイスを選択してTOPへ</button>
    </form>

    <hr>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
</body>
</html>