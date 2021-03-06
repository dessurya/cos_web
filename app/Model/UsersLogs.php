<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersLogs extends Model
{
    protected $table = 'dcos_users_logs';

    protected $fillable = ['logs', 'users_id'];

    public function getUsers(){
		return $this->belongsTo('App\Model\Users', 'users_id');
	}

	public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
