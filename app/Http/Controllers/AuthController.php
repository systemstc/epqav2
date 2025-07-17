<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpEmail;
use App\Models\User;
use App\Models\Otp;
use App\Events\UserRegistered;
use App\Events\UserLoginOtp;
use Carbon\Carbon;
use App\Http\Helpers\Helper;
use DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {



    	// return 'login';
    	// return Auth::user();
    	if (Auth::user()) {
    		// return "auth";
    		$route = $this->redirectDashBoard();
            // $data = $this->dashboardData();
            // return $data;
    		return redirect($route);
    		// return redirect()->route($route);
    	}else{
    		// return 'Auth';
	    	if ($request->isMethod('post')) {
	    		// return 'post';
			    $validated = Validator::make($request->all(),[
	        		'email' => 'required|email',
	        		'password' => 'required|min:8',
	    		]);

	    		if ($validated->fails()) {
	    			// return "fail";
	    			// $route = $this->redirectLogin();
	    			return back()->withInput()->withErrors($validated);
	    			// return redirect()->route($route)->withInput()->withErrors($validated);
	    		}else{
	    			try{
	    				$data = '';
	    				$logintype = '';
	    				$data = $this->getLoginScreen();
	    				$logintype = $data['logintype'];
				    	$verifiedData = Helper::isCustomerVerified($request->email);
                        // return empty($verifiedData);
				    	// return $verifiedData['email_verified_received_at'];
                        if (!empty($verifiedData)) {
    				    	if ($verifiedData->email_verified_at == '' && $verifiedData->user_type == 'customer') {
    				    		// return 'not verified';
    				    		$user = Helper::getUserDetailbyEmail($request->email);
    				    		event(new UserRegistered($user));
    				    		return view('auth.customer.verify')->with('error', 'Email not Verified')->with('email',$request->email);
    				    		// return back()->withInput()->with('error', 'Emain not Verified');
    				    	}else{
    				    		// return "verified";
    							if (Auth::attempt(['email' => $request->email, 'password' => trim($request->password), 'user_type' => $request->user_type])) {
    				    			// return "if attempt";
    									// Session::flash('alert-success', 'login Successfully done');
    									// Session::forget('account_id');
    									// Session::forget('email');
        									// Session::put('user_type');
    					    				$route = $this->redirectDashBoard();
    						    			// return $route;
    							    		return redirect($route);

    							}else{
    								return back()->withInput()->with('error', 'Invalid Email or Password');
    							}
    				    	}
                        }else{
                            return back()->withInput()->with('error', 'User not Registered');
                        }
	    				// return $logintype;
	    			} catch (Throwable $e) {
	    				$response = array(
	    					'status' => 'error',
	    					'status' => $e->message,
	    				);
	    				return $response;
	    			}
	    		}
	    	}else{
				$route = $this->getLoginScreen();
                // $data = $this->dashboardData();
				// return $data;
	    		// $route = $this->redirectLogin();
	    		// return view($route);
                // return $route;
	    		return view($route['redirect']);
	    		// return view('auth.customer.register');
	    		// return back();
	    	}	
    	}
    }

    public function register(Request $request)
    {
    		// return 'no Auth';
    	// return $request;
    	if (Auth::user()) {
    		$route = $this->redirectDashBoard();
    		return redirect($route);
    	}else{
	    	if ($request->isMethod('post')) {
			    $validated = Validator::make($request->all(),[
	        		'email' => 'required|email|unique:users|',
	        		'mobile' => 'required',
	        		'password' => 'required|confirmed|min:8',
	        		'password_confirmation' => 'required',
	    		]);

	    		if ($validated->fails()) {
	    			// return 'fail';
	    			// $route = $this->redirectLogin();
	    			return back()->withInput()->withErrors($validated);
	    			// return redirect()->route($route)->withInput()->withErrors($validated);
	    		}else{
	    			// return 'pass';
	    			try{
	    				$user_data = User::create([
	    					'name' => 'name',
	    					'email' => $request->email,
	    					'password' => Hash::make($request->password),
	    					'user_type' => 'customer',
	    				]);
	    				$response = array(
	    					'status' =>'success',
	    					'message' =>'data inserted',
	    				);
	    				$user = $user_data;
    					event(new UserRegistered($user));
	    				if ($user_data != '') {
	    					// test@123

							// $route = $this->redirectDashBoard();
			    			// return $request->email;
				    		// return redirect()->route('customerverify')->with('email',$request->email);
				    		// return redirect()->route('customerverify');
				    		return view('auth.customer.verify')->with('email',$request->email);
	    				}
	    				// return $response;


	    			} catch (Throwable $e) {
	    				$response = array(
	    					'status' => 'error',
	    					'message' => $e->message,
	    				);
	    				return $response;
	    			}
	    		}
	    	}else{
		    	return view('auth.customer.register');
	    	}
	    }
    	# code...
    }

    public function redirectDashBoard()
    {
    	$redirect = "";
    	if (Auth::user()) {
	    	if (Auth::user() && Auth::user()->user_type == "customer") {
	    		$redirect = "/customer/dashboard";
	    	}else if(Auth::user() && Auth::user()->user_type == "sub-admin"){
	    		$redirect = "/sub-admin/dashboard";
	    	}else if(Auth::user() && Auth::user()->user_type == "admin"){
	    		$redirect = "/admin/dashboard";
	    	}
    	}

    	return $redirect;
   	}

   	public function redirectLogin()
    {
    	$redirect = "";

    	if (Auth::user() && Auth::user()->user_type == "customer") {
    		$redirect = "/customer/login";
    	}else if(Auth::user() && Auth::user()->user_type == "sub-admin"){
    		$redirect = "/sub-admin/login";
    	}else if(Auth::user() && Auth::user()->user_type == "admin"){
    		$redirect = "/admin/login";
    	}

    	// if (str_contains(url()->current(), '/customer')) {
    	// 	$redirect = "auth.customer.login";
    	// }else if(str_contains(url()->current(), '/admin')){
    	// 	$redirect = "auth.admin.login";
    	// }else if(str_contains(url()->current(), '/sub-admin')){
    	// 	$redirect = "auth.sub-admin.login";
    	// }else{
    	// 	$redirect = "auth.customer.login";
    	// }

    	return $redirect;
   	}

   	public function getLoginScreen()
   	{
   		$redirect = "";
   		$logintype = "";

   		if (str_contains(url()->current(), '/customer')) {
    		$redirect = "auth.customer.login";
    		$logintype = 'customer';
    	}else if(str_contains(url()->current(), '/admin')){
    		$redirect = "auth.admin.login";
    		$logintype = 'admin';
    	}else if(str_contains(url()->current(), '/sub-admin')){
    		$redirect = "auth.subadmin.login";
    		$logintype = 'sub-admin';
    	}
    	else{
    		$logintype = "";
    		return url()->current();
    		// $redirect = "auth.customer.login";
    	}

    	return array('redirect' => $redirect, 'logintype' => $logintype);
   	}

   	public function logout(request $request)
   	{
   		$route = $this->redirectLogin();
   		// Auth::logout();
   		auth()->logout();
	    Session()->flush();
   		return redirect($route);

   	}

   	public function verify(Request $request)
   	{
    	if ($request->isMethod('post')) {
    		// return 'post';
		    $validated = Validator::make($request->all(),[
        		'otp' => 'required',
        		// 'email' => 'required',
    		]);

    		if ($validated->fails()) {
    			// return "fail";
    			// $route = $this->redirectLogin();
    			return back()->withInput()->withErrors($validated);
    			// return redirect()->route($route)->withInput()->withErrors($validated);
    		}else{
    			try{
    				// return $request->email;
    				$getOtpTime = Otp::select('id','generated_at','otp')->where('email',$request->email)->where('status','1')->orderBy('id', 'desc')->first();
    				$currentTime = time();
    				$arrayName = array('currentTime' => $currentTime,'generated_at' => $getOtpTime->generated_at);
    				// return $arrayName;
    				if ($currentTime >= $getOtpTime->generated_at && $getOtpTime->generated_at >= $currentTime - (90+5)) {
    					if ($getOtpTime->otp == $request->otp) {
	    					$otpVerified = Otp::where('id',$getOtpTime->id)->update([
	    						'status' => '0',
	    					]);
                                if (Session::get('otp') == 'login') {
                                    $user = Helper::getUserDetailbyEmail($request->email);
                                    Auth::login($user);
                                    $route = $this->redirectDashBoard();
                                            // return $route;
                                    return redirect($route)->with('success','Login in Successfully');

                                    // return view('customer.login')->with('success','Login in Successfully');
                                }else{
        	    					if ($otpVerified) {
        		    					User::where('email',$request->email)->update([
        		    						'email_verified_at' => Carbon::now()->toDateTimeString(),
    		    					]);
    		    					return view('auth.customer.login')->with('success','Email has been verified');
                                }
	    					}
    					}else{
    						return back()->with('error','Otp Not Verified');
    					}
    				}else{
    					return back()->with('error','Otp Time Out');
    				}
    				// return $request;
    				// return Auth::user();

    			} catch (Throwable $e) {
    				$response = array(
    					'status' => 'error',
    					'message' => $e->message,
    				);
    				return $response;
	    		}
    		}
    	}else{
            // Send OTP email
            Session::put('otp','verify');
            Mail::to($request->email)->send(new OtpEmail($otp));
    		return view('auth.customer.verify');
    	}
   	}

   	public function resendOtp(Request $request)
   	{
   		 $validated = Validator::make($request->all(),[
        		// 'otp' => 'required',
        		'email' => 'required',
    		]);

    		if ($validated->fails()) {
    			// return "fail";
    			// $route = $this->redirectLogin();
    			return back()->withInput()->withErrors($validated);
    			// return redirect()->route($route)->withInput()->withErrors($validated);
    		}else{
    			try{
    				$getOtpTime = Otp::select('id','generated_at','otp')->where('email',$request->email)->where('status','1')->orderBy('id', 'desc')->first();
    				// return $getOtpTime;
    				$currentTime = time();
    				if ($currentTime >= $getOtpTime->generated_at && $getOtpTime->generated_at >= $currentTime - (90+5)) {
						$response = array(
	    					'status' => 'error',
	    					'message' => 'Please wait for some time',
	    				);

    				}else{
	    				$user = User::where('email',$request->email)->first();
	    				event(new UserRegistered($user));

	    				$response = array(
	    					'status' => 'success',
	    					'message' => 'OTP send Successfully',
	    				);			
    				}

    			}catch (Exception $e) {
    				$response = array(
    					'status' => 'error',
    					'message' => $e->message,
    				);
    				return $response;
	    		}
    		}
    		return $response;


   	}

    public function sendOtpForLogin(Request $request)
{
    // return $request;
    // $user = User::where('email', $request->email)->first();
    $user = Helper::getUserDetailbyEmail($request->email);
    // return $user;

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Dispatch login OTP event
    event(new UserLoginOtp($user));

    Session::put('otp','login');

    return view('auth.customer.verify');

    // return response()->json(['message' => 'OTP sent to your email']);
}
}
