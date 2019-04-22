<?php
namespace App\Helper;

use App\Model\UsersLogs;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DB;
use Image;
use File;

class MyHelperAsd {
	public static function storeLogs($data){
		$record = new UsersLogs;
        $record->users_id = Auth::user()->id;
        $record->logs = $data['msg'];
        $record->save();
	}

	public static function getConfigContents($index){
		if (!in_array($index, array('banner', 'news-event'))){
			return false;
		}
		$config = array();
    	// datatable config
    		if (in_array($index, array('banner', 'news-event'))) {
		    	$config['table'][0]['label'] = 'No';
		    	$config['table'][0]['name'] = 'id';
		    	$config['table'][0]['search'] = 'false';
		    	$config['table'][0]['orderable'] = 'true';
		    	$config['table'][1]['label'] = 'Status';
		    	$config['table'][1]['name'] = 'flag_active';
		    	$config['table'][1]['search'] = 'true';
		    	$config['table'][1]['orderable'] = 'true';
		    	$config['table'][2]['label'] = 'Created By';
		    	$config['table'][2]['name'] = 'name';
		    	$config['table'][2]['search'] = 'true';
		    	$config['table'][2]['orderable'] = 'true';
		    	$config['table'][3]['label'] = 'Created At';
		    	$config['table'][3]['name'] = 'created_at';
		    	$config['table'][3]['search'] = 'true';
		    	$config['table'][3]['orderable'] = 'true';
		    	$config['table'][4]['label'] = 'Title';
		    	$config['table'][4]['name'] = 'title';
		    	$config['table'][4]['search'] = 'true';
		    	$config['table'][4]['orderable'] = 'true';
		    	$config['table'][5]['label'] = 'picture';
		    	$config['table'][5]['name'] = 'picture';
		    	$config['table'][5]['search'] = 'false';
		    	$config['table'][5]['orderable'] = 'false';
			    $config['table_fieldSort'] = 3;
    		}
    	// datatable config
	    // tools config
		    if (in_array($index, array('banner', 'news-event'))) {
			    $config['tools'][0]['label'] = 'Add';
			    $config['tools'][0]['action'] = 'form';
			    $config['tools'][0]['value'] = '';
	            $config['tools'][0]['selected'] = 'false';
			    $config['tools'][0]['multiselect'] = 'false';
			    $config['tools'][0]['confirm'] = 'false';
			    $config['tools'][1]['label'] = 'Update';
			    $config['tools'][1]['action'] = 'form';
			    $config['tools'][1]['value'] = '';
	            $config['tools'][1]['selected'] = 'true';
			    $config['tools'][1]['multiselect'] = 'false';
			    $config['tools'][1]['confirm'] = 'false';
			    $config['tools'][2]['label'] = 'Activated';
			    $config['tools'][2]['action'] = 'activated';
			    $config['tools'][2]['value'] = 'Y';
			    $config['tools'][2]['selected'] = 'true';
	            $config['tools'][2]['multiselect'] = 'true';
			    $config['tools'][2]['confirm'] = 'true';
			    $config['tools'][3]['label'] = 'Non Activated';
			    $config['tools'][3]['action'] = 'activated';
			    $config['tools'][3]['value'] = 'N';
			    $config['tools'][3]['selected'] = 'true';
	            $config['tools'][3]['multiselect'] = 'true';
			    $config['tools'][3]['confirm'] = 'true';
			    $config['tools'][4]['label'] = 'Delete';
			    $config['tools'][4]['action'] = 'delete';
			    $config['tools'][4]['value'] = '';
			    $config['tools'][4]['selected'] = 'true';
	            $config['tools'][4]['multiselect'] = 'true';
			    $config['tools'][4]['confirm'] = 'true';
		    }
	    // tools config
	    $config['tools_ajaxUrl'] = route('cms.content.tools', ['index' => $index]);
	    $config['table_ajaxUrl'] = route('cms.content.data', ['index' => $index]);

	    return $config;
	}

