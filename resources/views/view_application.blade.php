@extends('master.master')

<?php
if(Auth::user()->user_type == 'customer'){
    $redirect_url = 'customer/view-customer-applications';
}else{
    $redirect_url = 'sub-admin/viewApplications';
}
?>

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">View Application</h1>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- <form action="{{ url('viewapplication')}}/{{$application->id}}" method="POST" id="firm-form" class="space-y-8"> -->
        @csrf
        <!-- Customer Head Office Details -->
        <div class="card shadow-lg compact bg-base-100 mb-5">
            @if(Auth::user()->user_type == 'customer')
                <h3 class="text-3md font-bold mb-4 items-center">Application Status : <span class="">{{$application_status}}<span></h3>
            @endif
            <div class="card-body">
                <h2 class="card-title">IEC Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php //print_r($application->sez); ?>
                  <!--   <div class="form-control">
                        <label class="label">
                            <span class="label-text">Name of the applicant (firm)</span>
                        </label>
                        <input type="text" name="name" class="input input-bordered" required>
                    </div> -->

                     <div class="form-control col-span-2">
                        <label class="label">
                            <span class="label-text">Select Regional Office</span>
                        </label>
                        <select name="subadmin_selected" class="select select-bordered" disabled>
                            <option value="" disabled selected>Select Regional Office</option>
                           <!--  <option value="55" {{ $application->subadmin_selected == '55' ? 'selected' : '' }}>Textile Committee - Mumbai</option>
                            <option value="3" {{ $application->subadmin_selected == '3' ? 'selected' : '' }}>Textile Committee - Banglore</option> -->
                            @foreach($rotc as $rotcValue)
                                <option value="{{$rotcValue['id']}}" {{ $rotcValue['id'] == $application->subadmin_selected ? 'selected' : '' }}>{{$rotcValue['rotc']}}</option>
                            @endforeach
                        </select>

                       <!-- <input type="text" name="category_of_export" class="input input-bordered" value="{{$application->ie_code}}" readonly> -->
                    </div> 
                     
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Firm Name</span>
                        </label>
                        <input type="text" name="firm_name" class="input input-bordered" value="{{$application->firm_name}}" readonly>
                    </div>      

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Category of Exporters</span>
                        </label>
                        <select name="category_of_export" class="select select-bordered" disabled>
                            <option value="" disabled selected>Select Exporters</option>
                            <option value="0" {{ $application->category_of_export == 0 ? 'selected' : '' }}>Merchant Exporter</option>
                            <option value="1" {{ $application->category_of_export == 1 ? 'selected' : '' }}>Manufacturer Exporter</option>
                            <option value="2" {{ $application->category_of_export == 1 ? 'selected' : '' }}>Manufacturer cum Merchant Exporter</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">IEC Number</span>
                        </label>
                        <input type="text" name="ie_code" class="input input-bordered" value="{{$application->ie_code}}" readonly>
                    </div>
                  <!--   <div class="form-control">
                        <label class="label">
                            <span class="label-text">PAN Number</span>
                        </label>
                        <input type="text" name="pan_number" class="input input-bordered" value="{{$application->pan_number}}" readonly>
                    </div>  -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">GSTIN Number</span>
                        </label>
                        <input type="text" name="gstin_number" class="input input-bordered" value="{{$application->gstin_number}}" readonly>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Date of Birth / Incorporation</span>
                        </label>
                        <input type="date" name="dob" class="input input-bordered" value="{{$application->dob}}" readonly>
                    </div> 
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Principal Commodities for Export</span>
                        </label>
                        <!-- <input type="text" name="nature_of_firm" class="input input-bordered" value="{{$application->nature_of_firm}}" readonly> -->
                        <select name="nature_of_firm" class="select select-bordered" disabled>
                            <option value="" disabled selected>Select Exporters</option>
                            <option value="0" {{ $application->nature_of_firm == 0 ? 'selected' : '' }}>Textiles</option>
                            <option value="1" {{ $application->nature_of_firm == 1 ? 'selected' : '' }}>Textiles and Other</option>
                        </select>
                    </div>   
        
                    <!-- <div class="form-control">
                        <label class="label">
                            <span class="label-text">Office Type</span>
                        </label>
                        <select name="office_type" class="select select-bordered" value="{{$application->ie_code}}" readonly>
                            <option value="Head Office">Head Office</option>
                            <option value="Registered Office">Registered Office</option>
                            <option value="Branch Office">Branch Office</option>
                        </select>
                    </div> -->
                    <div class="form-control col-span-2">
                        <label class="label">
                            <span class="label-text">Address Line 1</span>
                        </label>
                        <textarea name="address" class="textarea textarea-bordered" readonly>{{$application->address}}</textarea>
                    </div>

                    <div class="form-control col-span-2">
                        <label class="label">
                            <span class="label-text">Address Line 2</span>
                        </label>
                        <textarea name="address_2" class="textarea textarea-bordered" readonly>{{$application->address_2}}</textarea>
                    </div>
                   <!--  <div class="form-control col-span-2">
                        <label class="label">
                            <span class="label-text">Postal Address</span>
                        </label>
                        <input type="text" name="postal_address" class="input input-bordered" value="{{$application->ie_code}}" readonly>
                    </div> -->

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">State</span>
                        </label>
                        <!-- <input type="text" name="state" class="input input-bordered" value="{{$application->state}}" required> -->
                        <select name="state" class="select select-bordered" id="state" onchange="loadDistrict()" value="{{ old('state') }}" required>
                            <option value="" disabled selected>Select State</option>
                            @foreach($state as $stateValue)
                                <option value="{{$stateValue['id']}}" {{ $stateValue['id'] == $application->state ? 'selected' : '' }}>{{$stateValue['state']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">District</span>
                        </label>
                        <!-- <input type="text" name="district" class="input input-bordered" value="{{$application->district}}" required> -->
                        <select name="district" class="select select-bordered" id="district" onchange="loadRotc()" value="{{ old('district') }}" required>
                            <option value="" data-rotc="" disabled selected>Select Disctrict</option>
                            @foreach($district as $districtValue)
                                <option value="{{$districtValue['id']}}" {{ $districtValue['id'] == $application->district ? 'selected' : '' }}>{{$districtValue['district']}}</option>
                            @endforeach
                        </select>
                    </div>
                                        
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">City</span>
                        </label>
                        <input type="text" name="city" class="input input-bordered" value="{{$application->city}}" required>
                    </div>                  



                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Pincode</span>
                        </label>
                        <input type="text" name="pincode" class="input input-bordered" value="{{$application->pincode}}" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Mobile</span>
                        </label>
                        <input type="text" name="telephone" class="input input-bordered" value="{{$application->telephone}}" readonly>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" name="email" class="input input-bordered" value="{{$application->email}}" readonly>
                    </div>

                    <div class="w-[7rem]">
                        <div class="form-control grid grid-cols-2 gap-1">
                            <label class="label">
                                <span class="label-text">Is SEZ</span>
                            </label>
                            <input type="checkbox" name="sez" disabled class="checkbox md:checkbox-lg" {{ $application->sez == 'on' ? 'checked' : '' }}>              
                        </div>           
                    </div>
                   <!--  <div class="form-control">
                        <label class="label">
                            <span class="label-text">Manufacturing Address</span>
                        </label>
                        <input type="text" name="manufacturing_address" class="input input-bordered">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Manufacturing Telephone</span>
                        </label>
                        <input type="text" name="manufacturing_telephone" class="input input-bordered">
                    </div> -->
                </div>
            </div>
        </div>

<!-- Company Branch Details -->
<div class="card shadow-lg compact bg-base-100 mb-5">
    <div class="card-body">
        <h2 class="card-title">Company Branch Details</h2>
<!--         @foreach($application->branches as $val)
        <div id="branch-container" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 branch-item items-center">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Branch Name</span>
                    </label>
                    <input type="text" name="branches[0][name]" class="input input-bordered" value="{{$val->name}}" readonly>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">GSTIN</span>
                    </label>
                    <input type="text" name="branches[0][gstin]" class="input input-bordered" value="{{$val->gstin}}" readonly>
                </div>
                <div class="form-control flex-grow">
                    <label class="label">
                        <span class="label-text">Branch Address</span>
                    </label>
                    <div class="flex">
                        <input type="text" name="branches[0][address]" class="input input-bordered flex-grow" value="{{$val->address}}" readonly>
                    </div>
                </div>
            </div>
        </div>
        @endforeach -->
        <!-- <button type="button" id="add-branch" class="btn btn-secondary mt-4 w-32">Add Branch</button> -->
    <div class="overflow-x-auto mt-6">
        <table class="table table-striped w-full">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Name</th>
                    <th>GSTIN</th>
                    <th>Address</th>
                    <th>Manufacturing Unit</th>
                </tr>
            </thead>
                        <tbody>
                @forelse($branches as $index => $branch)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $branch['name'] }}</td>
                        <td>{{ $branch['gstin'] }}</td>
                        <td>{{ $branch['address'] }}</td>
                        <td>{{ $branch['if_manufacturing_unit'] == 'on' ? 'Yes' : 'No'}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No branches found.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
            <!-- Pagination for Branches -->
            <div class="mt-4">
                <!-- {{ $branches->links('pagination::tailwind') }} -->
                {{ $branches->appends(['directors_page' => $directors->currentPage()])->links('pagination::tailwind') }}
            </div>
    </div>
    </div>
</div>









        <!-- Company Director Details -->
        <div class="card shadow-lg compact bg-base-100 mb-5">
            <div class="card-body">
                <h2 class="card-title">Company Director Details</h2>
                <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4"> -->
                   <!--  @foreach($application->directors as $dir)
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Name</span>
                            </label>
                            <input type="text" name="director_name" class="input input-bordered" value="{{$dir->director_name}}" readonly>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Designation</span>
                            </label>
                            <input type="text" name="designation" class="input input-bordered" value="{{$dir->designation}}" readonly>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">PAN Number</span>
                            </label>
                            <input type="text" name="director_pan" class="input input-bordered" value="{{$dir->director_pan}}" readonly>
                        </div>
                    @endforeach -->

                      <div class="overflow-x-auto mt-6">
        <table class="table table-striped w-full">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Director Pan</th>
                    <th>Director Email</th>
                    <th>Director Mobile</th>
                    <th>Director Address</th>
                </tr>
            </thead>
                        <tbody>
                @forelse($directors as $index => $director)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $director['name'] }}</td>
                        <td>{{ $director['designation'] }}</td>
                        <td>{{ $director['pan'] }}</td>
                        <td>{{ $director['email'] }}</td>
                        <td>{{ $director['mobile'] }}</td>
                        <td>{{ $director['address'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No directors found.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
    <!-- Pagination Links -->
                    <div class="mt-4">
                        <!-- {{ $directors->links('pagination::tailwind') }} -->
                        {{ $directors->appends(['branches_page' => $branches->currentPage()])->links('pagination::tailwind') }}
                    </div>
                <!-- </div> -->
            </div>
        </div>

<!-- note -->
        <form action="{{ url($redirect_url .'/'. encrypt($application->id)) }}" method="POST" id="firm-form" class="space-y-8">
 @if(Auth::user()->user_type != 'customer')
        <div class="card shadow-lg compact bg-base-100">
            <div class="card-body">
                <h2 class="card-title">Note</h2>
                <div class="form-control col-span-2">
                    <!-- <label class="label">
                        <span class="label-text">Note</span>
                    </label> -->

                    <textarea name="note" class="textarea textarea-bordered">{{isset($application->notes) ? $application->notes->note : ''}}</textarea>
                </div>
            </div>
        </div>
    @endif

@if($application->iec_path != null)
    <div class="card shadow-lg compact bg-base-100">
        <div class="card-body">
            <h2 class="card-title">IEC Certificate</h2>
            <div class="form-control col-span-2">
                <!-- <label class="label">
                    <span class="label-text">Note</span>
                </label> -->
               <img src="{{ asset('public/storage/certificate/' . $application->iec_path) }}" width="50%" height="20%">


                <!-- <textarea name="note" class="textarea textarea-bordered">{{isset($application->notes) ? $application->notes->note : ''}}</textarea> -->
            </div>
        </div>
    </div>
@endif
    @csrf
    <input type="hidden" name="status" id="status" value="">
    <div class="form-control mt-4 grid grid-cols-9 gap-1">
        @if(Auth::user()->user_type != 'customer')
            <button type="submit" id="accept-btn" class="btn btn-primary w-32" onclick="setStatus('20')" {{ in_array($application->status, [20, 40]) ? 'disabled' : '' }}>Accept</button>
            <button type="button" id="query-btn" class="btn btn-warning w-32" onclick="my_modal_4.showModal()" {{ in_array($application->status, [20, 40]) ? 'disabled' : '' }}>Query</button>
            <button type="submit" id="reject-btn" class="btn btn-error w-32" onclick="setStatus('40')" {{ in_array($application->status, [20, 40]) ? 'disabled' : '' }}>Reject</button>
        @else
            <button type="button" id="query-btn" class="btn btn-warning w-32" onclick="my_modal_4.showModal()" {{ in_array($application->status, [20, 40]) ? 'disabled' : '' }}>View Query</button>
        @endif
        <!-- <button type="button" id="query-btn" class="btn btn-warning w-32">Query</button> -->
    </div>
    <!-- You can open the modal using ID.showModal() method -->
    <dialog id="my_modal_4" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="text-lg font-bold">Query!</h3>
            <p class="py-4">Write your Query in the given section</p>
            <!-- {{$application}}{{Auth::user()->id}} -->
            <div class="artboard artboard-horizontal phone-5">
                @foreach($application->querys as $query) 
                    @if(Auth::user()->user_type == 'sub-admin')
                        @if($application->user_id == $query->user_id)
                                <div class="chat chat-start">
                                      <div class="chat-header">
                                        Customer
                                        <time class="text-xs opacity-50">{{$query->created_at}}</time>
                                      </div>
                                  <div class="chat-bubble">
                                    {{$query->query}} 
                                  </div>
                                </div>
                            @elseif(Auth::user()->id == $query->user_id)
                                <div class="chat chat-end">
                                    <div class="chat-header">
                                        You
                                        <time class="text-xs opacity-50">{{$query->created_at}}</time>
                                      </div>
                                  <div class="chat-bubble">{{$query->query}}</div>
                                </div>
                            @endif
                    @elseif(Auth::user()->user_type == 'customer')
                        @if($application->subadmin_selected == $query->user_id)
                            <div class="chat chat-start">
                                <div class="chat-header">
                                    Subadmin
                                        <time class="text-xs opacity-50">{{$query->created_at}}</time>
                                </div>
                              <div class="chat-bubble">
                                {{$query->query}}
                              </div>
                            </div>
                        @elseif(Auth::user()->id == $query->user_id)
                            <div class="chat chat-end">
                                <div class="chat-header">
                                        You
                                        <time class="text-xs opacity-50">{{$query->created_at}}</time>
                                </div>
                              <div class="chat-bubble">{{$query->query}}</div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>

            <textarea name="user_query" class="textarea textarea-bordered textarea-md w-full"></textarea>
            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button, it will close the modal -->
                    <button type="submit" class="btn btn-primary" onclick="setStatus('30')">Send</button>
                    <button type="button" class="btn" onclick="closeModal()">Close</button>
                </form>
            </div>
        </div>
    </dialog>
</form>


    <!-- </form> -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        let branchIndex = 1;

        $('#add-branch').click(function() {
            $('#branch-container').append(`
				        <div id="branch-container" class="space-y-4">
				            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 branch-item items-center">
				                <div class="form-control">
				                    <label class="label">
				                        <span class="label-text">Branch Name</span>
				                    </label>
				                    <input type="text" name="branches[${branchIndex}][name]" class="input input-bordered" required>
				                </div>
				                <div class="form-control">
				                    <label class="label">
				                        <span class="label-text">GSTIN</span>
				                    </label>
				                    <input type="text" name="branches[${branchIndex}][gstin]" class="input input-bordered" required>
				                </div>
				                <div class="form-control flex-grow">
				                    <label class="label">
				                        <span class="label-text">Branch Address</span>
				                    </label>
				                    <div class="flex">
				                        <input type="text" name="branches[${branchIndex}][address]" class="input input-bordered flex-grow" required>
				                        // <button type="button" class="btn btn-error btn-sm ml-2 remove-branch">X</button>
				                    </div>
				                </div>
				            </div>
				        </div>
            `);
            branchIndex++;
        });

        $(document).on('click', '.remove-branch', function() {
            $(this).closest('.branch-item').remove();
        });

        // jQuery Validation
        $('#firm-form').validate({
            errorClass: 'text-red-500',
            errorElement: 'span',
            highlight: function(element, errorClass) {
                $(element).closest('.input, .select, .textarea').addClass('border-red-500');
            },
            unhighlight: function(element, errorClass) {
                $(element).closest('.input, .select, .textarea').removeClass('border-red-500');
            },
            rules: {
                'name': {
                    required: true,
                    maxlength: 255
                },
                'office_type': {
                    required: true
                },
                'address': {
                    // required: true,
                    maxlength: 500
                },
                'postal_address': {
                    required: true,
                    maxlength: 255
                },
                'telephone': {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                'email': {
                    required: true,
                    email: true,
                    maxlength: 255
                },
                'manufacturing_address': {
                    maxlength: 500
                },
                'manufacturing_telephone': {
                    digits: true,
                    maxlength: 15
                },
                'is_merchant_exporter': {
                    required: true
                },
                'year_of_establishment': {
                    required: true,
                    digits: true,
                    minlength: 4,
                    maxlength: 4
                },
                'directors': {
                    required: true,
                    maxlength: 255
                },
                'ie_code': {
                    required: true,
                    maxlength: 50
                },
                'ie_code_date': {
                    required: true,
                    date: true
                },
                'commodities': {
                    required: true,
                    maxlength: 255
                },
                'payment_details': {
                    required: true,
                    maxlength: 500
                },
                'branches[0][name]': {
                    required: true,
                    maxlength: 255
                },
                'branches[0][address]': {
                    required: true,
                    maxlength: 500
                },
                'branches[0][director]': {
                    required: true,
                    maxlength: 255
                }
            }
        });
    });
    function setStatus(value) {
        document.getElementById('status').value = value;
    }

    function closeModal() {
        document.getElementById('my_modal_4').close();
    }

//     $(document).ready(function() {
//     $('#query-btn').on('click', function() {
//         // Show the modal
//         $('#my_modal_4')[0].showModal();

//         // Make an AJAX request to the API
//         $.ajax({
//             url: "{{ url('sub-admin/viewApplications/')}}/{{$application->id}} }}",
//             method: 'GET',
//             headers: {
//                 'X-CSRF-TOKEN': '{{ csrf_token() }}' // If you need CSRF token for security
//             },
//             success: function(data) {
//                 console.log('Success:', data);
//                 // Process the response data and update the modal content if needed
//                 // Example: $('[name="user_query"]').val(data.query);
//             },
//             error: function(error) {
//                 console.error('Error:', error);
//             }
//         });
//     });
// });

function loadDistrict(){
    // alert('fd');
    var $rotc = $('#rotc');
    $rotc.empty();
    $.ajax({
        type:'POST',
        url:"{{url('/customer/get-district')}}",
        data: {
            '_token' : '<?php echo csrf_token(); ?>',
            'id' : $('#state').val(),
        },
        success:function(data) {
            // $('#district').val('');
            let districtSelect = $('#district');
            // console.log(data);
            if (data.status == 'success') {
                districtSelect.empty();
                for (let i = 0; i < data.data.length; i++) {
                    // console.log(data.data[i].rotc_id);
                    districtSelect.append(`<option value="${data.data[i].id}" data-rotc="${data.data[i].rotc_id}">${data.data[i].district}</option>`);
                }
            }else{
                console.log('error');
            }
            // $("#msg").html(data.msg);
        }
    });
}
</script>
@endsection
