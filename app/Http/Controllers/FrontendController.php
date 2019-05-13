<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;
use Route;
use Analytics;
use Validator;
use Spatie\Analytics\Period;
use App\Model\ContentBanner;
use App\Model\ContentNewsEvent;
use App\Model\ContentPolitics;
use App\Model\ContentCircle;
use App\Model\ContentComments;
use App\Model\ContentPage;

class FrontendController extends Controller{

	public static function navbar_static(){
		$html = '';
		$routename = Route::currentRouteName();
		if (ContentPolitics::where('flag_active', 'Y')->count() >= 1) {
			if($routename == 'main.politic' or $routename == 'main.politic.show'){ $class = 'active'; } 
			else { $class = ''; }
			$html .= '<div class="col">';
			$html .= '<a class="'.$class.'" href="'. route('main.politic') .'">';
			$html .= 'SDG And Politics';
			$html .= '</a>';
			$html .= '</div>';
		}
		if (ContentCircle::where('flag_active', 'Y')->count() >= 1) {
			if($routename == 'main.circle' or $routename == 'main.circle.show'){ $class = 'active'; } 
			else { $class = ''; }
			$html .= '<div class="col">';
			$html .= '<a class="'.$class.'" href="'. route('main.circle') .'">';
			$html .= 'Circle';
			$html .= '</a>';
			$html .= '</div>';
		}
		if (ContentNewsEvent::where('flag_active', 'Y')->count() >= 1) {
			if($routename == 'main.newsevent' or $routename == 'main.newsevent.show'){ $class = 'active'; } 
			else { $class = ''; }
			$html .= '<div class="col">';
			$html .= '<a class="'.$class.'" href="'. route('main.newsevent') .'">';
			$html .= 'News Event';
			$html .= '</a>';
			$html .= '</div>';
		}
		return $html;
	}

	public function home(){
		$about = ContentPage::find(1);
		$banner = ContentBanner::where('flag_active', 'Y')->orderBy('created_at', 'desc')->limit(5)->get();
		$politics = ContentPolitics::where('flag_active', 'Y')->orderBy('created_at', 'desc')->limit(3)->get();
		$circle = ContentCircle::where('flag_active', 'Y')->orderBy('created_at', 'desc')->limit(6)->get();
		return view('frontend.home.index', compact(
			'about',
			'banner',
			'politics',
			'circle'
		));
	}

	public function about(){
		$about = ContentPage::find(1);
		$visi = ContentPage::find(2);
		$misi = ContentPage::find(3);
		return view('frontend.about.index', compact('about', 'visi', 'misi'));
	}

	public function contact(){
		return view('frontend.contact.index');
	}

	public function circle(){
		$page = ContentPage::find(4);
		$data = ContentCircle::where('flag_active', 'Y')->orderBy('created_at', 'desc')->paginate(4);
		return view('frontend.circle.index', compact('page', 'data'));
	}

	public function circleData(request $req){
		$data = ContentCircle::where('flag_active', 'Y')->orderBy('created_at', 'desc')->paginate(4);
		$view = "";
		foreach ($data as $list) {
			$view .= '<div class="item">';
			$view .= '<div class="flot img">';
			$view .= '<div id="pict" style="background-image: url('.asset('asset/picture/circle/'.$list->id.'/'.$list->picture).');">';
			$view .= '<div class="tab">';
			$view .= '<div class="row">';
			$view .= '<div class="col">';
			$view .= '<div id="absen"></div>';
			$view .= '</div></div></div></div></div>';
			$view .= '<div class="flot content"><div class="tab"><div class="row"><div class="col">';
			$view .= '<div>';
			$view .= '<h3>'.$list->title.'</h3>';
			$view .= '<h4>'.$list->subject.'</h4>';
			$view .= '<p>'.Str::words(strip_tags($list->content), 65, ' ...').'</p>';
			$view .= '<a class="links" href="'.route('main.circle.show', ['slug' => $list->slug]).'">View More</a>';
			$view .= '</div></div></div></div></div>';
			$view .= '<div class="clearfix"></div></div>';
		}
		return response()->json(['html'=>$view]);		
	}

	public function circleShow($slug){
		$data = ContentCircle::where('flag_active', 'Y')->where('slug', $slug)->first();
		if($data){
			$comments = ContentComments::where('index', 'circle')->where('id_foreign', $data->id)->orderBy('created_at', 'desc')->get();
			return view('frontend.circle.show', compact('data', 'comments'));
		}else{
			return redirect()->route('main.home');
		}
	}

