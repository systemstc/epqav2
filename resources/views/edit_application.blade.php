@extends('master.master')

<?php
if(Auth::user()->user_type == 'customer'){
    $redirect_url = 'customer/view-customer-applications';
}else{
    $redirect_url = 'sub-admin/viewApplications';
}
$last_branch = 0;
$last_director = 0;
?>

@section('content')
<div class="container mx-auto p-4">
    <div class="grid grid-cols-6">
        <h1 class="text-2xl font-bold mb-4">Edit Application</h1>
        <button class="btn btn-sm w-32 btn-primary" onclick="enableButton()" {{ in_array($application->status, [30,50]) ? '' : 'disabled' }}>Edit</button>
    </div>

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
    <!-- {{$application}} -->
    <form action="{{ url('/customer/edit-customer-applications')}}/{{encrypt($application->id)}}" method="POST" id="firm-form" class="space-y-8" enctype="multipart/form-data">
        @csrf
        <!-- Customer Head Office Details -->
        <div class="card shadow-lg compact bg-base-100">
            @if(Auth::user()->user_type == 'customer')
                <h3 class="text-3md font-bold mb-4">Application Status : <span class="">{{$application_status}}<span></h3>
            @endif
            <div class="card-body">
                <h2 class="card-title">IEC Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            <span class="label-text">IEC Number</span>
                        </label>
                        <input type="text" name="ie_code" id="ie_code" class="input input-bordered" value="{{$application->ie_code}}" readonly>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">PAN Number</span>
                        </label>
                        <input type="text" name="pan_number" class="input input-bordered" value="{{$application->pan_number}}" readonly>
                    </div> 
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Date of Birth / Incorporation</span>
                        </label>
                        <input type="date" name="dob" class="input input-bordered" value="{{$application->dob}}" readonly>
                    </div> 
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nature of concern/Firm</span>
                        </label>
                        <input type="text" name="nature_of_firm" class="input input-bordered" value="{{$application->nature_of_firm}}" readonly>
                    </div>   
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Category of Exporters</span>
                        </label>
                        <select name="category_of_export" class="select select-bordered" disabled>
                            <option value="" disabled selected>Select Exporters</option>
                            <option value="0" {{ $application->category_of_export == 0 ? 'selected' : '' }}>Merchant Exporter</option>
                            <option value="1" {{ $application->category_of_export == 1 ? 'selected' : '' }}>Manufacturer Exporter</option>
                        </select>


                        <!-- <input type="text" name="category_of_export" class="input input-bordered" value="{{$application->ie_code}}" readonly> -->
                    </div> 
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Firm Name</span>
                        </label>
                        <input type="text" name="firm_name" class="input input-bordered" value="{{$application->firm_name}}" readonly>
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
                        <select name="state" class="select select-bordered" id="state" onchange="loadDistrict()" value="{{ old('state') }}" required disabled>
                            <option value="" disabled selected>Select State</option>
                            @foreach($state as $stateValue)
                                <option value="{{$stateValue['id']}}" {{ $stateValue['id'] == $application->state ? 'selected' : '' }}>{{$stateValue['state']}}</option>
                            @endforeach
                        </select>
                        <!-- <input type="text" name="state" class="input input-bordered" readonly value="{{$application->state}}"> -->
                    </div>                    

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">District</span>
                        </label>
                        <!-- <input type="text" name="district" class="input input-bordered" readonly value="{{$application->district}}"> -->
                        <select name="district" class="select select-bordered" id="district" onchange="loadRotc()" value="{{ old('district') }}" required disabled>
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
                        <input type="text" name="city" class="input input-bordered" readonly value="{{$application->city}}">
                    </div>                  



                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Pincode</span>
                        </label>
                        <input type="text" name="pincode" class="input input-bordered" readonly value="{{$application->pincode}}">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Phone</span>
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
                            <input type="checkbox" name="sez" disabled class="checkbox md:checkbox-lg" value="{{ $application->sez }}" {{ $application->sez == 'on' ? 'checked' : '' }}>              
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
<div class="card shadow-lg compact bg-base-100">
    <div class="card-body">
        <h2 class="card-title">Company Branch Details</h2>
        <?php //print_r($application->branches); ?>
        @foreach($application->branches as $key => $val)
        <div class="space-y-4 branch-container" id="branch-container">
            <?php $last_branch = $key; ?>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 branch-item items-center">
