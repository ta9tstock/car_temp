<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceMember extends Model
{
    protected $table = 'device_members';
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'device_id',
        'user_id',
    ];
}