<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContentComments extends Model
{
	protected $table = 'dcos_content_comments';

    protected $fillable = ['comments', 'name', 'email', 'index', 'id_foreign', 'users_id'];

    public function getUsers(){
		return $this->belongsTo('App\Model\Users', 'users_id');
	}

	public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
