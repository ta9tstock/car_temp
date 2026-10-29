<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // テーブル名と主キーの明示
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    // 一括保存可能なカラム
    protected $fillable = [
        'user_name',
        'user_email',
        'user_password',
    ];

    // 非表示カラム
    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    // パスワード自動ハッシュ化の設定（Laravel 11）
    protected function casts(): array
    {
        return [
            'user_password' => 'hashed',
        ];
    }

    /**
     * Laravel標準の認証処理（Auth::attemptなど）で
     * パスワードカラムとして user_password を使うための指定
     */
    public function getAuthPasswordName()
    {
        return 'user_password';
    }
}