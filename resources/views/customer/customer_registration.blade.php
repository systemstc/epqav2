@extends('master.master')

<style type="text/css">
    small {
        display: none;
    }
</style>

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Application for Registration</h1>

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

    <form action="{{ route('firms.preview') }}" method="POST" id="firm-form" class="space-y-8" enctype="multipart/form-data">
        @csrf
        
        <!-- Customer Head Office Details -->
        <div class="card shadow-lg compact bg-base-100">
            <div class="card-body">
                <h2 class="card-title mb-0">IEC Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <!--   <div class="form-control">
                        <label class="label">
                            <span class="label-text">Name of the applicant (firm)</span>
                        </label>
                        <input type="text" name="name" class="input input-bordered" required>
                    </div> -->
                    <!-- {{ old('subadmin_selected')}} -->
                    <div class="form-control col-span-2">
                        <label class="label">
                            <span class="label-text">Regional Office<span class="text-red-500"> *</span></span>
                        </label>
                        <!-- onchange="RotcChanged()" -->
                        <select name="subadmin_selected" id="rotc" class="select select-bordered" value="{{ old('subadmin_selected')}}" {{ old('subadmin_selected') !== null ?? 'selected'}} required>
                            <option value="" disabled selected>Select Regional Office</option>
                            @foreach($rotc as $value)
                                <option value="{{$value->id}}" {{ old('subadmin_selected') == $value->id ?? 'selected'}}>{{$value->rotc}}</option>
                            @endforeach
                        </select>
                        <small style="color: red">select rotc is required</small>
                    </div> 
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Firm Name<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="text" name="firm_name" class="input input-bordered" value="{{ old('firm_name') }}" required>
                        <small style="color: red">Firm Name is required</small>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Category of Exporters<span class="text-red-500"> *</span></span>
                        </label>
                        <select name="category_of_export" class="select select-bordered" value="{{ old('category_of_export') }}" {{ old('category_of_export') !== null ? 'selected' : ''}} required>
                            <option value="" disabled selected>Select Exporters</option>
                            <option value="0" {{ old('category_of_export') === "0" ? 'selected' : ''}}>Merchant Exporter</option>
                            <option value="1" {{ old('category_of_export') === "1" ? 'selected' : ''}}>Manufacturer Exporter</option>
                            <option value="2" {{ old('category_of_export') === "2" ? 'selected' : ''}}>Manufacturer cum Merchant Exporter</option>
                        </select>
                        <small style="color: red">Category of Exporters is required</small>
                        <!-- <input type="text" name="category_of_export" class="input input-bordered" required> -->
                    </div> 
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">IEC Number<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="text" id="ie_code" name="ie_code" class="input input-bordered" value="{{ old('ie_code') }}" required>
                        <small style="color: red">10 digit IEC Number is required</small>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">PAN Number<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="text" id="pan_number" name="pan_number" class="input input-bordered" value="{{ old('pan_number') }}" required>
                        <small style="color: red">Enter a valid PAN Number is required</small>
                    </div>                     
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">GSTIN Number<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="text" id="gstin_number" name="gstin_number" class="input input-bordered" value="{{ old('gstin_number') }}" required>
                        <small style="color: red">Enter a valid GSTIN Number is required</small>
                    </div> 
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Date of Birth / Incorporation<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="date" name="dob" class="input input-bordered" value="{{ old('dob') }}" required>
                        <small style="color: red">Date is required</small>
                    </div> 
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Principal Commodities for Export<span class="text-red-500"> *</span></span>
                        </label>
                        <!-- <input type="text" name="nature_of_firm" class="input input-bordered" required> -->
                        <select name="nature_of_firm" class="select select-bordered" value="{{ old('nature_of_firm') }}" {{ old('nature_of_firm') !== null ? 'selected' : ''}} required>
                            <option value="" disabled selected>Select Exporters</option>
                            <option value="0" {{ old('nature_of_firm') == "0" ? 'selected' : ''}}>Textiles</option>
                            <option value="1" {{ old('nature_of_firm') == "1" ? 'selected' : ''}}>Textiles and Other</option>
                        </select>
                        <small style="color: red">Date is required</small>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">IEC Certificate<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="file" accept="image/*" name="iec_certificate" class="input input-bordered" value="{{ old('email') }}" required>
                        <small style="color: red">IEC Certificate is required</small>
                    </div>                  
                    <!-- <div class="form-control">
                        <label class="label">
                            <span class="label-text">Office Type</span>
                        </label>
                        <select name="office_type" class="select select-bordered" required>
                            <option value="Head Office">Head Office</option>
                            <option value="Registered Office">Registered Office</option>
                            <option value="Branch Office">Branch Office</option>
                        </select>
                    </div> -->
                    <div class="form-control col-span-2">
                        <label class="label">
                            <span class="label-text">Address line 1<span class="text-red-500"> *</span></span>
                        </label>
                        <textarea name="address" class="textarea textarea-bordered" required>{{ old('address') }}</textarea>
                        <small style="color: red">Address is required</small>
                    </div>                    

                    <div class="form-control col-span-2">
                        <label class="label">
                            <span class="label-text">Address line 2</span>
                        </label>
                        <textarea name="address_2" class="textarea textarea-bordered">{{ old('address_2') }}</textarea>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">State<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="hidden" id="oldState" value="{{ old('state') }}">
                        <select name="state" class="select select-bordered" id="state" onchange="loadDistrict(this.value)" value="{{ old('state') }}" {{ old('state') !== null ? 'selected' : ''}} required>
                            <option value="" disabled selected>Select State</option>
                            @foreach($state as $stateValue)
                                <option value="{{$stateValue['id']}}" {{ old('state') == $stateValue['id'] ? 'selected' : ''}}>{{$stateValue['state']}}</option>
                            @endforeach
                        </select> 
                        <small style="color: red">State is required</small>                       
                        <!-- <input type="text" name="state" class="input input-bordered" required> -->
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">District<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="hidden" id="oldDistrict" value="{{ old('district') }}">


                        <select name="district" class="select select-bordered" id="district" onchange="loadRotc()" value="{{ old('district') }}" {{ old('district') !== null ? 'selected' : ''}} required>
                            <option value="" data-rotc="" disabled selected>Select Disctrict</option>
                        </select>
                        <small style="color: red">District is required</small>
                        <!-- <input type="text" name="district" class="input input-bordered" required> -->
                    </div>
                    	                
	                <div class="form-control">
                        <label class="label">
                            <span class="label-text">City<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="text" name="city" class="input input-bordered" value="{{ old('city') }}" required>
                        <small style="color: red">City is required</small>
                    </div>	                



                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Pincode<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="text" name="pincode" class="input input-bordered" value="{{ old('pincode') }}" required>
                        <small style="color: red">Pincode is required</small>
                    </div>
                   <!--  <div class="form-control col-span-2">
                        <label class="label">
                            <span class="label-text">Postal Address</span>
                        </label>
                        <input type="text" name="postal_address" class="input input-bordered" required>
                    </div> -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Mobile<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="text" name="telephone" class="input input-bordered" value="{{ old('telephone') }}" required>
                        <small style="color: red">Mobile is required</small>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email<span class="text-red-500"> *</span></span>
                        </label>
                        <input type="email" name="email" class="input input-bordered" value="{{ old('email') }}" required>
                        <small style="color: red">Email is required</small>
                    </div>                    

                    <div class="w-[7rem]">
                        <div class="form-control grid grid-cols-2 gap-1">
                            <label class="label">
                                <span class="label-text">Is SEZ</span>
                            </label>
                            <input type="checkbox" name="sez" class="checkbox md:checkbox-lg" value="{{ old('sez') }}">              
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
        <div id="branch-container" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 branch-item items-center">
              <!--   <div class="form-control">
                    <label class="label">
                        <span class="label-text">Branch Name</span>
                    </label>
                    <input type="text" name="branches[0][name]" class="input input-bordered" value="{{ old('branches.0.name') }}" required>
                </div>   -->              
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Branch Sr.No</span>
                    </label>
                    <input type="text" class="input input-bordered" value="1" required>
                    <!-- <small style="color: red">Email is required</small> -->
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">GSTIN</span>
                    </label>
                    <input type="text" name="branches[0][gstin]" class="input input-bordered" value="{{ old('branches.0.gstin') }}" required>
                    <small style="color: red">Branch GSTIN is required</small>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Branch Address</span>
                    </label>
                    <input type="text" name="branches[0][address]" class="input input-bordered flex-grow" value="{{ old('branches.0.address') }}" required>
                    <small style="color: red">Branch Address is required</small>
                </div>
                <div class="form-control flex-grow">
                    <label class="label">
                        <span class="label-text">If Manufacturing unit</span>
                    </label>
                    <div class="flex justify-between items-center">
                        <input type="checkbox" name="branches[0][if_manufacturing_unit]" class="checkbox md:checkbox-lg" value="{{ old('branches.0.if_manufacturing_unit') }}">
                        <button type="button" class="btn btn-error btn-sm ml-2 remove-branch">X</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="add-branch" class="btn btn-secondary mt-4 w-32">Add Branch</button>
    </div>
</div>



        <!-- Company Director Details -->
<!--         <div class="card shadow-lg compact bg-base-100">
            <div class="card-body">
                <h2 class="card-title">Company Director Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" name="director_name" class="input input-bordered" required>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Designation</span>
                        </label>
                        <input type="text" name="designation" class="input input-bordered" required>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">PAN Number</span>
                        </label>
                        <input type="text" name="director_pan" class="input input-bordered" required>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Company Director Details -->
<div class="card shadow-lg compact bg-base-100">
    <div class="card-body">
        <h2 class="card-title">Company Proprietor/Partner/Director(s) Details</h2>
        <div id="director-container" class="space-y-4 overflow-x-auto">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-3 director-item items-center">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Name</span>
                    </label>
                    <input type="text" name="director[0][name]" class="input input-bordered" value="{{ old('director.0.name') }}" required>
                    <small style="color: red">Company Proprietor/Partner/Director(s) is required</small>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Designation</span>
                    </label>
                    <input type="text" name="director[0][designation]" class="input input-bordered" value="{{ old('director.0.designation') }}" required>
                    <small style="color: red">Company Proprietor/Partner/Director(s) Designation is required</small>
                </div>
                <div class="form-control flex-grow">
                    <label class="label">
                        <span class="label-text">PAN Number</span>
                    </label>
                        <input type="text" name="director[0][pan]" class="input input-bordered flex-grow" value="{{ old('director.0.pan') }}" required>
                    <small style="color: red">Company Proprietor/Partner/Director(s) PAN Number is required</small>
                </div>                
                <div class="form-control flex-grow">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                        <input type="email" name="director[0][email]" class="input input-bordered flex-grow" value="{{ old('director.0.email') }}" required>
                        <small style="color: red">Company Proprietor/Partner/Director(s) Email is required</small>
                </div> 
                <div class="form-control flex-grow">
                    <label class="label">
                        <span class="label-text">Mobile</span>
                    </label>
                        <input type="text" name="director[0][mobile]" class="input input-bordered flex-grow" value="{{ old('director.0.mobile') }}" required>
                        <small style="color: red">Company Proprietor/Partner/Director(s) Mobile is required</small>
                </div>                
                <div class="form-control flex-grow">
                    <label class="label">
                        <span class="label-text">Address</span>
                    </label>
                    <div class="flex">
                        <div>
                            <input type="text" name="director[0][address]" class="input input-bordered flex-grow" value="{{ old('director.0.address') }}" required>
                            <small style="color: red">Company Proprietor/Partner/Director(s) Address is required</small>
                        </div>
                        <button type="button" class="btn btn-error btn-sm ml-2 remove-director">X</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="add-director" class="btn btn-secondary mt-4 w-32">Add Director</button>
    </div>
</div>

<div class="max-w-full mx-auto mt-10 p-6 border rounded-lg shadow-lg">
        <h2 class="text-lg font-semibold mb-4">Terms and Conditions<span class="text-red-500"> *</span></h2>
<!--         <div class="mb-4">
            <p class="text-sm text-gray-600">
                Please read our <a href="#" class="text-blue-500 hover:underline">Terms and Conditions</a> before proceeding.
            </p>
        </div> -->
        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" id="terms" class="checkbox checkbox-primary mr-2">
                <span class="text-sm text-gray-600">I/We hereby certify that the above information is true to the best of my/our
knowledge and belief. Further, I/We hereby declare that I/We have not applied for
or obtained any exporters registration number previously other than stated at Sr.
No. 11 above from any of the offices of the Textiles Committee.</span>
            </label>
        </div>
        <!-- <button id="submit-btn" class="btn btn-primary w-full">Submit</button> -->
            <button type="submit" id="submit-btn" class="btn btn-primary w-32">Submit</button>
        <div id="error-message" class="mt-4 text-red-500 hidden">You must agree to the terms and conditions to proceed.</div>
    </div>

       <!--  <div class="form-control mt-4">
        </div> -->
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    let oldBranches = @json(old('branches', []));
    let oldDirector = @json(old('director', []));
    $(document).ready(function() {

        $('#ie_code, #pan_number, #gstin_number').on('keyup', function () {
            // console.log(this.value);
            this.value = this.value.toUpperCase();
        });
        const oldState = document.getElementById('oldState').value;
        // alert(oldState);
        if (oldState !== '') {
            loadDistrict(oldState);
        }
        let branchIndex = 1;
        let directorIndex = 1;
				                // <div class="form-control">
				                //     <label class="label">
				                //         <span class="label-text">Branch Name</span>
				                //     </label>
				                //     <input type="text" name="branches[${branchIndex}][name]" class="input input-bordered" value="${oldBranches[branchIndex] ? oldBranches[branchIndex]['name'] : ''}" required>
				                // </div>                              

        $('#add-branch').click(function() {
            $('#branch-container').append(`
				        <div id="branch-container" class="space-y-4">
				            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 branch-item items-center">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Branch Sr.No</span>
                                    </label>
                                    <input type="text"  class="input input-bordered" value="${branchIndex + 1}">
                                </div>
				                <div class="form-control">
				                    <label class="label">
				                        <span class="label-text">GSTIN</span>
				                    </label>
				                    <input type="text" name="branches[${branchIndex}][gstin]" class="input input-bordered" value="${oldBranches[branchIndex] ? oldBranches[branchIndex]['gstin'] : ''}" required>
                                    <small style="color: red">Branch GSTIN is required</small>
				                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Branch Address</span>
                                    </label>
                                    <input type="text" name="branches[${branchIndex}][address]" class="input input-bordered flex-grow" value="${oldBranches[branchIndex] ? oldBranches[branchIndex]['address'] : ''}" required>
                                    <small style="color: red">Branch Address is required</small>
                                </div>
				                <div class="form-control flex-grow">
				                    <label class="label">
				                        <span class="label-text">If Manufacturing unit</span>
				                    </label>
				                    <div class="flex justify-between items-center">
				                        <input type="checkbox" name="branches[0][if_manufacturing_unit]" class="checkbox md:checkbox-lg" required>
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
				                    <input type="text" name="director[${directorIndex}][name]" class="input input-bordered" value="${oldDirector[directorIndex] ? oldDirector[directorIndex]['name'] : ''}" required>
                                    <small style="color: red">Company Proprietor/Partner/Director(s) Name is required</small>
				                </div>
				                <div class="form-control">
				                    <label class="label">
				                        <span class="label-text">Designation</span>
				                    </label>
				                    <input type="text" name="director[${directorIndex}][designation]" class="input input-bordered" value="${oldDirector[directorIndex] ? oldDirector[directorIndex]['designation'] : ''}" required>
                                    <small style="color: red">Company Proprietor/Partner/Director(s) Designation is required</small>
				                </div>
				                <div class="form-control">
				                    <label class="label">
				                        <span class="label-text">PAN Number</span>
				                    </label>
				                    <input type="text" name="director[${directorIndex}][pan]" class="input input-bordered" value="${oldDirector[directorIndex] ? oldDirector[directorIndex]['pan'] : ''}" required>
                                    <small style="color: red">Company Proprietor/Partner/Director(s) PAN Number is required</small>
				                </div>
				                <div class="form-control">
				                    <label class="label">
				                        <span class="label-text">Email</span>
				                    </label>
				                    <input type="email" name="director[${directorIndex}][email]" class="input input-bordered" value="${oldDirector[directorIndex] ? oldDirector[directorIndex]['email'] : ''}" required>
                                    <small style="color: red">Company Proprietor/Partner/Director(s) Email is required</small>
				                </div>
				                <div class="form-control">
				                    <label class="label">
				                        <span class="label-text">Mobile</span>
				                    </label>
				                    <input type="text" name="director[${directorIndex}][mobile]" class="input input-bordered" value="${oldDirector[directorIndex] ? oldDirector[directorIndex]['mobile'] : ''}" required>
                                    <small style="color: red">Company Proprietor/Partner/Director(s) Mobile is required</small>
				                </div>
				                <div class="form-control flex-grow">
				                    <label class="label">
				                        <span class="label-text">Address</span>
				                    </label>
				                    <div class="flex">
                                    <div>
				                        <input type="text" name="director[${directorIndex}][address]" class="input input-bordered flex-grow" value="${oldDirector[directorIndex] ? oldDirector[directorIndex]['address'] : ''}" required>
                                        <small style="color: red">Company Proprietor/Partner/Director(s) Address is required</small>
                                        </div>
				                        <button type="button" class="btn btn-error btn-sm ml-2 remove-director">X</button>
				                    </div>
				                </div>
				            </div>
				        </div>
            `);
            branchIndex++;
        });

        $(document).on('click', '.remove-branch', function() {
            $(this).closest('.branch-item').remove();
        })        
        $(document).on('click', '.remove-director', function() {
            $(this).closest('.director-item').remove();
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
            errorPlacement: function(error, element) {
                let errorElement = $(element).siblings('small');
                if (errorElement.length) {
                    errorElement.show();
                } else {
                    error.insertAfter(element);
                }
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
                    required: true,
                    maxlength: 500
                },
                'postal_address': {
                    required: true,
                    maxlength: 255
                },
                'telephone': {
                    required: true,
                    digits: true,
                    maxlength: 10
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
                    maxlength: 10,
                    pattern: /^[a-zA-Z0-9]{10}$/,
                },
                'pan_number': {
                    required: true,
                    maxlength: 10,
                    pattern: /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/,
                },'gstin_number': {
                    required: true,
                    maxlength: 15,
                    pattern: /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z0-9]{1}Z[A-Z0-9]{1}$/,
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
            },   
            onkeyup: function(element) {
                $(element).valid(); // Revalidate the field as the user types
            },
            success: function(label, element) {
                $(element).siblings('small').hide(); // Hide the error message when the field becomes valid
            }
        });
    });

function loadDistrict(state_id){
    // alert(state_id);
    var $rotc = $('#rotc');
    $rotc.empty();
    $.ajax({
        type:'POST',
        url:"{{url('/customer/get-district')}}",
        data: {
            '_token' : '<?php echo csrf_token(); ?>',
            'id' : state_id,
            // 'id' : $('#state').val(),
        },
        success:function(data) {
            // $('#district').val('');
            let districtSelect = $('#district');
            const oldDistrict = document.getElementById('oldDistrict').value;
            // alert(oldDistrict);
            // console.log(data);
            if (data.status == 'success') {
                districtSelect.empty();
                for (let i = 0; i < data.data.length; i++) {
                    // console.log(data.data[i].rotc_id);
                    districtSelect.append(`<option value="${data.data[i].id}" data-rotc="${data.data[i].rotc_id}" ${data.data[i].id == oldDistrict ? 'selected' : ''}>${data.data[i].district}</option>`);
                }
            }else{
                console.log('error');
            }
            // $("#msg").html(data.msg);
        }
    });
}

function loadRotc() {
    let districtSelect = $('#district');
        // Assuming you want to handle the district dropdown after the AJAX success
        let selectedOption = $('#district').find('option:selected'); // Get the selected option

        // Retrieve the value of the data-rotc attribute
        let rotcId = selectedOption.attr('data-rotc'); // Use attr to get the data-rotc value

        // console.log('Selected ROTC ID:', rotcId);
    $.ajax({
        type: 'POST',
        url: "{{url('/customer/get-rotc')}}",
        data: {
            '_token' : '<?php echo csrf_token(); ?>',
            'id' : rotcId,
        },
        success :function (data) {
            let rotcSelect = $('#rotc');
            if (data.status == 'success') {
                // console.log(data);
                rotcSelect.empty();
                // for (let i = 0; i < data.data.length; i++) {
                    // console.log(data.data[i].id);
                    // $('#rotc').val(data.data[i].id);
                    var $rotc = $('#rotc');
                    $rotc.empty();
                    console.log(data);

                    // Use string concatenation to build the selector correctly
                    // $('#rotc option[value="' + rotcId + '"]').prop('selected', 'selected').change();
                    // console.log($('#rotc').val());

        // Optional: Trigger the change event if you need to handle additional logic
                    // $('#rotc').trigger('change');
                                // Select the option by its value
                    // $('#rotc').val(rotcId);
                    // console.log($('#rotc').val());

                    // Trigger the change event if needed
                    // $('#rotc').trigger('change');

                      // Populate new options
                    $.each(data.rotc, function(index, item) {
                        $rotc.append($('<option>', {
                            value: item.id,
                            text: item.rotc
                        }));
                    });
                                      // Set the default selected value
                    if (data.districtrotc) {
                        $rotc.val(data.districtrotc[0].id).change(); // Set and trigger change if needed
                    }

                // }
            }else{
                console.log('error');
            }
        }
    });
}

// function RotcChanged(){
//     var $state = $('#state');
//     var $district = $('#district');
//     $("#state").val("");
//     $("#district").val("");
//     // $("#district option[selected]").removeAttr("selected");
//     // $("#state option[selected]").removeAttr("selected");
//     // $state.empty();
//     // $district.empty();
// }

        document.getElementById('submit-btn').addEventListener('click', function(event) {
            var checkbox = document.getElementById('terms');
            var errorMessage = document.getElementById('error-message');

            if (!checkbox.checked) {
                errorMessage.classList.remove('hidden');
                event.preventDefault(); // Prevent form submission
            } else {
                errorMessage.classList.add('hidden');
                // Proceed with form submission or any other action
            }
        });
</script>
@endsection
