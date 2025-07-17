<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Otp;
use App\Models\Rotc;
use Carbon\Carbon;
use App\Http\Helpers\Helper;

class RegionalOfficeController extends Controller
{
    public function getAllRegionalOffice(Request $request)
    {
        return view('admin.regional_office');
    }

    public function getAllRegionalOfficeLazy(Request $request)
    {
        // return json_encode($request->ajax());
        if ($request->ajax()) {
        try{
            // $regionalOffice = RegionalOffice::where('status','1')->get();
            // return $regionalOffice;

            $status = $request->input('status');
            $columns = ['id', 'name', 'officer_incharge' , 'email', 'address' , 'state'];

            if($status == 'active'){
                $status = '1';
            }else{
                $status = '0';
            }
// return $status;
            $totalData = Rotc::where('status', $status)->count();
            $totalFiltered = $totalData;
            // return $totalFiltered;

            $limit = $request->input('length');
            $start = $request->input('start');
             // Handle ordering
            $orderColumnIndex = $request->input('order.0.column', 0); // Default order column index to 0 if not provided
            $order = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'id'; // Default to 'id' column if index is invalid
            // $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir','asc');

            if(empty($request->input('search.value')))
            {
                $users = Rotc::where('status', $status)
                             ->offset($start)
                             ->limit($limit)
                             ->orderBy($order, $dir)
                             ->get();
            }
            else {
                $search = $request->input('search.value');

                $users = Rotc::where('status', $status)
                            ->where(function($query) use ($search) {
                                $query->where('id', 'LIKE', "%{$search}%")
                                      ->orWhere('name', 'LIKE', "%{$search}%")
                                      ->orWhere('email', 'LIKE', "%{$search}%")
                                      ->orWhere('status', 'LIKE', "%{$search}%");
                            })
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->get();

                $totalFiltered = Rotc::where('status', $status)
                                    ->where(function($query) use ($search) {
                                        $query->where('id', 'LIKE', "%{$search}%")
                                              ->orWhere('name', 'LIKE', "%{$search}%")
                                              ->orWhere('email', 'LIKE', "%{$search}%")
                                              ->orWhere('status', 'LIKE', "%{$search}%");
                                    })
                                    ->count();
            }

            $data = [];
            if(!empty($users))
            {
                foreach ($users as $user)
                {
                    $nestedData['id'] = $user->id;
                    $nestedData['name'] = $user->name;
                    $nestedData['officer_incharge'] = $user->officer_incharge;
                    $nestedData['email'] = $user->email;
                    $nestedData['address'] = $user->address;
                    $nestedData['state'] = $user->state;

                    $data[] = $nestedData;
                }
            }

            $json_data = [
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            ];

            return response()->json($json_data);

        } catch (Exceptions $e) {
            $response = array(
                'status' => 'error',
                'message' => $e->message(),
                'line' => $e->line(),
            );
            return $response;
        }
    }else{
        return view('admin.regional_office');
    }

    }

    public function addRegionalOffice(Request $request)
    {
        // return $request;
        if ($request->isMethod('post')) {
            // return $request;
            $latLng = Helper::getLatLng($request->address);
            // print_r($latLng);
             // return $latLng['lat'];
            $validated = Validator::make($request->all(),[
                    // 'name' => 'required',
                    // 'email' => 'required|email|unique:users',
                    // 'userpassword' => 'required|min:8',
                    // 'officer' => 'required',
                    // 'address' => 'required',
                    // 'phone' => 'required',
                    // // 'lat' => 'required',
                    // // 'lat' => 'required',
                    // 'state' => 'required',
                    // 'city' => 'required',
                    // 'zip' => 'required'
            ]);

            if ($validated->fails()) {
                // return 2;
                return $response = array(
                    'status' => 'error',
                    'error' => $validated,
                );
                // return "fail";
                // $route = $this->redirectLogin();
                // return $validated;
                // return back()->withInput()->withErrors($validated);
                // return redirect()->route($route)->withInput()->withErrors($validated);
            }else{
                try{

                    if (User::where([['email',$request->email],['status','1']])->exists()) {
                        // return 0;
                        return $response = array(
                            'status' =>'error',
                            'message' => 'User Already Exist'
                        );
                    }else{
                        // return 1;
                        $regionalOffice = Rotc::create([
                            'user_id' => 0,
                            'rotc' => $request->name,
                            'officer_incharge' => $request->officer,
                            'address' => $request->address,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'lat' => $latLng['lat'],
                            'lng' => $latLng['lon'],
                            'state' => $request->state,
                            'city' => $request->city,
                            'zip' => $request->zip,
                        ]);

                        if ($regionalOffice != '') {
                            $data = User::create([
                                'name' => 'name',
                                'email' => $request->email,
                                'password' => Hash::make($request->userpassword),
                                'user_type' => 'sub-admin',
                            ]);

                            if ($data) {
                                Rotc::where('id',$regionalOffice->id)->update([
                                    'user_id' => $data->id,
                                ]);
                            }
                        }

                        if ($regionalOffice !='' && $data != '') {
                            $response = array(
                                'status' => 'success',
                                'message' => 'Sub Admin Created Successfully',
                            );
                        }
                    }
                    // $data = RegionalOffice::firstOrCreate();
                    return $response;

                } catch (Exceptions $e) {
                    $response = array(
                        'status' => 'error',
                        'message' => $e->message(),
                        'line' => $e->line(),
                    );
                    return $response;
                }
            }
        } else {
            return view('admin.add_regional_office');
        }
    }

    public function sendCredentialsToSubAdmin(Request $request){
        if ($request->isMethod('post')) {
            $validated = Validator::make($request->all(),[
                    // 'name' => 'required',
                    // 'email' => 'required|email|unique:users',
            ]);

            if ($validated->fails()) {
                // return 2;
                return $response = array(
                    'status' => 'error',
                    'error' => $validated,
                );
            }else{
                try{
                    $response = array(
                        'status' => 'success',
                        'message' => 'message',
                    );
                } catch (Exceptions $e) {
                    $response = array(
                        'status' => 'error',
                        'message' => $e->message(),
                        'line' => $e->line(),
                    );
                    return $response;
                }
            }
        } else {

        }
    }
}
