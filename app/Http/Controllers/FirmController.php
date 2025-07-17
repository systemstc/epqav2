<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Firm;
use App\Models\Tempfirm;
use App\Models\Branch;
use App\Models\Tempbranch;
use App\Models\Director;
use App\Models\Tempdirector;
use App\Models\State;
use App\Models\District;
use App\Models\Rotc;
use Session;

class FirmController extends Controller
{
    public function create()
    {
    	$state = State::orderBy('state','asc')->get();
    	$rotc = Rotc::orderBy('rotc','asc')->get();
        return view('customer.customer_registration')->with('state',$state)->with('rotc',$rotc);
    }    

    public function preview(Request $request)
    {
    	    	try{
	    	// return sizeof($request->branches);
	    	// return $request;
	    	// print_r($request->hasFile('iec_certificate'));
	    	// exit();
	        $firmValidated = $request->validate([
	            'subadmin_selected' => 'required',
	            'ie_code' => 'required|string|max:255',
	            'gstin_number' => 'required',
	            'pan_number' => 'required|string',
	            'dob' => 'required|date',
	            'nature_of_firm' => 'required',
	            'category_of_export' => 'required',
	            'firm_name' => 'required|string|max:255',
	            'address' => 'required|string|max:255',
	            'address_2' => 'nullable|string|max:255',
	            'city' => 'required|string|max:255',
	            'district' => 'required|string|max:255',
	            'state' => 'required|string|max:255',
	            'pincode' => 'required',
	            'telephone' => 'required|string|max:20',
	            'email' => 'required|string|max:255',
	            'sez' => 'nullable|in:on,off',
	            // 'office_type' => 'required|string',
	            // 'postal_address' => 'required|string|max:255',
	            // 'fax' => 'nullable|string|max:20',
	            // 'website' => 'nullable|string|max:255',
	            // 'manufacturing_address' => 'nullable|string|max:255',
	            // 'manufacturing_telephone' => 'nullable|string|max:20',
	            // 'manufacturing_fax' => 'nullable|string|max:20',
	            // 'is_merchant_exporter' => 'required|boolean',
	            // 'year_of_establishment' => 'required|integer|min:1900|max:' . date('Y'),
	            // 'commodities' => 'required|string',
	            // 'payment_details' => 'required|string',
	        ]);

	        $getExistingFirm = Tempfirm::where('user_id',Auth::user()->id)->where('status','40')->first();
	        if (isset($getExistingFirm)) {
	        	$updateFirm = Tempfirm::where('user_id',Auth::user()->id)->where('status','40')->update([
	        		'status' => '0',
	        	]);
	        }

            if ($request->hasFile('iec_certificate') !== null) {
	            // The invoice_file is indeed uploaded
	            $image_full_name = uniqid('upload__', true) . '.' . strtolower($request->file('iec_certificate')->getClientOriginalExtension());

	            $iec_path = $request->file('iec_certificate')->move(storage_path('app/public/certificate/'), $image_full_name);
	            // return $invoice_path;
	        } 

	        $firmData = $firmValidated;
	        $firmData['user_id'] = Auth::user()->id;
	        $firmData['iec_path'] = $image_full_name;
	        $firm = Tempfirm::create($firmData);
	        $firm_id = $firm->id;

	        Session::put('application_status',$firm->status);


	        $directorValidation = $request->validate([
	            // 'director_name' => 'required|string',
	            // 'designation' => 'required|string',
	            // 'director_pan' => 'required|string',

		        'director' => 'required|array',
		        'director.*.name' => 'required|string|max:255',
		        'director.*.designation' => 'required|string|max:20',
		        'director.*.pan' => 'required|string|max:255',
		        'director.*.email' => 'required|string|max:255',
		        'director.*.mobile' => 'required|string|max:255',
		        'director.*.address' => 'required|string|max:255',
	        ]);

	        $directorData = array_map(function($director) use ($firm_id) {
		        return array_merge($director, ['firm_id' => $firm_id]);
		    }, $directorValidation['director']);
	        Tempdirector::insert($directorData);



	        // $directorData = $directorValidation;
	        // $directorData['firm_id'] = $firm_id;
	        // $directorData['user_id'] = Auth::user()->id;
	        // return $directorData;


	       // $directorData = array_merge($directorValidation, ['firm_id' => $firm_id]);




	        if (isset($request->branches) && sizeof($request->branches) > 0 ) {

	        	// Get all input data
				$data = $request->all();

		        foreach ($data['branches'] as &$branch) {
			    if (!isset($branch['if_manufacturing_unit'])) {
				        $branch['if_manufacturing_unit'] = 'off';
				    }
				}
				// Merge the modified data back into the request object
				$request->merge(['branches' => $data['branches']]);
	    	    $branchValidated = $request->validate([
			        'branches' => 'required|array',
			        // 'branches.*.name' => 'required|string|max:255',
			        'branches.*.gstin' => 'required|string|max:20',
			        'branches.*.address' => 'required|string|max:255',
			        // 'branches.*.if_manufacturing_unit' => 'required',
			        'branches.*.if_manufacturing_unit' => 'nullable|in:on,off',
			    ]);

			    // return $branchValidated;

		        $data = array_map(function($branch) use ($firm_id) {
			        return array_merge($branch, ['firm_id' => $firm_id]);
			    }, $branchValidated['branches']);

	        	Tempbranch::insert($data);
	        }
        	$state = State::orderBy('state','asc')->get();
	    	$rotc = Rotc::orderBy('rotc','asc')->get();
	    	$district = District::orderBy('district','asc')->get();

	    	$array = array(
	    		'firm' => $firm, 
	    		'directorData' => $directorData, 
	    		'data' => $data, 
	    		'rotc' => $rotc, 
	    		'state' => $state, 
	    	);

	    	// return $array;


	       return view('preview_page',compact('firm','directorData','data','rotc','state','district'));


	        // return view('view_application')->with('application',$application)->with('application_status',$application_status)->with('branches',$branches)->with('directors',$directors)->with('state',State::get())->with('rotc',Rotc::get())->with('district',District::get());
	        // return redirect('customer/dashboard')->with('success', 'Firm registered successfully!');

    	}catch (Exception $e){
			$response = array(
				'status' => 'error',
				'message' => $e->message,
			);

			return $response;
    	}

        // return view('preview_page');
        // ->with('application',$application)->with('branches',$branches)->with('directors',$directors)->with('state',State::get())->with('rotc',Rotc::get())->with('district',$district);
    }

