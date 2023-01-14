<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserVerification;
use Illuminate\Support\Facades\Notification;
use DB;

class LoginController extends Controller
{
    protected $login;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login() {
    	
        return view('login');
    }

	public function register() {
    	
        return view('registration');
    }


    public function authenticate(Request $request) {
        try {
			$validator = Validator::make($request->all(), ['email' => 'required|exists:users', 'password' => 'required']);
	        if($validator->fails()){
	            return 'no_user';
	        }
	        else{
				$is_verified = User::where('email',$request['email'])->where('is_verified','1')->count();
				if($is_verified > 0){
					$credentials = array('email' => $request['email'], 'password' => $request['password']);
					if(Auth::attempt($credentials)){
						return 'success';
					}else{
						return 'no_user';
					}
				}else{
					return 'not_verified';
				}
	            
	        }
		} catch (\Exception $e) {
			return $e;
		}
    }
	
	public function registration(Request $request){
		$check_email = User::where('email',$request['email'])->count();
		if($check_email > 0){
			return 'email already in use';
		}

		DB::beginTransaction();

		$user = new User;
		$user->name = $request['name'];
        $user->email = $request['email'];
        $user->birthdate = $request['birthdate'];
        $user->contact = $request['contact'];
        $user->address = $request['address'];
        $user->is_verified = '0';
		$user->user_type = 'patient';
        $user->password = Hash::make($request['password']);
		$user->save();

		if($user){
			$http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'? "https://" : "http://";

			$url = $http . $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
			$info = [
				'name' => $user->name,
				'email_message' => 'Please click this link to activate your account'.$url.'/Verifieduser/'.$user->id,
				'is_sent' => true,
				
			];
			$user->notify(new UserVerification($info));
		
			DB::commit();
			return 'success';
		}else{
			return 'Something went wrong';
		}
		
					
	}

	public function verifyUser($id){
		$check_email = User::where('id',$id)->update(['is_verified' => '1']);
		return view('verify');
	}

	public function resetUserPassword(Request $request){
		$check_email = User::where('email',$request['email'])->first();
		if(!empty($check_email)){
			$length = 8;
			$generated = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
			$default_pass = Hash::make($generated);

			$info = [
				'name' => $check_email->name,
				'email_message' => 'Your new password is '.$generated.' . Please make sure to change your password.! ',
				'is_sent' => true,
				
			];

			$user = User::where('id',$check_email->id)->update(['password' => $default_pass]);
			$check_email->notify(new UserVerification($info));

			return 'success';
		}else{
			return 'email not exists!';
		}
	}

	public function forgotPasswordPage(){
		return view('forgotpassword');
	}

    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
