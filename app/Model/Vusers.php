<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vusers extends Model
{
	protected $table = 'vcos_users';
    protected $fillable = ['name', 'email', 'login_count', 'last_login', 'flag_active'];
}
