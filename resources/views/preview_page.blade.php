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
    <h1 class="text-2xl font-bold mb-4">Application</h1>

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

 <h1 class="text-xl font-bold mb-4">Review and Confirm Information</h1>
        
        <form action="{{ route('firms.previewstore') }}" method="POST">
            @csrf
            <div class="row">
            	<input type="hidden" name="firm_id" value="{{$firm['id']}}">
            	<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            		<div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Regional Office:</label>
		                @foreach($rotc as $value)
		                	@if($value['id'] == $firm['subadmin_selected'])
				                <p class="p-2 bg-gray-100 rounded">{{ $value['rotc'] }}</p>
			                @endif
		                @endforeach
		                <!-- <p class="p-2 bg-gray-100 rounded">{{ $firm['subadmin_selected'] }}</p> -->
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Firm Name:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $firm['firm_name'] }}</p>
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Category of Exporters:</label>
		                @if($firm['category_of_export'] == '0')
			                <p class="p-2 bg-gray-100 rounded">Merchant Exporter</p>
			            @elseif($firm['category_of_export'] == '1')
				            <p class="p-2 bg-gray-100 rounded">Manufacturer Exporter</p>
						@elseif($firm['category_of_export'] == '2')
				            <p class="p-2 bg-gray-100 rounded">Manufacturer cum Merchant Exporter</p>
			            @endif
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">IEC Number:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $firm['ie_code'] }}</p>
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">GSTIN Number:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $firm['gstin_number'] }}</p>
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Date of Birth / Incorporation:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $firm['dob'] }}</p>
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Principal Commodities for Export:</label>
		                <!-- <p class="p-2 bg-gray-100 rounded">{{ $firm['category_of_export'] }}</p> -->
		                @if($firm['category_of_export'] == '0')
			                <p class="p-2 bg-gray-100 rounded">Textiles</p>
			            @else
				            <p class="p-2 bg-gray-100 rounded">Textiles and Other</p>
			            @endif
						
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Address Line 1:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $firm['address'] }}</p>
		            </div>            

            	</div>
            	<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Address Line 2:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $firm['address_2'] }}</p>
		            </div>         
	            		 <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">State:</label>
		                @foreach($state as $value)
		               	 	@if($value['id'] == $firm['state'])
			                	<p class="p-2 bg-gray-100 rounded">{{$value['state'] }}</p>
			                @endif
		                @endforeach
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">District:</label>
		                @foreach($district as $value)
			                @if($value['id'] == $firm['district'])
					            <p class="p-2 bg-gray-100 rounded">{{ $value['district'] }}</p>
					        @endif
		                @endforeach
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">City:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $firm['city'] }}</p>
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Pincode:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $firm['pincode'] }}</p>
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Mobile:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $firm['telephone'] }}</p>
		            </div>            

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Email:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $firm['email'] }}</p>
		            </div>

		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Is SEZ:</label>
		                @if($firm['is_sez'] == 'on')
			                <p class="p-2 bg-gray-100 rounded">Yes</p>
			            @else
			                <p class="p-2 bg-gray-100 rounded">No</p>
			            @endif
		            </div>
            	</div>


               

           

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">ICE Certificate:</label>
                <img src="{{asset('public/storage/certificate/'.$firm['iec_path'])}}">
                <!-- <p class="p-2 bg-gray-100 rounded">{{ $firm['iec_path'] }}</p> -->
            </div>

        	<h1 class="text-xl font-bold mb-4">Company Branch Details</h1>
			 @foreach($data as $key => $value)
			 <h2 class="text-xl font-bold mb-4">Branch {{$key}}</h2>
	        	<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Branch Sr.No:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $key + 1 }}</p>
		            </div>
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Branch GSTIN:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $value['gstin'] }}</p>
		            </div>
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Branch Address:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $value['address'] }}</p>
		            </div>
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Branch If Manufacturing Unit:</label>
		                @if($value['if_manufacturing_unit'] == 'on')
			                <p class="p-2 bg-gray-100 rounded">Yes</p>
			            @else
			                <p class="p-2 bg-gray-100 rounded">No</p>
			            @endif
		                <!-- <p class="p-2 bg-gray-100 rounded">{{ $value['if_manufacturing_unit'] }}</p> -->
		            </div>         
		        </div>  
		    @endforeach      	


	        <h1 class="text-xl font-bold mb-4">Company Proprietor/Partner/Director(s) Details</h1>
	        @foreach($directorData as $key => $value)
	        <h2 class="text-xl font-bold mb-4">Director {{$key}}</h2>
	        	<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Name:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $value['name'] }}</p>
		            </div>
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Designation:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $value['designation'] }}</p>
		            </div>
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">PAN Number:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $value['pan'] }}</p>
		            </div>
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">email:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $value['email'] }}</p>
		            </div>
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Mobile:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $value['mobile'] }}</p>
		            </div> 	            
		            <div class="mb-4">
		                <label class="block text-gray-700 font-medium mb-2">Address:</label>
		                <p class="p-2 bg-gray-100 rounded">{{ $value['address'] }}</p>
		            </div>         
		        </div>
	        @endforEACH


            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" id="confirm_correct" name="confirm_correct" value="1" class="checkbox checkbox-primary mr-2">
                    <span class="text-gray-700">I confirm the information above is correct.</span>
                </label>
                @error('confirm_correct')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button id="submit-btn" type="submit" class="btn btn-primary w-32">
                    Submit
                </button>
            </div>
            <div id="error-message" class="mt-4 text-red-500 hidden flex justify-end">You must agree to the confirm the information to proceed.</div>
        </form>
    </div>
<script type="text/javascript">
	        document.getElementById('submit-btn').addEventListener('click', function(event) {
            var checkbox = document.getElementById('confirm_correct');
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

