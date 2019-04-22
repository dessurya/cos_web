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
use Image;

use App\Model\ContentGaleri;

class CmsContentsController extends Controller{

	public function index($index, request $req){
    	$config = MyHelperAsd::getConfigContents($index);
    	return view('cms.contents.index', compact('index','config'));
    }

    public function callData($index, request $req){
    	$Model = "App\Model\Vcontent".Str::studly($index);
		$data = $Model::get();
    	if (in_array($index, array('banner', 'news-event'))) {
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
    	}else if($act == 'add-galeri'){
    		$res['result'] = $this->addGaleri($index, $inp);
    		$res['msg'] = $res['result']['msg'];
    	}else if($act == 'delete-galeri'){
    		$res['result'] = $this->deleteGaleri($index, $inp);
    		$res['msg'] = $res['result']['msg'];
    	}else{
    		$res['response'] = false;
			$res['msg'] = 'Not have this action!';
    	}

    	if ($res['response'] == true and isset($res['msg'])) {
    		$logs = array();
    		$logs['msg'] = 'Content '.Str::title(str_replace('-', ' ', $index)).' '.Str::title(str_replace('-', ' ', $act)).' | '.$res['msg'];
	    	MyHelperAsd::storeLogs($logs);
    	}
    	return response()->json($res);
    }

    private function callForm($index, $data){
    	$res = array();
    	$find = null;
    	$titl = 'Add New Data';
    	if (isset($data['id']) and ($data['id'] >= 1 or ($data['id'] == true and isset($data['val']) and $data['val'] >= 1))) {
    		if ($data['id'] == true and isset($data['val']) and $data['val'] >= 1) {
    			$data['id'] = $data['val'];
    		}
    		$Model = "App\Model\Content".Str::studly($index);
    		$find = $Model::find($data['id']);
			$titl = 'Update Data';
    	}
		$res['title'] = $titl;
    	$res['view'] = view('cms.contents._'.$index, compact('titl', 'find', 'index'))->render();

    	if (in_array($index, array('news-event'))) {
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
    		if (in_array($index, array('news-event'))) {
    			ContentGaleri::where('index', $index)->where('id_foreign', $list)->delete();
    		}
    		$Model = "App\Model\Content".Str::studly($index);
    		$store = $Model::find($list);
    		$columns=$store->getTableColumns(); // memanggil semua column/field pada table
    		if(in_array('picture', $columns)){
    			$directory = public_path().'/asset/picture/'.$index.'/'.$store->id;
    			if ($store->picture != null) {
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

    private function addGaleri($index, $data){
    	$res = array();
    	$res['response'] = true;

    	$store = new ContentGaleri;
    	$store->index = $data['index'];
    	$store->id_foreign = $data['id'];
    	$store->users_id = Auth::user()->id;
    	$directory = public_path().'/asset/picture/'.$data['index'].'/'.$data['id'].'/galeri';
		if (!File::exists($directory)) {
			File::makeDirectory($directory,0777,true);
		}
		$image = $data['file'];
		$img_url = date('His').$image->getClientOriginalName();
		$upload1 = Image::make($image)->encode('data-url');
		$upload1->save($directory.'/'.$img_url);
		$store->picture = $img_url;
		$store->save();
		$res['msg'] = "Success store picture";
		$res['add'] = '<li class="this_'.$store->id.'">';
		$res['add'] .= '<span class="mailbox-attachment-icon has-img">';
		$res['add'] .= '<div style="background-image: url('.asset('asset/picture/'.$data['index'].'/'.$store->id_foreign.'/galeri/'.$store->picture) .'); background-position: center; background-size: cover; background-repeat: no-repeat; height: 160px; width: 100%;"></div>';
		$res['add'] .= '</span>';
		$res['add'] .= '<div class="mailbox-attachment-info">';
		$res['add'] .= '<a href="'. asset('asset/picture/'.$data['index'].'/'.$store->id_foreign.'/galeri/'.$store->picture) .'" class="mailbox-attachment-name view" alt="'. $store->picture .'" title="'. $store->picture .'">'. substr($store->picture, -12) .'</a>';
		$res['add'] .= '<a href="#" class="tools btn btn-default btn-xs pull-right" alt="delete" title="delete" data-action="delete-galeri" data-sel="false" data-mulsel="false" data-conf="true" data-val="'. $store->id .'"><i class="fa fa-trash-o"></i></a>';
		$res['add'] .= '</div>';
		$res['add'] .= "</li>";
    	return $res;
    }

    private function deleteGaleri($index, $data){
    	$res = array();
		$store = ContentGaleri::find($data['val']);
		$directory = public_path().'/asset/picture/'.$index.'/'.$store->id_foreign.'/galeri/';
		File::delete($directory.'/'.$store->picture);
		$store->delete();
    	$res['id'] = "this_".$data['val'];
    	$res['msg'] = "Success to delete";
    	return $res;
    }
}
