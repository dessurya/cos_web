<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
// use App\Model\Users;
use App\Model\UsersLogs;
use App\Model\VusersLogs;

use Auth;
use DataTables;
use Hash;

class CmsUsersLogsController extends Controller{
	public function index(){
    	$config = array();
    	// datatable config
	    	$config['table'][0]['label'] = 'No';
	    	$config['table'][0]['name'] = 'id';
	    	$config['table'][0]['search'] = 'false';
	    	$config['table'][0]['orderable'] = 'true';
	    	$config['table'][1]['label'] = 'Date';
	    	$config['table'][1]['name'] = 'created_at';
	    	$config['table'][1]['search'] = 'true';
	    	$config['table'][1]['orderable'] = 'true';
	    	$config['table'][2]['label'] = 'Account';
	    	$config['table'][2]['name'] = 'name';
	    	$config['table'][2]['search'] = 'true';
	    	$config['table'][2]['orderable'] = 'true';
	    	$config['table'][3]['label'] = 'Logs';
	    	$config['table'][3]['name'] = 'logs';
	    	$config['table'][3]['search'] = 'true';
	    	$config['table'][3]['orderable'] = 'true';
		    $config['table_ajaxUrl'] = route('cms.history.data');
		    $config['table_fieldSort'] = 1;
    	// datatable config
    	return view('cms.history.index', compact('config'));
    }

    public function callData(request $req){
		$data = VusersLogs::get();
		return Datatables::of($data)->escapeColumns(['*'])->make(true);
    }
}
