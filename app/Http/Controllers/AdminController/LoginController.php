<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Firm;
use App\Models\State;
use DB;

class LoginController extends Controller
{
    public function dashboard(Request $request){
    	// $getFirmDataStateWise = Firm::select('firms.state as state_id','states.state as state')
    	// ->leftJoin('states','states.id','=','firms.state')
    	// ->where('firms.status' ,'!=' , 0)->orderBy('state_id')->get();

    	$statusCounts = Firm::selectRaw('status, COUNT(*) as count')
                        ->whereIn('status', ['10', '20', '30', '40', '50'])
                        ->groupBy('status')
                        ->get();
        $firmData = Firm::select('address','city','state')->whereIn('status', ['10', '20', '30', '40', '50'])->get();

        $totalCount = count($firmData);

    	$getFirmDataStateWise = Firm::select('firms.state as state_id', 'states.state as state', DB::raw('COUNT(firms.state) as state_count'))
		    ->leftJoin('states', 'states.id', '=', 'firms.state')
		    ->where('firms.status', '!=', 0)
		    ->groupBy('firms.state', 'states.state')
		    ->orderBy('state_id')
		    ->get();

		    $counts = [
                'pending' => $statusCounts->where('status', 10)->first()->count ?? 0,
                'approved' => $statusCounts->where('status', 20)->first()->count ?? 0,
                'query' => $statusCounts->where('status', 30)->first()->count ?? 0,
                'rejected' => $statusCounts->where('status', 40)->first()->count ?? 0,
                'expired' => $statusCounts->where('status', 50)->first()->count ?? 0,
                'total' => $totalCount,
                'states' => $getFirmDataStateWise
            ];

    	// return $getFirmDataStateWise; 

    	// $stateCount = 
        return view('admin.dashboard')->with('data',$counts);
    }

    public function fetchStateWiseData(Request $request)
    {
    	$getFirmDataStateWise = Firm::where('status' ,'!=' , 0)->get();
    	return $getFirmDataStateWise; 
    }
}
