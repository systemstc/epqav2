<?php

namespace App\Http\Controllers\SubAdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Firm;
use App\Models\Rotc;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\Helper;

class LoginController extends Controller
{
    public function dashboard(Request $request){
        if (Auth::user()) {
                if (Auth::user() && Auth::user()->user_type == "customer") {
                    $data = '';
                }else if(Auth::user() && Auth::user()->user_type == "sub-admin"){
                    // $pending = Firm::select('*')
                    // // ->leftJoin('branches','firms.id','=','branches.firm_id')
                    // // ->leftJoin('directors','firms.id','=','directors.firm_id')
                    // ->whereIn('firms.status',['10','30'])->get();

                    // $data = array(
                    //     'pending' => $pending,
                    //     'count' => count($pending)
                    // );

                    $getRosdetail = Rotc::where('user_id', Auth::user()->id)->first();
                    // return $getRosdetail;
// 
                    Session::put('rotc',$getRosdetail['rotc']);
                    Session::put('rotc_id',$getRosdetail['id']);

                    // return Session::get('rotc_id');

                    $statusCounts = Firm::selectRaw('status, COUNT(*) as count')
                        ->whereIn('status', ['10', '20', '30', '40', '50'])
                        ->where('subadmin_selected', Session::get('rotc_id'))
                        ->groupBy('status')
                        ->get();

                    $firmData = Firm::select('firms.address','firms.city','firms.state','states.state as state_name')
                        ->leftJoin('states','states.id','=','firms.state')
                        ->whereIn('firms.status', ['10', '20', '30', '40', '50'])->where('firms.subadmin_selected', Session::get('rotc_id'))->get();

                    $totalCount = count($firmData);

                    if (count($firmData) > 0) {
                        $formattedData = $firmData->map(function($obj) {
                            // $obj->city
                            $formatted = implode(', ', array_filter([$obj->address, $obj->state_name], function($value) {
                                return $value !== null && $value !== '';
                            }));
                           return (object) ['address' => $formatted];
                        })->toArray();

                        // return $formattedData;
                        // return $firmData;

                        // $totalCount = Firm::whereIn('status', ['10', '20', '30', '40', '50'])->count();

                        // Example usage:
                        foreach ($formattedData as $key => $value) {
                            // return $value->address;
                            // $value->address = 'New Prabha Devi Road, Dadar, MH';
                            // $value->address = '1600 Amphitheatre Parkway,Mountain View,CA';
                            $latLng[] = Helper::getLatLng($value->address);
                        }
                    }
                    // return $latLng;
                    // if ($latLng) {
                    //     echo 'Latitude: ' . $latLng['lat'] . ', Longitude: ' . $latLng['lon'];
                    // } else {
                    //     echo 'Geocoding failed.';
                    // }

                    // return $statusCounts;

                    $counts = [
                        'pending' => $statusCounts->where('status', '10')->first()->count ?? 0,
                        'approved' => $statusCounts->where('status', '20')->first()->count ?? 0,
                        'query' => $statusCounts->where('status', '30')->first()->count ?? 0,
                        'rejected' => $statusCounts->where('status', '40')->first()->count ?? 0,
                        'expired' => $statusCounts->where('status', '50')->first()->count ?? 0,
                        'total' => $totalCount,
                        'ros_lat' => $getRosdetail['lat'],
                        'ros_lng' => $getRosdetail['lng'],
                        'latLng' => isset($latLng) ?? json_encode($latLng),

                    ];

                    // return $counts;

                }else if(Auth::user() && Auth::user()->user_type == "admin"){
                    $redirect = "/admin/dashboard";
                }
            }

            // return $data;
        return view('subadmin.dashboard')->with('data',$counts);
    }
}