<!--                 <div class="form-control">
                    <label class="label">
                        <span class="label-text">Branch Name</span>
                    </label>

                    <input type="text" name="branches[{{$key}}][id]" class="input input-bordered" value="{{$val->id}}" hidden>
                    <input type="text" name="branches[{{$key}}][name]" class="input input-bordered" value="{{$val->name}}" readonly>
                </div> -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Branch Sr.No</span>
                    </label>

                    <input type="text" name="branches[{{$key}}][id]" class="input input-bordered" value="{{$val->id}}" hidden>
                    <input type="disabled" name="" value="{{$key + 1}}" class="input input-bordered" readonly="true">
                    <!-- <input type="text" name="branches[{{$key}}][name]" class="input input-bordered" value="{{$val->name}}" readonly> -->
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">GSTIN</span>
                    </label>
                    <input type="text" name="branches[{{$key}}][gstin]" class="input input-bordered" value="{{$val->gstin}}" readonly>
                </div>
                <div class="form-control flex-grow">
                    <label class="label">
                        <span class="label-text">Branch Address</span>
                    </label>
                    <div class="flex">
                        <input type="text" name="branches[{{$key}}][address]" class="input input-bordered flex-grow" value="{{$val->address}}" readonly>
                    </div>
                </div>
                <div class="form-control flex-grow">
                    <label class="label">
                        <span class="label-text">If Manufacturing unit</span>
                        {{$application->if_manufacturing_unit}}
                    </label>
                    <div class="flex justify-between items-center">
                        <input type="checkbox" disabled name="branches[{{$key}}][if_manufacturing_unit]" class="checkbox md:checkbox-lg" {{ $val->if_manufacturing_unit == 'on' ? 'checked' : '' }}>
                        <input type="hidden" name="branches[{{$key}}][status]" class="branch-status" value="1">
                        <button type="button" class="btn btn-error btn-sm ml-2 remove-branch">X</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <button type="button" id="add-branch" class="btn btn-secondary mt-4 w-32" {{ in_array($application->status, [30,50]) ? '' : 'disabled' }}>Add Branch</button>
    <div class="overflow-x-auto mt-6" id="branch-table">
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
        <div class="card shadow-lg compact bg-base-100">
            <div class="card-body">
                <h2 class="card-title">Company Director Details</h2>
                <div class="overflow-x-auto">
                    @foreach($application->directors as $dir)
                        <?php $last_director = $key; ?>
                        <div id="director-container" class="space-y-4 director-container">
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-3 director-item items-center">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Name</span>
                                </label>
                                <input type="text" name="director[0][name]" class="input input-bordered" value="{{$dir->name}}" required>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Designation</span>
                                </label>
                                <input type="text" name="director[0][designation]" class="input input-bordered" value="{{$dir->designation}}" required>
                            </div>
                            <div class="form-control flex-grow">
                                <label class="label">
                                    <span class="label-text">PAN Number</span>
                                </label>
                                    <input type="text" name="director[0][pan]" class="input input-bordered flex-grow" value="{{$dir->pan}}" required>
                            </div>                
                            <div class="form-control flex-grow">
                                <label class="label">
                                    <span class="label-text">Email</span>
                                </label>
                                    <input type="email" name="director[0][email]" class="input input-bordered flex-grow" value="{{$dir->email}}" required>
                            </div> 
                            <div class="form-control flex-grow">
                                <label class="label">
                                    <span class="label-text">Mobile</span>
                                </label>
                                    <input type="text" name="director[0][mobile]" class="input input-bordered flex-grow" value="{{$dir->mobile}}" required>
                            </div>                
                            <div class="form-control flex-grow">
                                <label class="label">
                                    <span class="label-text">Address</span>
                                </label>
                                <div class="flex">
                                    <input type="text" name="director[0][address]" class="input input-bordered flex-grow" value="{{$dir->address}}" required>
                                    <button type="button" class="btn btn-error btn-sm ml-2 remove-director">X</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <button type="button" id="add-director" class="btn btn-secondary mt-4 w-32" {{ in_array($application->status, [30,50]) ? '' : 'disabled' }}>Add Director</button>
                </div>

                      <div class="overflow-x-auto mt-6" id="director-table">
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

        <form action="{{ url($redirect_url .'/'. encrypt($application->id)) }}" method="POST" id="firm-form" class="space-y-8" enctype="multipart/form-data">
