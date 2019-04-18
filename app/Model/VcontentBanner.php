<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VcontentBanner extends Model
{
	protected $table = 'vcos_content_banner';
    protected $fillable = ['name', 'title', 'picture', 'flag_active'];
}
