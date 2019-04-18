<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContentBanner extends Model
{
	protected $table = 'dcos_content_banner';

    protected $fillable = ['picture', 'title', 'content', 'url', 'flag_active', 'users_id'];

    public function getUsers(){
		return $this->belongsTo('App\Model\Users', 'users_id');
	}

	public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
