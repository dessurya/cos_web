<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
	protected $table = 'dcos_content_type';

	protected $fillable = ['picture', 'slug', 'title', 'content', 'flag_active', 'type', 'users_id'];

    public function getUsers(){
		return $this->belongsTo('App\Model\Users', 'users_id');
	}

	public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
