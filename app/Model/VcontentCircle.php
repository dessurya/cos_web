<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VcontentCircle extends Model
{
	protected $table = 'vcos_content_circle';

	protected $fillable = ['picture', 'title', 'subject', 'flag_active', 'users_id'];
}