	public static function validStoreContents($index, $data){
		$message = [];
		$Model = "App\Model\Content".Str::studly($index);
		if (isset($data['id'])) {
			$store = $Model::find($data['id']);
			if (!$store) {
				return response()->json([
					'response'=>false,
		         	'resault'=>null,
		         	'msg'=>'Sorry! Some Thing Wrong...! Not Found Your Data '
	         	]);
			}
			$id = $store->id;
		}

		if ($index == 'banner') {
			if (isset($id)) {
				$validator = Validator::make($data, [
					'title' => 'required|max:175',
					'url' => 'nullable|max:175',
					'content' => 'nullable|max:175',
					'picture' => 'nullable|image|mimes:jpeg,jpg,png|max:6500',
				], $message);
			} else {
				$validator = Validator::make($data, [
					'title' => 'required|max:175',
					'url' => 'nullable|max:175',
					'content' => 'nullable|max:175',
					'picture' => 'required|image|mimes:jpeg,jpg,png|max:6500',
				], $message);
			}
		} else if ($index == 'news-event') {
			if (isset($id)) {
				$validator = Validator::make($data, [
					'title' => 'required|max:175',
					'content' => 'required',
					'picture' => 'nullable|image|mimes:jpeg,jpg,png|max:6500',
				], $message);
			} else {
				$validator = Validator::make($data, [
					'title' => 'required|max:175',
					'content' => 'required',
					'picture' => 'required|image|mimes:jpeg,jpg,png|max:6500',
				], $message);
			}
		} else{
			return array(
				'response'=>false,
	         	'resault'=>null,
	         	'msg'=>'Not have this action!'
			);
		}

		if($validator->fails()){
			return array(
				'response'=>false,
	         	'resault'=>$validator->getMessageBag()->toArray(),
	         	'msg'=>'Sorry! Some Thing Wrong...!'
			);
		}
		return array(
			'response'=>true
		);
	}

	public static function storeContents($index, $data){
		$res = array();
		$resault = DB::transaction(function() use($index, $data){
			$Model = "App\Model\Content".Str::studly($index);
			$id = null;
			$nD = null;
			$oD = null;
			if (isset($data['id'])) {
				$store = $Model::find($data['id']);
				$id = $store->id;
				$msg = "Success to update data ";
			}else {
				$store = new $Model;
				$msg = "Success to store data ";
			}

			$columns=$store->getTableColumns(); // memanggil semua column/field pada table

			if (isset($data['url']) and in_array('url', $columns)) {
				$store->url = $data['url'];
			}

			if (isset($data['content']) and in_array('content', $columns)) {
				$store->content = $data['content'];
			}
			
			if (isset($data['title']) and in_array('title', $columns)) {
				if ($id == null or $store->title == $data['title']) {
					$addmsg = $data['title'];
				}else{
					$addmsg = $store->title.' to '.$data['title'];
				}
				$store->title = $data['title'];
				if (in_array('slug', $columns)) {
					$store->slug = Str::slug($data['title'], '-');
				}
			}

			if (isset($data['name']) and in_array('name', $columns)) {
				if ($id == null or $store->name == $data['name']) {
					$addmsg = $data['name'];
				}else{
					$addmsg = $store->name.' to '.$data['name'];
				}
				$store->name = $data['name'];
				if (in_array('slug', $columns)) {
					$store->slug = Str::slug($data['name'], '-');
				}
			}

			$store->users_id = Auth::user()->id;
			$store->save();

			if(isset($data['picture']) and in_array('picture', $columns)){
				
				$directory = public_path().'/asset/picture/'.$index.'/'.$store->id;
				if (!File::exists($directory)) {
					File::makeDirectory($directory,0777,true);
				}
				if ($store->picture != null) {
					File::delete($directory.'/'.$store->picture);
				}
				$image = $data['picture'];
				$img_url = $image->getClientOriginalName();
				$upload1 = Image::make($image)->encode('data-url');
				$upload1->save($directory.'/'.$img_url);
				$store->picture = $img_url;
			}
			$store->save();
			return $msg.$addmsg;
		});

		return $resault;
	}
}