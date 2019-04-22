<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VcontentNewsEvent extends Model
{
	protected $table = 'vcos_content_news_event';

	protected $fillable = ['picture', 'title', 'content', 'flag_active', 'users_id'];
}
