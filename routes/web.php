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

Route::get('/', function () {
    return view('welcome');
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

Route::get('/adduser', function(){
	$data = New App\Model\Users;
	$data->name = "Adam Surya";
	$data->email = "dessurya02@gmail.com";
	$data->password = Hash::make('asdasd');
	$data->flag_active = "Y";
	$data->remember_token = str_random(30).time();
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

	});
});