    public function previewStore(Request $request)
    {
    	$getFirm = Tempfirm::with(['tempbranches','tempdirectors'])->find($request->firm_id);
    	// return $

    	$createFirm = Firm::create($getFirm->toArray());
    	$tempBranches = $getFirm['tempbranches']->toArray();
    	$tempDirector = $getFirm['tempdirectors']->toArray();

		$tempBranches = array_map(function ($branch) use ($createFirm) {
		    unset($branch['id']);
		    $branch['firm_id'] = $createFirm['id'];
		    return $branch;
		}, $tempBranches);

		$createBranch = Branch::insert($tempBranches);

		$tempDirector = array_map(function ($director) use ($createFirm) {
		    unset($director['id']);
		     $director['firm_id'] = $createFirm['id'];
		    return $director;
		}, $tempDirector);

		$createDirector = Director::insert($tempDirector);

		if ($createFirm && $createBranch && $createDirector) {
			$deleteTemp = Tempfirm::with(['tempbranches','tempdirectors'])->where('id',$request->firm_id)->delete();
		}
		
    	// $createBranch = Branch::insert($getFirm['tempbranches']->toArray());
    	// $createDirector = Director::insert($getFirm['tempdirectors']->toArray());
    	// return $getFirm;
    	// $arrayName = array(
    	// 	'createFirm' => $createFirm, 
    	// 	'createBranch' => $createBranch, 
    	// 	'createDirector' => $createDirector, 
    	// );

    	return redirect('customer/dashboard')->with('success', 'Firm registered successfully!');

    	// return $arrayName;
    }