	public function politic(){
		$page = ContentPage::find(5);
		$data = ContentPolitics::where('flag_active', 'Y')->orderBy('created_at', 'desc')->paginate(4);
		return view('frontend.politic.index', compact('data', 'page'));
	}

	public function politicData(request $req){
		$data = ContentPolitics::where('flag_active', 'Y')->orderBy('created_at', 'desc')->paginate(4);
		$view = "";
		foreach ($data as $list) {
			$view .= '<div class="item">';
			$view .= '<div class="flot img">';
			$view .= '<div id="pict" style="background-image: url('.asset('asset/picture/politics/'.$list->id.'/'.$list->picture).');">';
			$view .= '<div class="tab">';
			$view .= '<div class="row">';
			$view .= '<div class="col">';
			$view .= '<div id="absen"></div>';
			$view .= '</div></div></div></div></div>';
			$view .= '<div class="flot content"><div class="tab"><div class="row"><div class="col">';
			$view .= '<div>';
			$view .= '<h1>'.$list->title.'</h1>';
			$view .= '<p>'.Str::words(strip_tags($list->content), 65, ' ...').'</p>';
			$view .= '<a class="links" href="'.route('main.politic.show', ['slug' => $list->slug]).'">View More</a>';
			$view .= '</div></div></div></div></div>';
			$view .= '<div class="clearfix"></div></div>';
		}
		return response()->json(['html'=>$view]);		
	}

	public function politicShow($slug){
		$data = ContentPolitics::where('flag_active', 'Y')->where('slug', $slug)->first();
		if($data){
			$comments = ContentComments::where('index', 'politics')->where('id_foreign', $data->id)->orderBy('created_at', 'desc')->get();
			return view('frontend.politic.show', compact('data', 'comments'));
		}else{
			return redirect()->route('main.home');
		}
	}

    public function newsevent(){
		$newsevent = ContentNewsEvent::where('flag_active', 'Y')->orderBy('created_at', 'desc')->paginate(4);
		return view('frontend.newsevent.index', compact('newsevent'));
	}

	public function newseventData(request $req){
		$newsevent = ContentNewsEvent::where('flag_active', 'Y')->orderBy('created_at', 'desc')->paginate(4);
		$view = "";
		foreach ($newsevent as $list) {
			$view .= '<div class="item">';
			$view .= '<div class="flot img">';
			$view .= '<div id="pict" style="background-image: url('.asset('asset/picture/news-event/'.$list->id.'/'.$list->picture).');">';
			$view .= '<div class="tab">';
			$view .= '<div class="row">';
			$view .= '<div class="col">';
			$view .= '<div id="absen"></div>';
			$view .= '</div></div></div></div></div>';
			$view .= '<div class="flot content"><div class="tab"><div class="row"><div class="col">';
			$view .= '<div>';
			$view .= '<h1>'.$list->title.'</h1>';
			$view .= '<p>'.Str::words(strip_tags($list->content), 65, ' ...').'</p>';
			$view .= '<a class="links" href="'.route('main.newsevent.show', ['slug' => $list->slug]).'">View More</a>';
			$view .= '</div></div></div></div></div>';
			$view .= '<div class="clearfix"></div></div>';
		}
		return response()->json(['html'=>$view]);		
	}

	public function newseventShow($slug){
		$newsevent = ContentNewsEvent::where('flag_active', 'Y')->where('slug', $slug)->first();
		if($newsevent){
			return view('frontend.newsevent.show', compact('newsevent'));
		}else{
			return redirect()->route('main.home');
		}
	}

	public function comments(request $request){
		$message = [];

        $validator = Validator::make($request->all(), [
          'name' => 'nullable|min:4|max:30',
          'email' => 'nullable|email',
          'comments' => 'required|min:60|max:500',
        ], $message);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('autofocus', true);
        }

		$data = New ContentComments;
		$data->index = $request->index;
		$data->id_foreign = $request->id_foreign;
		$data->name = $request->name == "" ? "Unknow" : $request->name;
		$data->email = $request->email == "" ? "Unknow" : $request->email;
		$data->comments = $request->comments;
		$data->save();

		return back();
	}
}
