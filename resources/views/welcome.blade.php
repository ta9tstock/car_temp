<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>トップページ</title>
</head>
<body>
    <h1>トップページ</h1>
    <p>現在の環境: {{ config('app.env') }}</p>
    
    <!-- route() を使えば環境に合わせて自動で正しいURLが生成されます -->
    <p><a href="{{ route('test') }}">テストページへ移動</a></p>
</body>
</html>