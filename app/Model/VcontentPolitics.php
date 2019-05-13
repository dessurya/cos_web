<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VcontentPolitics extends Model
{
    protected $table = 'vcos_content_politics';

	protected $fillable = ['picture', 'title', 'subject', 'flag_active', 'users_id'];
}
