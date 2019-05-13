<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VcontentMain extends Model
{
	protected $table = 'vcos_content_main';

	protected $fillable = ['picture', 'title', 'type_id', 'type_title', 'type', 'flag_active', 'users_id'];
}
