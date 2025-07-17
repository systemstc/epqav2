<?php

namespace App\Http\Controllers\CustomerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Firm;
use App\Models\Branch;
use App\Models\Director;
use App\Http\Helpers\Helper;
use Carbon\Carbon;
use Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
    	// return 'login';

    	if ($request->isMethod('post')) {
		    $validated = Validator::make($request->all(),[
        		'email' => 'required|email',
        		'password' => 'required',
    		]);

    		if ($validated->fails()) {
                return "error";
    			// return redirect()->route('customerlogin')->withInput()->withErrors($validated);
    		}else{
    			try{

    			} catch (Throwable $e) {
    				$response = array(
    					'status' => 'error',
    					'status' => $e->message,
    				);
    				return $response;
    			}
    		}
    	}

    	// return view('auth.admin.login');
    	// return view('auth.subadmin.login');
    	// return view('auth.customer.login');
    }

    public function register(Request $request)
    {
    	return view('auth.customer.register');
    	# code...
    }

    public function dashboard(Request $request){
        $application = Helper::getFirmDetailByUserId(Auth::user()->id);
        // return $application;
        
        $application_status = '';
        $application_expiry = '';
        $is_Expired = false;
        if ($application != '') {
            if ($application->status == '10') {
                $application_status = 'Pending';
            }else if($application->status == '20'){
                $application_status = 'Accepted';
            }else if($application->status == '30'){
                $application_status = 'Query';
            }else if($application->status == '40'){
                $application_status = 'Rejected';
            }else if($application->status == '50'){
                $application_status = 'Expired';
            }else{
                $application_status = '';
            }
        }

        Session::put('application_status',isset($application->status) ? $application->status : '');
        // return $application->status;
        if (isset($application->renewals)) {
            foreach ($application->renewals as $key => $value) {
                $expired_date = Carbon::parse($value->expired_date);
                $application_expiry = $expired_date->format('Y-m-d');

                // Convert expiredDate to a Carbon instance if it's not already
                // $expirationDate = Carbon::parse($expiredDate);
        
                // Get the current date
                $today = Carbon::today();

                // Get the start and end of the coming week
                $startOfWeek = $today->copy()->startOfWeek()->addWeek();
                $endOfWeek = $today->copy()->endOfWeek()->addWeek();

                // Check if the expiration date has already passed
                if ($expired_date->isPast()) {
                    $is_Expired = true;
                    // return 'The expiration date has already passed.';
                }

                // Check if the expiration date is within the coming week
                if ($expired_date->between($startOfWeek, $endOfWeek)) {
                    $is_Expired = true;
                    // return 'The expiration date is within the coming week.';
                }

                // return 'The expiration date is neither within the coming week nor has it expired.';

            }
        }
        // return $application;
        return view('customer.dashboard')->with('application_status',$application_status)->with('application',$application)->with('application_expiry',$application_expiry)->with('is_Expired',$is_Expired);
    }
}
