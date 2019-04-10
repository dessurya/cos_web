<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersLogs extends Model{
    protected $table = 'dcos_users_logs';

    protected $fillable = ['logs', 'users_id'];

    public function getUsers(){
		return $this->belongsTo('App\Model\Users', 'users_id');
	}

	// public function jLUsers($query){
	// 	$query->leftjoin('dcos_users as du','du.id', '=', 'dcos_users_logs.users_id')
 //        ->addSelect('du.name as user_name', 'du.email as user_email');
	// }

	public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