@csrf
<input type="hidden" name="status" id="status" value="">

<div class="card shadow-lg compact bg-base-100">
    <div class="card-body">
        <h2 class="card-title">IEC Certificate</h2>
        <div class="form-control col-span-2">
            @if($application->iec_path != null)
                {{-- Adding a timestamp to force the browser to load the latest image --}}
                <img src="{{ asset('public/storage/certificate/' . $application->iec_path) . '?' . time() }}" width="50%" height="20%">
                <p>Current IEC Certificate</p>
            @endif
        </div>
        <input type="file" name="iec_certificate" id="iec_certificate" hidden="true">
        <!-- <button type="submit" class="btn btn-primary mt-4">Upload New Certificate</button> -->
    </div>
</div>

    <div class="form-control mt-4 grid grid-cols-9 gap-1">
        @if(Auth::user()->user_type != 'customer')
            <button type="submit" id="accept-btn" class="btn btn-primary w-32" onclick="setStatus('20')" {{ in_array($application->status, [20, 40]) ? 'disabled' : '' }}>Accept</button>
            <button type="button" id="query-btn" class="btn btn-warning w-32" onclick="my_modal_4.showModal()" {{ in_array($application->status, [20, 40]) ? 'disabled' : '' }}>Query</button>
            <button type="submit" id="reject-btn" class="btn btn-error w-32" onclick="setStatus('40')" {{ in_array($application->status, [20, 40]) ? 'disabled' : '' }}>Reject</button>
        @else
            <button type="button" id="renewal-btn" class="btn btn-primary w-32" onclick="renewalPage()" {{ in_array($application->status, [30,50]) ? '' : 'disabled' }}>Renew</button>
            <button type="save" id="save-btn" class="btn btn-primary w-32" {{ in_array($application->status, [30,50]) ? '' : 'disabled' }}>Save</button>
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
        <!-- Open the modal using ID.showModal() method -->
<!--     <button class="btn" onclick="my_modal_5.showModal()">open modal</button> -->
    <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
      <div class="modal-box">
        <h3 class="text-lg font-bold">Update</h3>
        <p class="py-4">Do You want to update your Firm Details</p>
        <div class="modal-action">
          <form method="dialog">
            <!-- if there is a button in form, it will close the modal -->
            <button class="btn btn-primary m-4" onclick="enableButton()" {{ in_array($application->status, [30,50]) ? '' : 'disabled' }}>Yes</button>
            <button class="btn" onclick="renewButton()">No</button>
          </form>
        </div>
      </div>
    </dialog>
</form>


    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (!localStorage.getItem('modalShown')) {
                document.getElementById('my_modal_5').showModal();
                localStorage.setItem('modalShown', 'true');
            }
        });

        function closeModal() {
            document.getElementById('my_modal_5').close();
        }
    </script>
