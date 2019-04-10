<?php
namespace App\Helper;

use App\Model\UsersLogs;
use Auth;

class MyHelperAsd {
	public static function storeLogs($data){
		$record = new UsersLogs;
        $record->users_id = Auth::user()->id;
        $record->logs = $data['msg'];
        $record->save();
	}
}