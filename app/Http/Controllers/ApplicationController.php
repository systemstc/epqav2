<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Models\Firm;
use App\Models\Renewal;
use App\Models\Query;
use App\Models\Branch;
use App\Models\Director;
use App\Models\RegistrationNumber;
use App\Http\Helpers\Helper;
use Carbon\Carbon;
use App\Services\CertificateService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RejectionEmail;
use DB;
use App\Models\State;
use App\Models\District;
use App\Models\Rotc;
use App\Models\Notes;
use Illuminate\Support\Facades\Storage;


class ApplicationController extends Controller
{
    protected $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    public function applications(Request $request)
    {
    	return view('subadmin.applications');
    }

    public function getApplications($status, Request $request)
    {
    	// return print_r(Auth::user());
    	// return $status;
        // $candidates = Firm::where('status', $status)
        //     ->when($request->search, function ($query, $search) {
        //         return $query->where('firm_name', 'like', "%{$search}%")
        //                      ->orWhere('email', 'like', "%{$search}%");
        //     })
        //     ->paginate(10);
$candidates = Firm::with(['notes', 'renewals', 'previousApplications']) // Eager load the notes, renewals, and previous applications relationships
    ->when($status == 40, function ($query) {
        return $query->whereIn('status', ['0', '40']);
    }, function ($query) use ($status) {
        return $query->where('status', $status);
    })
    ->when($request->search, function ($query, $search) {
        return $query->where(function($query) use ($search) {
            $query->where('firm_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        });
    })
    ->when(auth()->user()->user_type == 'sub-admin', function ($query) {
        $userId = auth()->user()->id;
        $rotcId = \App\Models\Rotc::where('user_id', $userId)->value('id');
        return $query->where('subadmin_selected', $rotcId);
    })
    // If the user is an admin, no additional filtering is needed, so it simply returns all records.
    ->when(auth()->user()->user_type == 'admin', function ($query) {
        // No additional where clause needed; return all records
        return $query;
    })
    ->paginate(10);


// After fetching the candidates, format the previous applications data
// foreach ($candidates as $candidate) {
//     $candidate->previous_application = $candidate->previousApplications->map(function ($app) {
//         return $app->created_at; // Adjust this to include other attributes if needed
//     })->toArray();
// }



    	// $candidates = Firm::with(['notes', 'renewals']) // Eager load the notes and renewals relationships
		   //  ->when($status == 40, function ($query) {
		   //      return $query->whereIn('status', ['0', '40']);
		   //  }, function ($query) use ($status) {
		   //      return $query->where('status', $status);
		   //  })
		   //  ->when($request->search, function ($query, $search) {
		   //      return $query->where(function($query) use ($search) {
		   //          $query->where('firm_name', 'like', "%{$search}%")
		   //                ->orWhere('email', 'like', "%{$search}%");
		   //      });
		   //  })
		   //  ->paginate(10);


        // $candidates = Firm::with(['notes'])->when($status == 40, function ($query) {
        //         return $query->whereIn('status', ['0', '40']);
        //     }, function ($query) use ($status) {
        //         return $query->where('status', $status);
        //     })
        //     ->when($request->search, function ($query, $search) {
        //         return $query->where(function($query) use ($search) {
        //             $query->where('firm_name', 'like', "%{$search}%")
        //                   ->orWhere('email', 'like', "%{$search}%");
        //         });
        //     })
        //     ->paginate(10);


            // Encrypt the ID for each candidate
		    $candidates->getCollection()->transform(function ($candidate) {
		        $candidate->encrypted_id = Crypt::encrypt($candidate->id);
		        return $candidate;
		    });

        return response()->json($candidates);
    }

    public function export($status)
    {
        return Excel::download(new CandidatesExport($status), 'candidates.xlsx');
    }

	public function viewApplications(Request $request,$id)
    {
    	if ($request->isMethod('post')) {
    	// return $request;
    		try{
	    		$firmValidated = $request->validate([
		            'status' => 'required',
		        ]);

		        // Find the firm instance
				$firm = Firm::findOrFail(decrypt($id));
				// return $firm;

				// Update the firm instance with the validated data
				$update = $firm->update($firmValidated);
				// return $update;
				if ($update) {
					// $renewalValidated = $request->validate([
			            // 'user_id' => 'required',
			            // 'firm_id' => 'required',
			            // 'applied_date' => 'required',
			            // 'issue_date' => 'required',
			            // 'expired_date' => 'required',
			            // 'status' => 'required',
		        	// ]);

		        	if ($request['status'] == '20') {
			        	$currentDate = Carbon::now();
			        	$oneYearFromNow = $currentDate->copy()->addYear();
			        	$course = 'Export Import';
			        	// $certificate = Helper::sendCertificate($id,$firm->firm_name,$course,$currentDate,$oneYearFromNow,$firm->email);
			        	// return $certificate;

	        	        $sequence = RegistrationNumber::first();

				        // If no sequence record exists, create one
				        if (!$sequence) {
				            // $sequence = Sequence::create(['current_number' => 10000]);
    			        	$registartion_no = RegistrationNumber::create(
					        		[
							            'user_id' => Auth::user()->id,
							            'firm_id' => $firm->id,
							            'registration_no' =>'MUM/'. 00001,
							            'issue_date' => $currentDate,
							            'expired_date' => $oneYearFromNow,
							            'status' => '1',
					        		]
					        	);
				        }else{
		        	        // Get the current number and increment it
						        $currentNumber = $sequence->id;
						        $nextNumber = $currentNumber + 1;
				        	// $registration_no = 'MUM/'. mt_rand(10000, 99999);
					        	// make registration number
					        	$registartion_no = RegistrationNumber::create(
					        		[
							            'user_id' => Auth::user()->id,
							            'firm_id' => $firm->id,
							            'registration_no' =>'MUM/' .$nextNumber,
							            'issue_date' => $currentDate,
							            'expired_date' => $oneYearFromNow,
							            'status' => '1',
					        		]
					        	);
				        }



	    	           // 'currentDate' => $currentDate->toDateString(),
			            // 'oneYearFromNow' => $oneYearFromNow->toDateString()
			            // use above for view file
		                $data = array(
				        	'id' => decrypt($id), 
				        	'name' => $firm->firm_name, 
				        	'course' => $course, 
				        	'date' => $currentDate, 
				        	'registartion_no' => $registartion_no->registration_no,
				        	'expiry_date' => $oneYearFromNow, 
				        );

	                    // $data = $request->only(['id', 'name', 'course', 'date']);
				        // $email = $request->input('email');

				        $this->certificateService->generateAndSendCertificate($data, $firm->email);

				        // return '1';


						$renewal = Renewal::create([
				            'user_id' => Auth::user()->id,
				            'firm_id' => $firm->id,
				            'applied_date' => $firm->created_at,
				            'issue_date' => $currentDate,
				            'expired_date' => $oneYearFromNow,
				            'status' => '1',
						]);
		        	}else if ($request['status'] == '40') {
		                $data = array(
				        	'id' => decrypt($id), 
				        	'firm_name' => $firm->firm_name, 
				        	'date' => Carbon::now(), 
				        );
				        // return $data['firm_name'];
						Mail::to($firm->email)->send(new RejectionEmail($data));
		        	}
				}

				if ($request->user_query != '' || $request->user_query != null) {
					// return $request;
					// return 0;
					$query = Query::create([
						'user_id' => Auth::user()->id,
						'firm_id' => $firm->id,
						'query' => $request->user_query,
						'status' => '1',
					]);

				}

				if ($request->note != '') {
					$createNote = Notes::create([
						'firm_id' => $firm->id,
						'note' => $request->note,
						'status' => $request['status'],
					]);
				}

		        if ($update) {
		        	return redirect()->route('subadminapplications')->with('success', 'Updated Successfully');
		        }else{
		        	redirect()->back()->with('error', 'Something Went Wrong');
		        }

    		}catch(Exception $e){
	    		$response = array(
	    			'status' => 'error', 
	    			'message' => $e->getMessage(), 
	    			'line' => $e->getLine(), 
	    			'file' => $e->getFile(), 
	    		);

	    		return $response;
	    	}

    	}else{
	    	try{
	    		// return "test";

	    		// $application = Firm::select('*')
	    		// 	->leftJoin('branches' , 'firms.id', '=' , 'branches.firm_id')
	    		// 	->leftJoin('directors' , 'firms.id', '=' , 'directors.firm_id')
	    		// 	->where('firms.id',$id)->first();

    		    // Retrieve the firm with its branches and directors using eager loading
			    // $application = Firm::with(['branches', 'directors'])->get();
			    // $application = Firm::with(['branches', 'directors'])->findOrFail($id);

			    $application = Helper::getFirmDetailById(decrypt($id));
			    // return $application;

	            $branches = $application->branches()->paginate(5);
		        $directors = $application->directors()->paginate(5);
		        $district = District::where('state_id',$application->state)->get();
		        // return $district;

	    		// return $application;

	    	}catch(Exception $e){
	    		$response = array(
	    			'status' => 'error', 
	    			'message' => $e->getMessage(), 
	    			'line' => $e->getLine(), 
	    			'file' => $e->getFile(), 
	    		);

	    		return $response;
	    	}
	    	return view('view_application')->with('application',$application)->with('branches',$branches)->with('directors',$directors)->with('state',State::get())->with('rotc',Rotc::get())->with('district',$district);
    	}
    }

    public function getApplicationDetailByUserId(Request $request,$id)
    {
    	if ($request->isMethod('post')) {
    		try{
	    		$firmValidated = $request->validate([
		            'status' => 'required',
		        ]);

		        // Find the firm instance
				$firm = Firm::findOrFail(decrypt($id));
				// return $firm;

				// Update the firm instance with the validated data
				$update = $firm->update($firmValidated);

				if ($request->query !='') {
					$query = Query::create([
						'user_id' => Auth::user()->id,
						'firm_id' => $firm->id,
						'query' => $request->user_query,
						'status' => '1',
					]);
				}else{
					// redirect()->back()->with('error', 'Enter Query first');
					return "Add query first";
				}

		        if ($update) {
		        	return redirect()->route('subadminapplications')->with('success', 'Updated Successfully');
		        }else{
		        	redirect()->back()->with('error', 'Something Went Wrong');
		        }

    		}catch (Exception $e){
	    		$response = array(
	    			'status' => 'error', 
	    			'message' => $e->getMessage(), 
	    			'line' => $e->getLine(), 
	    			'file' => $e->getFile(), 
	    		);

	    		return $response;
    		}

    	}else{
	    	try{
		    	// return $id;
	    		$application = Helper::getFirmDetailByUserId(decrypt($id));
	    		// return $application;
	    		if ($application->status == '10') {
	    			$application_status = 'Pending';
	    		}else if($application->status == '20'){
	    			$application_status = 'Accepted';
	    		}else if($application->status == '30'){
	    			$application_status = 'Query';
	    		}else{
	    			$application_status = 'Rejected';
	    		}
	    		// return auth()->user()->user_type;

	        // $branches = $application->branches()->paginate(5);
	        // $directors = $application->directors()->paginate(5);
	        $branches = $application->branches()->where('status', '1')->paginate(5, ['*'], 'branches_page');
	        $directors = $application->directors()->where('status', '1')->paginate(5, ['*'], 'directors_page');

	        if ($application->status == '30' || auth()->user()->user_type == 'customer') {
		    	return view('edit_application')->with('application',$application)->with('application_status',$application_status)->with('branches',$branches)->with('directors',$directors)->with('state',State::get())->with('rotc',Rotc::get())->with('district',District::get());
	        } else {
		    	return view('view_application')->with('application',$application)->with('application_status',$application_status)->with('branches',$branches)->with('directors',$directors)->with('state',State::get())->with('rotc',Rotc::get())->with('district',District::get());

	        }
	        

	    	}catch (Exception $e){
		    		$response = array(
		    			'status' => 'error', 
		    			'message' => $e->getMessage(), 
		    			'line' => $e->getLine(), 
		    			'file' => $e->getFile(), 
		    		);

		    		return $response;
	    	}
    	}
    }

    public function editApplicationDetailByUserId(Request $request,$id)
    {
    	if ($request->isMethod('post')) {
    	// return $request;
    		try{
	    		$firmValidated = $request->validate([
		            'subadmin_selected' => 'required',
		            'ie_code' => 'required|string|max:255',
		            'pan_number' => 'required|string',
		            'dob' => 'required|date',
		            'nature_of_firm' => 'required|string',
		            'category_of_export' => 'required|boolean',
		            'firm_name' => 'required|string|max:255',
		            'address' => 'required|string|max:255',
		            // 'address_2' => 'required|string|max:255',
		            'city' => 'required|string|max:255',
		            'district' => 'required|string|max:255',
		            'state' => 'required|string|max:255',
		            'pincode' => 'required',
		            'telephone' => 'required|string|max:20',
		            'email' => 'nullable|string|max:255',
		            'sez' => 'nullable|in:on,off',
		        ]);

		        // Find the firm instance
				$firm = Firm::findOrFail(decrypt($id));
				// return $request->hasFile('iec_certificate');
				// return $request->file('iec_certificate');
				// return $firm->iec_path;
				// return Storage::exists('public/certificate/' . $firm->iec_path);
				$firm_id = $firm->id;

			 	// $application = Application::findOrFail($id);

			    if ($request->hasFile('iec_certificate') !== null) {
			    	 $iecCertificate = $request->file('iec_certificate');
			    	 // return json_encode($iecCertificate);
			        	// return json_encode($request->hasFile('iec_certificate'));
			        if ($firm->iec_path && Storage::exists('public/certificate/' . $firm->iec_path)) {
			            Storage::delete('public/certificate/' . $firm->iec_path);
			        }
			        // return 1;

			        // $path = $request->file('iec_certificate')->store('public/certificate');
			        // $firm->iec_path = basename($path);

					$image_full_name = uniqid('upload__', true) . '.' . strtolower($request->file('iec_certificate')->getClientOriginalExtension());

					// return $image_full_name;

	            	$iec_path = $request->file('iec_certificate')->move(storage_path('app/public/certificate/'), $image_full_name);
			        // $firm->save();
			        $firmValidated['iec_path'] = $image_full_name;
			    }

				 // Log for debugging
		        Log::info('Firm found:', ['id' => $firm->id, 'firm' => $firm->toArray()]);

		        // Update the firm instance with the validated data
		        $update = $firm->update($firmValidated);

		        // Log for debugging
		        Log::info('Firm update status:', ['update' => $update]);				
		        // return $update;
				// Update existing directors to inactive
		        Director::where('firm_id', $firm_id)->update(['status' => '0']);

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
		        $director = Director::insert($directorData);
		        // return $director;



		      //   if (sizeof($request->branches) > 0 ) {
		      //   	 // Update existing branches to inactive
		      //       Branch::where('firm_id', $firm_id)->update(['status' => '0']);
		    	 //    $branchValidated = $request->validate([
				    //     'branches' => 'required|array',
				    //     'branches.*.name' => 'required|string|max:255',
				    //     'branches.*.gstin' => 'required|string|max:20',
				    //     'branches.*.address' => 'required|string|max:255',
				    //     'branches.*.if_manufacturing_unit' => 'nullable|in:on,off',
				    // ]);

			     //    $data = array_map(function($branch) use ($firm_id) {
				    //     return array_merge($branch, ['firm_id' => $firm_id]);
				    // }, $branchValidated['branches']);

		      //   	$branch = Branch::insert($data);
		      //   }
		        // return $request->user_query;

			if (sizeof($request->branches) > 0) {
			    foreach ($request->branches as $key => $branchData) {
			        // $branch = Branch::where('id', $branchData['id'])
			        				// where('firm_id', $firm_id)
			                        // ->where('name', $branchData['name'])
			                        // ->where('gstin', $branchData['gstin'])
			                        // ->where('address', $branchData['address'])
			                        // ->first();
			        // return $branch;
			        if (isset($branchData['id'])) {
				        $branch = Branch::find($branchData['id']);


				        if ($branch) {
				        	// return $branchData['if_manufacturing_unit'];
				            // Branch exists, update its status
				           Branch::where('id', $branchData['id'])
				           ->update([
				            	'status' => $branchData['status'],
				            	// 'name' => $branchData['name'],
				            	'gstin' => $branchData['gstin'],
				            	'address' => $branchData['address'],
				            	// 'if_manufacturing_unit' => isset($branchData['if_manufacturing_unit']) ? $branchData['if_manufacturing_unit'] : 'off',
				            ]);
	                        // Conditionally add 'if_manufacturing_unit' only if it is set
				            if (isset($branchData['if_manufacturing_unit'])) {
				                // $updateData['if_manufacturing_unit'] = $branchData['if_manufacturing_unit'];
				                Branch::where('id', $branchData['id'])
					            ->update([
					            	'if_manufacturing_unit' => $branchData['if_manufacturing_unit'],
					            ]);
				            }

				            // Update the branch
				            // $branch->update($updateData);

				        } else {
				            // Branch does not exist, insert new record
				            $branchValidated = $request->validate([
				                'branches' => 'required|array',
				                // 'branches.*.name' => 'required|string|max:255',
				                'branches.*.gstin' => 'required|string|max:20',
				                'branches.*.address' => 'required|string|max:255',
				                'branches.*.if_manufacturing_unit' => 'nullable|in:on,off',
				                'branches.*.status' => 'required|in:0,1',
				            ]);

				            $data = array_merge($branchData, ['firm_id' => $firm_id]);

				            // Insert the new branch record
				            Branch::create($data);
				        }
			        	
			        }else{
			            // Branch does not exist, insert new record
			            $branchValidated = $request->validate([
			                'branches' => 'required|array',
			                // 'branches.*.name' => 'required|string|max:255',
			                'branches.*.gstin' => 'required|string|max:20',
			                'branches.*.address' => 'required|string|max:255',
			                'branches.*.if_manufacturing_unit' => 'nullable|in:on,off',
			                'branches.*.status' => 'required|in:0,1',
			            ]);

			            $data = array_merge($branchData, ['firm_id' => $firm_id]);

			            // Insert the new branch record
			            Branch::create($data);
			        }
			    }
			}



				if ($request->user_query !='' || $request->user_query != null) {
					// return 0;
					$query = Query::create([
						'user_id' => Auth::user()->id,
						'firm_id' => $firm->id,
						'query' => $request->user_query,
						'status' => '1',
					]);
				}
				// else{
				// 	// redirect()->back()->with('error', 'Enter Query first');
				// 	return "Add query first";
				// }

		        if ($update && $firm->status == '40') {
		        	return view('payment_page');
		        	// return redirect()->route('subadminapplications')->with('success', 'Updated Successfully');
		        }else{
		        	return redirect()->back();
		        	// return view('edit_application')->with('application',$application)->with('application_status',$application_status)->with('branches',$branches)->with('directors',$directors)->with('state',State::get())->with('rotc',Rotc::get())->with('district',District::get());
		        }

    		}catch (Exception $e){
	    		$response = array(
	    			'status' => 'error', 
	    			'message' => $e->getMessage(), 
	    			'line' => $e->getLine(), 
	    			'file' => $e->getFile(), 
	    		);

	    		return $response;
    		}

    	}else{
    		// return $request;
	    	try{
		    	// return $id;
	    		$application = Helper::getFirmDetailByUserId(decrypt($id));
	    		// return $application->branches()->where('status', '1')->paginate(5);
	    		if ($application->status == '10') {
	    			$application_status = 'Pending';
	    		}else if($application->status == '20'){
	    			$application_status = 'Accepted';
	    		}else if($application->status == '30'){
	    			$application_status = 'Query';
	    		}else if($application->status == '40'){
	    			$application_status = 'Rejected';
	    		}else{
	    			$application_status = 'Expired';
	    		}


	        $branches = $application->branches()->where('status', '1')->paginate(5, ['*'], 'branches_page');
	        $directors = $application->directors()->where('status', '1')->paginate(5, ['*'], 'directors_page');

	    	}catch (Exception $e){
		    		$response = array(
		    			'status' => 'error', 
		    			'message' => $e->getMessage(), 
		    			'line' => $e->getLine(), 
		    			'file' => $e->getFile(), 
		    		);

		    		return $response;
	    	}
	    	return view('edit_application')->with('application',$application)->with('application_status',$application_status)->with('branches',$branches)->with('directors',$directors)->with('state',State::get())->with('rotc',Rotc::get())->with('district',District::get());
    	}
    }

    public function searchResults(Request $request)
	{
	    // $query = DB::table('firms')
	    //     ->join('registration_numbers', 'registration_numbers.firm_id', '=', 'firms.id');

	    // // Handle search query
	    // if ($request->has('search') && !empty($request->input('search'))) {
	    //     $search = $request->input('search');
	    //     $query->where(function($q) use ($search) {
	    //         $q->where('firm_name', 'like', "%{$search}%");
	    //           // ->orWhere('email', 'like', "%{$search}%")
	    //           // ->orWhere('telephone', 'like', "%{$search}%")
	    //           // ->orWhere('ie_code', 'like', "%{$search}%")
	    //           // ->orWhere('registration_numbers.registration_no', 'like', "%{$search}%");
	    //     });
	    // }



	    if ($request->has('search') && !empty($request->input('search'))) {
	        $search = $request->input('search');
		    $query = Firm::select('*')
		    ->leftJoin('registration_numbers','registration_numbers.firm_id', '=', 'firms.id')
		    ->leftJoin('renewals','renewals.firm_id', '=', 'firms.id')
		    ->where('firm_name', 'like', "%{$search}%")
		    ->orWhere('email', 'like', "%{$search}%")
		    ->orWhere('ie_code', 'like', "%{$search}%")
		    ->orWhere('telephone', 'like', "%{$search}%")
		    ->orWhere('registration_numbers.registration_no', 'like', "%{$search}%")
		    ->orWhere('renewals.applied_date', 'like', "%{$search}%")
		    ->orWhere('renewals.expired_date', 'like', "%{$search}%")
		    ->orWhere('renewals.issue_date', 'like', "%{$search}%");
		    $totalData = $query->count();
		    $data = $query->offset($request->input('start'))->limit($request->input('length'))->get();


		}
	    $response = [
	        'draw' => $request->input('draw') ? intval($request->input('draw')) : 0,
	        'recordsTotal' => isset($totalData) ? $totalData : 0,
	        'recordsFiltered' => isset($totalData) ? $totalData : 0,
	        'data' => isset($data) ? $data : []
	    ];

	    return response()->json($response);

	}

    public function getDistrict(Request $request)
    {
    	try{
	    	$district = District::where('state_id',$request->id)->orderBy('district','asc')->get();

	    	$response = array(
	    		'status' => 'success',
	    		'data' => $district, 
		    );
    	}catch(Exception $e){
    		$response = array(
    			'status' => 'error', 
    			'line' => $e->getLine(), 
    			'message' => $e->getMessage(), 
    		);
    	}
    	return $response;
    }    
    public function getRotc(Request $request)
    {
    	try{
	    	$districtrotc = Rotc::where('id',$request->id)->get();
	    	$rotc = Rotc::get();

	    	$response = array(
	    		'status' => 'success',
	    		'districtrotc' => $districtrotc, 
	    		'rotc' => $rotc, 
		    );
    	}catch(Exception $e){
    		$response = array(
    			'status' => 'error', 
    			'line' => $e->getLine(), 
    			'message' => $e->getMessage(), 
    		);
    	}
    	return $response;
    }
}
