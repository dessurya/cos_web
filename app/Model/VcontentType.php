<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VcontentType extends Model
{
	protected $table = 'vcos_content_type';

	protected $fillable = ['picture', 'title', 'type', 'content', 'flag_active', 'users_id'];
}
