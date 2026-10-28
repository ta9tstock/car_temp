<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    protected $table = 'temp';
    protected $primaryKey = 'temp_id';
    public $timestamps = false; // デフォルトの created_at/updated_at はオフ

    protected $fillable = [
        'device_id',
        'in_temp',
        'out_temp',
        'humidity',
        'solar',
        'get_time',
        'send_time',
        'created_time',
    ];
}