    public function store(Request $request)
    {
    	// return $request;
    	try{
	    	// return sizeof($request->branches);
	    	// return $request;
	    	// print_r($request->hasFile('iec_certificate'));
	    	// exit();
	        $firmValidated = $request->validate([
	            'subadmin_selected' => 'required',
	            'ie_code' => 'required|string|max:255',
	            'gstin_number' => 'required',
	            'pan_number' => 'required|string|boolean',
	            'dob' => 'required|date',
	            'nature_of_firm' => 'required',
	            'category_of_export' => 'required|boolean',
	            'firm_name' => 'required|string|max:255',
	            'address' => 'required|string|max:255',
	            'address_2' => 'nullable|string|max:255',
	            'city' => 'required|string|max:255',
	            'district' => 'required|string|max:255',
	            'state' => 'required|string|max:255',
	            'pincode' => 'required',
	            'telephone' => 'required|string|max:20',
	            'email' => 'required|string|max:255',
	            'sez' => 'nullable|in:on,off',
	            // 'office_type' => 'required|string',
	            // 'postal_address' => 'required|string|max:255',
	            // 'fax' => 'nullable|string|max:20',
	            // 'website' => 'nullable|string|max:255',
	            // 'manufacturing_address' => 'nullable|string|max:255',
	            // 'manufacturing_telephone' => 'nullable|string|max:20',
	            // 'manufacturing_fax' => 'nullable|string|max:20',
	            // 'is_merchant_exporter' => 'required|boolean',
	            // 'year_of_establishment' => 'required|integer|min:1900|max:' . date('Y'),
	            // 'commodities' => 'required|string',
	            // 'payment_details' => 'required|string',
	        ]);

	        $getExistingFirm = Firm::where('user_id',Auth::user()->id)->where('status','40')->first();
	        if (isset($getExistingFirm)) {
	        	$updateFirm = Firm::where('user_id',Auth::user()->id)->where('status','40')->update([
	        		'status' => '0',
	        	]);
	        }

            if ($request->hasFile('iec_certificate') !== null) {
	            // The invoice_file is indeed uploaded
	            $image_full_name = uniqid('upload__', true) . '.' . strtolower($request->file('iec_certificate')->getClientOriginalExtension());

	            $iec_path = $request->file('iec_certificate')->move(storage_path('app/public/certificate/'), $image_full_name);
	            // return $invoice_path;
	        } 

	        $firmData = $firmValidated;
	        $firmData['user_id'] = Auth::user()->id;
	        $firmData['iec_path'] = $image_full_name;
	        $firm = Firm::create($firmData);
	        $firm_id = $firm->id;

	        Session::put('application_status',$firm->status);


	        $directorValidation = $request->validate([
	            // 'director_name' => 'required|string',
	            // 'designation' => 'required|string',
	            // 'director_pan' => 'required|string',

		        'director' => 'required|array',
		        'director.*.name' => 'required|string|max:255',
		        'director.*.designation' => 'required|string|max:20',
		        'director.*.pan' => 'required|string|max:255',
		        'director.*.email' => 'required|string|max:255',
		        'director.*.mobile' => 'required|string|max:255',
		        'director.*.address' => 'required|string|max:255',
	        ]);

	        $directorData = array_map(function($director) use ($firm_id) {
		        return array_merge($director, ['firm_id' => $firm_id]);
		    }, $directorValidation['director']);
	        Director::insert($directorData);



	        // $directorData = $directorValidation;
	        // $directorData['firm_id'] = $firm_id;
	        // $directorData['user_id'] = Auth::user()->id;
	        // return $directorData;


	       // $directorData = array_merge($directorValidation, ['firm_id' => $firm_id]);




	        if (isset($request->branches) && sizeof($request->branches) > 0 ) {

	        	// Get all input data
				$data = $request->all();

		        foreach ($data['branches'] as &$branch) {
			    if (!isset($branch['if_manufacturing_unit'])) {
				        $branch['if_manufacturing_unit'] = 'off';
				    }
				}
				// Merge the modified data back into the request object
				$request->merge(['branches' => $data['branches']]);
	    	    $branchValidated = $request->validate([
			        'branches' => 'required|array',
			        // 'branches.*.name' => 'required|string|max:255',
			        'branches.*.gstin' => 'required|string|max:20',
			        'branches.*.address' => 'required|string|max:255',
			        // 'branches.*.if_manufacturing_unit' => 'required',
			        'branches.*.if_manufacturing_unit' => 'nullable|in:on,off',
			    ]);

			    // return $branchValidated;

		        $data = array_map(function($branch) use ($firm_id) {
			        return array_merge($branch, ['firm_id' => $firm_id]);
			    }, $branchValidated['branches']);

	        	Branch::insert($data);
	        }


	        return redirect('customer/dashboard')->with('success', 'Firm registered successfully!');

    	}catch (Exception $e){
			$response = array(
				'status' => 'error',
				'message' => $e->message,
			);

			return $response;
    	}
    }    
}
