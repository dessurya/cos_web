<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContentGaleri extends Model
{
	protected $table = 'dcos_galeri_content';

    protected $fillable = ['picture', 'index', 'id_foreign', 'users_id'];

    public function getUsers(){
		return $this->belongsTo('App\Model\Users', 'users_id');
	}

	public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
