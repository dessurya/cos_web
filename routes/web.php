<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('main.')->group(function(){
	Route::get('/', 'FrontendController@home')
		->name('home');

	Route::get('/circle', 'FrontendController@circle')
		->name('circle');
	Route::get('/circle/{slug}', 'FrontendController@circleShow')
		->name('circle.show');
	Route::post('/circle/calldata', 'FrontendController@circleData')
		->name('circle.data');

	Route::get('/news-event', 'FrontendController@newsevent')
		->name('newsevent');
	Route::get('/news-event/{slug}', 'FrontendController@newseventShow')
		->name('newsevent.show');
	Route::post('/news-event/calldata', 'FrontendController@newseventData')
		->name('newsevent.data');

	Route::get('/sdg-and-politics', 'FrontendController@politic')
		->name('politic');
	Route::get('/sdg-and-politics/{slug}', 'FrontendController@politicShow')
		->name('politic.show');
	Route::post('/sdg-and-politics/calldata', 'FrontendController@politicData')
		->name('politic.data');
	
	Route::get('/about', 'FrontendController@about')
		->name('about');
	Route::get('/contact', 'FrontendController@contact')
		->name('contact');

	Route::post('/comments', 'FrontendController@comments')
		->name('comments');	
});


Route::get('/api', 'FrontendController@api')
	->name('cms.api');

Route::get('/test', function(){
	$data = App\Model\UsersLogs::with(['getUsers'])
		->whereHas('getUsers', function($query){
			$query->where('name', 'like', 'nani%');
		})->get();
	
	return response()->json($data);
});

Route::get('/page', function(){
	$data = New App\Model\ContentPage;
	$data->title = "page6";
	// $data->email = "dessurya02@gmail.com";
	// $data->password = Hash::make('asdasd');
	$data->flag_active = "Y";
	$data->save();
	dd($data);
});

Route::prefix('cms')->name('cms.')->group(function(){
	Route::get('/', 'Auth\LoginController@loginForm');
	Route::get('/login', 'Auth\LoginController@loginForm')
		->name('login');
	Route::post('login', 'Auth\LoginController@loginAction')
		->name('login.exe');

	Route::middleware('auth')->group(function(){
		Route::post('signout', 'Auth\LoginController@logout')
			->name('logout');

		Route::prefix('dashboard')->group(function(){
			Route::get('/', 'CmsDashboardController@index')
				->name('dashboard');
			Route::any('/data', 'CmsDashboardController@getData')
				->name('dashboard.data');
		});

		Route::prefix('profile')->group(function(){
			Route::get('/', 'CmsProfileController@index')
				->name('profile');
			Route::post('/store', 'CmsProfileController@store')
				->name('profile.store');
		});

		Route::prefix('accounts')->name('account.')->group(function(){
			Route::get('list', 'CmsAccountsController@index')
				->name('list');
			Route::post('calldata', 'CmsAccountsController@callData')
				->name('data');
			Route::post('tools', 'CmsAccountsController@tools')
				->name('tools');
		});

		Route::prefix('history')->name('history.')->group(function(){
			Route::get('list', 'CmsUsersLogsController@index')
				->name('list');
			Route::post('calldata', 'CmsUsersLogsController@callData')
				->name('data');
		});

		Route::prefix('content')->name('content.')->group(function(){
			Route::get('{index}', 'CmsContentsController@index')
				->name('index');
			Route::post('{index}/callData', 'CmsContentsController@callData')
				->name('data');
			Route::post('{index}/tools', 'CmsContentsController@tools')
				->name('tools');
		});

	});
});
