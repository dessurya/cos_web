<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VusersLogs extends Model
{
    protected $table = 'vcos_users_logs';
    protected $fillable = ['users_id', 'name', 'logs', 'created_at'];
}