<script>
    $(document).ready(function() {
        $('#save-btn').hide();
        $('#renewal-btn').hide();
        $('#add-branch').hide();
        $('#add-director').hide();
        let branchIndex = <?php echo($last_branch) + 1; ?>;
        let directorIndex = <?php echo($last_director) + 1; ?>;
        $('.branch-container').hide();
        $('.director-container').hide();

                                // <div class="form-control">
                                //     <label class="label">
                                //         <span class="label-text">Branch Name</span>
                                //     </label>
                                //     <input type="text" name="branches[${branchIndex}][name]" class="input input-bordered" required>
                                // </div>
        $('#add-branch').click(function() {
            // alert(branchIndex);
            $('#branch-container').append(`
				        <div id="branch-container" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 branch-item items-center">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Branch Sr.No</span>
                                    </label>
                                <input type="disabled" name="" value="${branchIndex + 1}" class="input input-bordered" readonly="true">
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
                                        
                                    </div>
                                </div>
                                <div class="form-control flex-grow">
                                    <label class="label">
                                        <span class="label-text">If Manufacturing unit</span>
                                        {{$application->if_manufacturing_unit}}
                                    </label>
                                    <div class="flex justify-between items-center">
                                        <input type="checkbox" name="branches[${branchIndex}][if_manufacturing_unit]" class="checkbox md:checkbox-lg">
                                        <input type="hidden" name="branches[${branchIndex}][status]" class="branch-status" value="1">
                                        <button type="button" class="btn btn-error btn-sm ml-2 remove-branch">X</button>
                                    </div>
                                </div>
                            </div>
                        </div>
            `);
            branchIndex++;
        });

                $('#add-director').click(function() {
            $('#director-container').append(`
                        <div id="director-container" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-6 gap-3 director-item items-center pl-0 pr-15">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Name</span>
                                    </label>
                                    <input type="text" name="director[${directorIndex}][name]" class="input input-bordered" required>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Designation</span>
                                    </label>
                                    <input type="text" name="director[${directorIndex}][designation]" class="input input-bordered" required>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">PAN Number</span>
                                    </label>
                                    <input type="text" name="director[${directorIndex}][pan]" class="input input-bordered" required>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Email</span>
                                    </label>
                                    <input type="email" name="director[${directorIndex}][email]" class="input input-bordered" required>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Mobile</span>
                                    </label>
                                    <input type="text" name="director[${directorIndex}][mobile]" class="input input-bordered" required>
                                </div>
                                <div class="form-control flex-grow">
                                    <label class="label">
                                        <span class="label-text">Address</span>
                                    </label>
                                    <div class="flex">
                                        <input type="text" name="director[${directorIndex}][address]" class="input input-bordered flex-grow" required>
                                        <button type="button" class="btn btn-error btn-sm ml-2 remove-director">X</button>
                                    </div>
                                </div>
                            </div>
                        </div>
            `);
            directorIndex++;
        });

        $('#branch-container-'+branchIndex).hide();
        $(document).on('click', '.remove-branch', function() {
            // $(this).closest('.branch-item').remove();
            let $branchItem = $(this).closest('.branch-item');
            $branchItem.find('.branch-status').val('0');
            $branchItem.addClass('hidden'); // Optionally hide the branch visually
        });        

        $('#director-container-'+directorIndex).hide();
        $(document).on('click', '.remove-director', function() {
            // $(this).closest('.branch-item').remove();
            let $directorItem = $(this).closest('.director-item');
            // $branchItem.find('.branch-status').val('0');
            $directorItem.addClass('hidden'); // Optionally hide the branch visually
        });

        // document.addEventListener('DOMContentLoaded', function() {
        //     document.querySelectorAll('.remove-branch').forEach(function(button) {
        //         button.addEventListener('click', function() {
        //             let branchItem = this.closest('.branch-item');
        //             branchItem.querySelector('.branch-status').value = '0';
        //             branchItem.classList.add('hidden'); // Optionally hide the branch visually
        //         });
        //     });
        // });

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

function enableButton() {
    $('#save-btn').show();
    $('#renewal-btn').hide();
    $('input[readonly]').removeAttr('readonly');
    $('input[disabled]').removeAttr('disabled');
    $('textarea[readonly]').removeAttr('readonly');
    $('select:disabled').removeAttr('disabled');
    $('#ie_code').attr('readonly', true);
    $('#iec_certificate').attr('hidden', false);
    $('.branch-container').show();
    $('.director-container').show();
    $('#branch-table').hide();
    $('#director-table').hide();
    $('#add-branch').show();
    $('#add-director').show();

}

function renewButton() {
    $('#renewal-btn').show();
    $('#save-btn').hide();
    
}
</script>
@endsection
