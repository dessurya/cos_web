<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

use Auth;
use DataTables;
use Hash;
use MyHelperAsd;
use File;

class CmsContentsController extends Controller{

	public function index($index, request $req){
    	$config = MyHelperAsd::getConfigContents($index);
    	return view('cms.contents.index', compact('index','config'));
    }

    public function callData($index, request $req){
    	$Model = "App\Model\Vcontent".Str::studly($index);
		$data = $Model::get();
    	if (in_array($index, array('banner'))) {
			return Datatables::of($data)->editColumn('picture', function($data) use($index){
					return '<a class="pict" href="'.asset('asset/picture/'.$index.'/'.$data->id.'/'.$data->picture).'">'.$data->picture.'</a>';
				})
			->escapeColumns(['*'])->make(true);
    	}
    }

    public function tools($index, request $req){
    	$act = $req->input('action');
    	$inp = $req->all();
    	$res = array();
    	$res['response'] = true;
    	$res['input'] = $req->all();
    	$res['type'] = $req->action;

    	if ($act == 'form') {
    		$res['result'] = $this->callForm($index, $inp);
    	}else if($act == 'store') {
    		$res['result'] = $this->storeForm($index, $inp);
			$res['msg'] = $res['result']['msg'];
    		if ($res['result']['response'] == true) {
	    		$res['refresh_tab'] = true;
    		}else{
    			$res['response'] = false;
    		}
    	}else if($act == 'activated'){
    		$res['result'] = $this->activated($index, $inp);
    		$res['msg'] = $res['result']['msg'];
    		$res['refresh_tab'] = true;
    	}else if($act == 'delete'){
    		$res['result'] = $this->delete($index, $inp);
    		$res['msg'] = $res['result']['msg'];
    		$res['refresh_tab'] = true;
    	}else{
    		$res['response'] = false;
			$res['msg'] = 'Not have this action!';
    	}

    	if ($res['response'] == true and isset($res['msg'])) {
    		$logs = array();
    		$logs['msg'] = 'Content '.Str::title(str_replace('_', ' ', $index)).' '.Str::title(str_replace('_', ' ', $act)).' | '.$res['msg'];
	    	MyHelperAsd::storeLogs($logs);
    	}
    	return response()->json($res);
    }

    private function callForm($index, $data){
    	$res = array();
    	$find = null;
    	$titl = 'Add New Data';
    	if (isset($data['id']) and $data['id'] >= 1) {
    		$Model = "App\Model\Content".Str::studly($index);
    		$find = $Model::find($data['id']);
			$titl = 'Update Data';
    	}
		$res['title'] = $titl;
    	$res['view'] = view('cms.contents.'.$index, compact('titl', 'find'))->render();

    	if (in_array($index, array('news'))) {
    		$res['ckeditor'] = true;
    	}
    	return $res;
    }

    private function storeForm($index, $data){
    	$res = array();
    	$res['response'] = true;
    	$valid = MyHelperAsd::validStoreContents($index, $data);
    	if ($valid['response'] == false) {
    		$res['response'] = false;
    		$res['error'] = $valid['resault'];
    		$res['msg'] = $valid['msg'];
    		return $res;
    	}
    	$res['newform'] = true;
		$res['msg'] = MyHelperAsd::storeContents($index, $data);
    	$res['form'] = $this->callForm($index, $data);
    	return $res;
    }

    private function activated($index, $data){
    	$res = array();
    	if ($data['val'] == 'Y') { $type = 'activated'; }
    	else{ $type = 'non activated'; }
    	$res['msg'] = 'Success, '.$type.' : ';
    	$ids = explode('^', $data['id']);
    	foreach ($ids as $list) {
    		$Model = "App\Model\Content".Str::studly($index);
    		$store = $Model::find($list);
    		$store->flag_active = $data['val'];
    		$store->save();
    		if (in_array($index, array('banner'))) {
	    		$res['msg'] .= $store->title.', ';
    		}else{
    			$res['msg'] .= $store->name.', ';
    		}
    	}
    	$res['msg'] = substr($res['msg'], 0, -2);
    	return $res;
    }

    private function delete($index, $data){
    	$res = array();
    	$res['msg'] = 'Success, delete : ';
    	$ids = explode('^', $data['id']);
    	foreach ($ids as $list) {
    		$Model = "App\Model\Content".Str::studly($index);
    		$store = $Model::find($list);
    		$columns=$store->getTableColumns(); // memanggil semua column/field pada table
    		if(in_array('picture', $columns)){
    			$directory = public_path().'/asset/picture/'.$index.'/'.$store->id;
    			if ($store->picture != null) {
					File::delete($directory.'/'.$store->picture);
					File::deleteDirectory($directory);
				}
    		}
    		$store->delete();
    		if (in_array($index, array('banner'))) {
	    		$res['msg'] .= $store->title.', ';
    		}else{
    			$res['msg'] .= $store->name.', ';
    		}
    	}
    	$res['msg'] = substr($res['msg'], 0, -2);
    	return $res;
    }
}
