<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\Users;

use Auth;
use DataTables;
use Hash;
use Validator;
use MyHelperAsd;

class CmsAccountsController extends Controller{
    public function index(){
    	$config = array();
    	// datatable config
	    	$config['table'][0]['label'] = 'No';
	    	$config['table'][0]['name'] = 'id';
	    	$config['table'][0]['search'] = 'false';
	    	$config['table'][0]['orderable'] = 'true';
	    	$config['table'][1]['label'] = 'Status';
	    	$config['table'][1]['name'] = 'flag_active';
	    	$config['table'][1]['search'] = 'true';
	    	$config['table'][1]['orderable'] = 'true';
	    	$config['table'][2]['label'] = 'Email';
	    	$config['table'][2]['name'] = 'email';
	    	$config['table'][2]['search'] = 'true';
	    	$config['table'][2]['orderable'] = 'true';
	    	$config['table'][3]['label'] = 'Name';
	    	$config['table'][3]['name'] = 'name';
	    	$config['table'][3]['search'] = 'true';
	    	$config['table'][3]['orderable'] = 'true';
	    	$config['table'][4]['label'] = 'Login Count';
	    	$config['table'][4]['name'] = 'login_count';
	    	$config['table'][4]['search'] = 'true';
	    	$config['table'][4]['orderable'] = 'true';
	    	$config['table'][5]['label'] = 'Last Login';
	    	$config['table'][5]['name'] = 'last_login';
	    	$config['table'][5]['search'] = 'true';
	    	$config['table'][5]['orderable'] = 'true';
		    $config['table_ajaxUrl'] = route('cms.account.data');
		    $config['table_fieldSort'] = 3;
    	// datatable config
	    // tools config
		    $config['tools'][0]['label'] = 'Add';
		    $config['tools'][0]['action'] = 'form';
		    $config['tools'][0]['value'] = '';
		    $config['tools'][0]['selected'] = 'false';
		    $config['tools'][0]['confirm'] = 'false';
		    $config['tools'][1]['label'] = 'Reset Password';
		    $config['tools'][1]['action'] = 'reset_password';
		    $config['tools'][1]['value'] = '';
		    $config['tools'][1]['selected'] = 'true';
		    $config['tools'][1]['confirm'] = 'true';
		    $config['tools'][2]['label'] = 'Activated';
		    $config['tools'][2]['action'] = 'activated';
		    $config['tools'][2]['value'] = 'Y';
		    $config['tools'][2]['selected'] = 'true';
		    $config['tools'][2]['confirm'] = 'true';
		    $config['tools'][3]['label'] = 'Non Activated';
		    $config['tools'][3]['action'] = 'activated';
		    $config['tools'][3]['value'] = 'N';
		    $config['tools'][3]['selected'] = 'true';
		    $config['tools'][3]['confirm'] = 'true';
		    $config['tools'][4]['label'] = 'Delete';
		    $config['tools'][4]['action'] = 'delete';
		    $config['tools'][4]['value'] = '';
		    $config['tools'][4]['selected'] = 'true';
		    $config['tools'][4]['confirm'] = 'true';
	    // tools config
	    $config['tools_ajaxUrl'] = route('cms.account.tools');
    	return view('cms.accounts.index', compact('config'));
    }

    public function callData(request $req){
    	$id = Auth::user()->id;
		$data = Users::whereNotIn('id',[$id]);
		if (isset($req->post)) {
			foreach ($req->post as $key => $val) {
				if ($key == 'flag_active') {
					if (strtoupper($val) == 'ACTIVE') {
						$find = 'Y';
					}else if (strtoupper($val) == 'NON ACTIVE'){
						$find = 'N';
					}else{
						$find = 'A';
					}
				}else{
					$find = $val;
				}
				$data->where($key, 'like', '%'.$find.'%');
			}
		}
		$data->get();

		return Datatables::of($data)->editColumn('flag_active', function ($data){
				$html = '';
				if($data->flag_active == 'Y'){
					return "Active";
				} else if($data->flag_active == 'N'){
					return "Non Active";
				}
			})->escapeColumns(['*'])->make(true);
    }

