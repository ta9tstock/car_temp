<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempSetting extends Model
{
    protected $table = 'temp_settings';
    protected $primaryKey = 'temp_settings_id';

    protected $fillable = [
        'user_id',
        'MAX_temp',
        'MIN_temp',
    ];

    // 設定を所有するユーザーへのリレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}