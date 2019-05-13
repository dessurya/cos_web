<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VcontentService extends Model
{
	protected $table = 'vcos_content_service';

	protected $fillable = ['picture', 'title', 'content', 'flag_active', 'users_id'];
}
