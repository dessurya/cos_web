<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContentMain extends Model
{
	protected $table = 'dcos_content_main_theme';

	protected $fillable = ['picture', 'title', 'content', 'type_id', 'type_title', 'type', 'flag_active', 'users_id'];

    public function getUsers(){
		return $this->belongsTo('App\Model\Users', 'users_id');
	}

	public function getGaleri($index){
		return $this->hasMany('App\Model\ContentGaleri', 'id_foreign', 'id')->where('index', $index)->orderBy('created_at', 'desc')->get();
	}

	public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
