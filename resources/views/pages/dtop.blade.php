<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>デバイスTOP</title>
</head>
<body>
    <h1>デバイスTOP画面 - 温度など表示 (dtop)</h1>
    <p><strong>選択中デバイス ID:</strong> {{ $deviceId }}</p>

    <!-- ナビゲーション -->
    <nav>
        <ul>
            <li><a href="{{ route('dselection') }}">← デバイス選択へ戻る</a></li>
            <li><a href="{{ route('dprediction') }}">予測画面へ</a></li>
            <li><a href="{{ route('dsetting') }}">設定画面へ</a></li>
            </li>
        </ul>
    </nav>

    <hr>

    <!-- 温度取得ボタン（最新データ取得のために画面更新） -->
    <form action="{{ route('dtop') }}" method="GET">
        <button type="submit">最新温度を取得</button>
    </form>

    <br>

    <!-- 温度データの表示 -->
    <h2>最新の測定情報</h2>
    @if ($latestTemp)
        <table border="1" cellpadding="5">
            <tr>
                <th>車内温度 (in_temp)</th>
                <td>{{ $latestTemp->in_temp }} ℃</td>
            </tr>
            <tr>
                <th>外気温 (out_temp)</th>
                <td>{{ $latestTemp->out_temp ?? '-' }} ℃</td>
            </tr>
            <tr>
                <th>湿度 (humidity)</th>
                <td>{{ $latestTemp->humidity ?? '-' }} %</td>
            </tr>
            <tr>
                <th>登録日時 (created_time)</th>
                <td>{{ $latestTemp->created_time }}</td>
            </tr>
        </table>
    @else
        <p>※登録されている温度データがありません。</p>
    @endif

</body>
</html>