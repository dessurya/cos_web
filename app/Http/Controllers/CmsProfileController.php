<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;

use Auth;
use Hash;
use Validator;

class CmsProfileController extends Controller{
    public function index(){
    	return view('cms.profile.index');
    }
    public function store(request $req){
    	$res = array();
    	$res['response'] = true;
    	$res['request'] = $req->input();
    	$res['type'] = 'profile_store';

    	$id = Auth::user()->id;
    	$message = [];
    	$validator = Validator::make($req->all(), [
    		'name' => 'required|min:3',
			'email' => 'required|email|unique:dcos_users,email,'.$id,
			'old_pass' => 'required',
			'new_pass' => 'nullable|min:8',
			'retype_pass' => 'nullable|required_with:new_pass|min:8|same:new_pass',
    	], $message);
    	if($validator->fails()){
    		$res['response'] = false;
            $res['error'] = $validator->getMessageBag()->toArray();
            $res['msg'] = 'Sorry...! Something Wrong!';
    		return response()->json($res);
    	}

    	$me = Users::find($id);

    	if(Hash::check($req->old_pass, $me->password)){
			if ($req->new_pass) {
				$me->password = Hash::make($req->new_pass);
			}

			$me->name = $req->name;
			$me->save();

            $res['msg'] = 'Success! Your Profile Change...';
			return response()->json($res);
		}
		else{
    		$res['response'] = false;
            $res['msg'] = 'Sorry...! Something Wrong!';
            $res['error'] = array('old_pass' => 'not valid old password');
			return response()->json($res);
		}
    }
}
