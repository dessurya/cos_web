<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VcontentPage extends Model
{
	protected $table = 'vcos_content_page';

	protected $fillable = ['picture', 'title', 'content', 'flag_active'];
}