    public function tools(request $req){
    	$act = $req->input('action');
    	$inp = $req->input();
    	$res = array();
    	$res['response'] = true;
    	$res['input'] = $req->input();
    	$res['type'] = $req->input('action');

    	if ($act == 'form') {
    		$res['result'] = $this->callForm($inp);
    	}else if($act == 'store') {
    		$res['result'] = $this->storeForm($inp);
    		$res['msg'] = "Success to store data";
    		if ($res['result']['response'] == true) {
	    		$res['refresh_tab'] = true;
    		}else{
    			$res['response'] = false;
    			$res['msg'] = $res['result']['msg'];
    		}
    	}else if($act == 'reset_password'){
    		$res['result'] = $this->resetPassword($inp);
    		$res['msg'] = $res['result']['msg'];
    		$res['refresh_tab'] = true;
    	}else if($act == 'activated'){
    		$res['result'] = $this->activated($inp);
    		$res['msg'] = $res['result']['msg'];
    		$res['refresh_tab'] = true;
    	}else if($act == 'delete'){
    		$res['result'] = $this->delete($inp);
    		$res['msg'] = $res['result']['msg'];
    		$res['refresh_tab'] = true;
    	}else{
    		$res['response'] = false;
			$res['msg'] = 'Not have this action!';
    	}

    	if ($res['response'] == true and isset($res['msg'])) {
    		$logs = array();
    		$logs['msg'] = 'Users '.Str::title(str_replace('_', ' ', $act)).' | '.$res['msg'];
	    	MyHelperAsd::storeLogs($logs);
    	}
    	return response()->json($res);
    }

    private function callForm($data){
    	$res = array();
		$res['title'] = 'Add New Data';
    	$res['view'] = view('cms.accounts.form', compact('find'))->render();
    	return $res;
    }

    private function storeForm($data){
    	$res = array();
    	$res['response'] = true;
    	$message = [];
    	$validator = Validator::make($data, [
    		'name' => 'required|min:3',
			'email' => 'required|email|unique:dcos_users,email',
    	], $message);
    	if($validator->fails()){
    		$res['response'] = false;
            $res['error'] = $validator->getMessageBag()->toArray();
            $res['msg'] = 'Sorry...! Something Wrong!';
    		return $res;
    	}
    	$res['form'] = $this->callForm($data);
    	$res['newform'] = true;
		$store = new Users;
		$store->name = $data['name'];
		$store->email = $data['email'];
		$store->password = Hash::make('type1to8');
		$store->flag_active = "N";
		$store->remember_token = str_random(30).time();
		$store->save();
    	return $res;
    }

    private function resetPassword($data){
    	$res = array();
    	$res['msg'] = 'Success, reset password user : ';
    	$ids = explode('^', $data['id']);
    	foreach ($ids as $list) {
    		$store = Users::find($list);
    		$store->password = Hash::make('type1to8');
    		$store->save();
    		$res['msg'] .= $store->name.', ';
    	}
    	$res['msg'] = substr($res['msg'], 0, -2);
    	return $res;
    }

    private function activated($data){
    	$res = array();
    	if ($data['val'] == 'Y') { $type = 'activated'; }
    	else{ $type = 'non activated'; }
    	$res['msg'] = 'Success, '.$type.' user : ';
    	$ids = explode('^', $data['id']);
    	foreach ($ids as $list) {
    		$store = Users::find($list);
    		$store->flag_active = $data['val'];
    		$store->save();
    		$res['msg'] .= $store->name.', ';
    	}
    	$res['msg'] = substr($res['msg'], 0, -2);
    	return $res;
    }

    private function delete($data){
    	$res = array();
    	$res['msg'] = 'Success, delete user : ';
    	$ids = explode('^', $data['id']);
    	foreach ($ids as $list) {
    		$store = Users::find($list);
    		$store->delete();
    		$res['msg'] .= $store->name.', ';
    	}
    	$res['msg'] = substr($res['msg'], 0, -2);
    	return $res;
    }
}
