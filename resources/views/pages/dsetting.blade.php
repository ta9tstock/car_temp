<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>設定画面</title>
</head>
<body>
    <h1>設定画面 (dsetting)</h1>
    <p><strong>選択中デバイス ID:</strong> {{ $deviceId }}</p>

    <!-- エラー表示 -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr>

    <h2>デバイスメンバーの快適温度設定一覧</h2>

    @if ($tempSettings->isEmpty())
        <p>設定されている温度データはありません。</p>
    @else
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>ユーザー名 (ID)</th>
                    <th>最高温度 (MAX)</th>
                    <th>最低温度 (MIN)</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tempSettings as $setting)
                    <tr>
                        <!-- 編集用フォーム -->
                        <form action="{{ route('temp_settings.update', $setting->temp_settings_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <td>
                                {{ $setting->user->user_name ?? '不明' }} (ID: {{ $setting->user_id }})
                            </td>
                            <td>
                                <input type="number" name="MAX_temp" value="{{ $setting->MAX_temp }}" required> ℃
                            </td>
                            <td>
                                <input type="number" name="MIN_temp" value="{{ $setting->MIN_temp }}" required> ℃
                            </td>
                            <td>
                                <button type="submit">更新</button>
                        </form>
                        
                        <!-- 削除用フォーム -->
                        <form action="{{ route('temp_settings.destroy', $setting->temp_settings_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('削除しますか？')">削除</button>
                        </form>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <hr>

    <h2>新規温度設定の追加</h2>
    <form action="{{ route('temp_settings.store') }}" method="POST">
        @csrf
        <div>
            <label for="user_id">対象ユーザー:</label>
            <select name="user_id" id="user_id" required>
                @foreach ($members as $member)
                    <option value="{{ $member->user_id }}">{{ $member->user_name }} (ID: {{ $member->user_id }})</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="MAX_temp">最高温度 (MAX):</label>
            <input type="number" name="MAX_temp" id="MAX_temp" required> ℃
        </div>
        <br>
        <div>
            <label for="MIN_temp">最低温度 (MIN):</label>
            <input type="number" name="MIN_temp" id="MIN_temp" required> ℃
        </div>
        <br>
        <button type="submit">設定を追加</button>
    </form>

    <hr>
    <p><a href="{{ route('dtop') }}">← デバイスTOPへ戻る</a></p>
</body>
</html>