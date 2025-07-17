@extends('master.master')

@section('content')

<div class="breadcrumbs text-sm">
  <ul>
  	@foreach(Request::segments() as $segment)
	    <li><a href="{{$segment}}">{{$segment}}</a></li>
    @endforeach
  </ul>
</div>

<div class="container mx-auto p-4">
        <form id="mainForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        	@csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>            
            <div class="mb-4">
                <label for="officer" class="block text-sm font-medium text-gray-700">Officer Incharge</label>
                <input type="text" id="officer" name="officer" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('officer') is-invalid @enderror" value="{{ old('officer') }}" autofocus>
                @error('officer')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea type="text" id="address" name="address" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('address') is-invalid @enderror" value="{{ old('address') }}" autofocus></textarea>
                @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" id="phone" name="phone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('phone') is-invalid @enderror" value="{{ old('phone') }}" autofocus>
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>            
            <div class="mb-4">
                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                <input type="text" id="city" name="city" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('city') is-invalid @enderror" value="{{ old('city') }}" autofocus>
                @error('city')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                <input type="text" id="state" name="state" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('state') is-invalid @enderror" value="{{ old('state') }}" autofocus>
                @error('state')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="zip" class="block text-sm font-medium text-gray-700">ZIP Code</label>
                <input type="text" id="zip" name="zip" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('zip') is-invalid @enderror" value="{{ old('zip') }}" autofocus>
                @error('zip')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-span-2 justify-center">
            	<!-- onclick="my_modal_3.showModal()" -->
                <button type="submit" id="submitButton" class="w-28 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 text-center">
                    Save
                </button>
            </div>
        </form>
       <!-- Modal -->
<!-- You can open the modal using ID.showModal() method -->
<!-- <button class="btn" onclick="my_modal_3.showModal()">open modal</button> -->
<dialog id="my_modal_3" class="modal">
  <div class="modal-box p-10">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                      <div class="mb-4">
                    <label for="useremail" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="useremail" name="useremail" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('useremail') is-invalid @enderror" value="{{ old('useremail') }}" autofocus>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="userpassword" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="userpassword" name="userpassword" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Send Email</button>
                    <button type="button" class="w-full bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600" id="closeModal">Cancel</button>
                </div>
    </form>
  </div>
</dialog>
    </div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->

<script>
        $(document).ready(function () {
        	// alert('Request');
        	generatePassword();
	        function generatePassword() {
		      const length = 8;
		      const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=";
		      let password = "";
		      for (let i = 0; i < length; i++) {
		        const randomIndex = Math.floor(Math.random() * charset.length);
		        password += charset[randomIndex];
		      }
		        // alert($('#email').val());
		      $('#userpassword').val(password);
		      // $('#useremail').val($('#email').val());
		    }

    $('#mainForm').validate({
        rules: {
            name: {
                required: true,
                maxlength: 255,
            },
            email: {
                required: true,
                email: true,
                maxlength: 255,
            },
            officer: {
                required: true,
                maxlength: 255,
            },
            address: {
                required: true,
                maxlength: 255,
            },
            phone: {
                required: true,
                maxlength: 255,
            },
            city: {
                required: true,
                maxlength: 255,
            },
            state: {
                required: true,
                maxlength: 255,
            },
            zip: {
                required: true,
                maxlength: 255,
            },
            // Add more rules for other form fields
        },
        messages: {
            name: {
                required: "Please enter your name",
                maxlength: "Name must not exceed {0} characters",
            },
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address",
                maxlength: "Email must not exceed {0} characters",
            },
            officer: {
                required: "Please enter your officer incharge",
                maxlength: "Officer must not exceed {0} characters",
            },
            address: {
                required: "Please enter your address",
                maxlength: "address must not exceed {0} characters",
            },
            phone: {
                required: "Please enter your phone",
                maxlength: "phone must not exceed {0} characters",
            },
            city: {
                required: "Please enter your city",
                maxlength: "city must not exceed {0} characters",
            },
            state: {
                required: "Please enter your state",
                maxlength: "state must not exceed {0} characters",
            },
            zip: {
                required: "Please enter your zip",
                maxlength: "zip must not exceed {0} characters",
            },
            // Add more messages for other form fields
        },
        submitHandler: function(form) {
        	// alert($(form).attr('action'));
            $.ajax({
                type: 'POST',
                url: "{{url('/admin/add-regional-office')}}",
                data: $(form).serialize(),
                dataType: 'json',
                success: function(response) {
                	alert(response);
                	console.log(response);
                	$('#useremail').val($('#email').val());
                	my_modal_3.showModal();
                	// return;
                    // $('#formMessage').html('<div class="alert alert-success">'+ response.message +'</div>');
                    // Optionally clear form fields after successful submission
                    form.reset();
                },
                error: function(response,errors) {
                	alert(response);
                	alert(response.responseJSON.message);
                	console.log(response);
                    // var errors = response.responseJSON.errors;
                    // var errorHtml = '<div class="alert alert-danger"><ul>';
                    // $.each(errors, function(key, value) {
                    //     errorHtml += '<li>' + value[0] + '</li>';
                    // });
                    // errorHtml += '</ul></div>';
                    // $('#formMessage').html(errorHtml);
                }
            });
        }
    });
		});
    </script>