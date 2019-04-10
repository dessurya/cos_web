<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Model\Users;
use Validator;
use Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/cms';

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function guard(){
        return Auth::guard();
    }

    public function loginForm(request $request){
        return view('cms.login.index', compact('request'));
    }

    public function logout(){
        auth()->guard()->logout();
        return response()->json([
            'response'=>true,
            'type'=>'signout',
            'msg'=>'Log Out Success',
            'url'=>route('cms.login')
        ]);
    }

    public function loginAction(request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $message = [
          'email.required' => 'This field is required.',
          'email.email' => 'Email format not valid',
          'password.required' => 'This field is required.',
        ];

        $validator = Validator::make($request->all(), [
          'email' => 'required|email',
          'password' => 'required',
        ], $message);

        if($validator->fails())
        {
            return response()->json([
                'response'=>false,
                'msg'=>'wrong input',
                'resault'=>$validator->getMessageBag()->toArray(),
                'url'=>route('cms.login')
            ]);
        }

        if (Auth::guard()->attempt(['email' => $email, 'password' => $password, 'flag_active'=>'Y' ]))
        {
            $set = Users::find(Auth::guard()->user()->id);
            $getCounter = $set->login_count;
            $set->login_count = $getCounter+1;
            $set->last_login = Carbon::now();
            $set->update();

            return response()->json([
                'response'=>true,
                'msg'=>'Signin Success',
                'url'=>route('cms.dashboard')
            ]);
        }
        else
        {
            return response()->json([
                'response'=>false,
                'msg'=>'Your account is not active or wrong password',
                'url'=>route('cms.login')
            ]);
        }
    }
}
