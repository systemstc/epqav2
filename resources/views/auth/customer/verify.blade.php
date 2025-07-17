@extends('auth.master.master')

@section('content')
<!--     <form method="POST" action="{{ route('password.forgot') }}">
        @csrf
        <label for="otp">Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Send Password Reset Link</button>
    </form> -->

    <div class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md flex w-full max-w-3xl">
        <!-- Left Side (Image) -->
        <div class="w-1/2">
            <img src="{{ asset('image/customer-login.jpg') }}" alt="Login Image" class="w-full h-full object-cover rounded">
        </div>
        <!-- Right Side (Login Form) -->
        <div class="w-1/2 px-8">
            <h2 class="text-2xl font-bold mb-8">Verify OTP</h2>
<!--             <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
  <span class="font-medium">Success alert!</span> Change a few things up and try submitting again.
</div> -->
            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    {{ session('error') }}
                </div>
            @elseif(session('success'))
            	<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('customerverify') }}" method="POST">
                @csrf

				@php
				    $email = isset($email) ? $email : request()->query('email');
				@endphp
				
                <input type="hidden" name="email" value="{{$email}}">
                <div class="mb-4">
                    <label for="otp" class="block text-sm font-medium text-gray-700">OTP</label>
                    <input type="text" id="otp" name="otp" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm @error('otp') is-invalid @enderror" value="{{ old('otp') }}" autofocus>

                    @error('otp')
					    <div class="alert alert-danger">{{ $message }}</div>
					@enderror
					<a class="text-sm text-indigo" id="resendOtpButton" onclick="ResendOTP('{{$email}}')">Resend OTP</a>
					<p id="timer" style="display:none;">Please wait <span id="countdown"></span> seconds to resend OTP.</p>
                </div>
                <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Verify OTP</button>
             <!--    <a href="{{route('password.forgot')}}"><p class="block text-sm font-small text-gray-500 mt-4">Forgot Password ?</p></a>
                <a href="{{route('customerregister')}}"><p class="block text-sm font-small text-gray-500 mt-8 text-center">Creat an Account</p></a> -->
            </form>
        </div>
    </div>
</div>
@endsection

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>

<script type="text/javascript">
	
	function ResendOTP(email){
		// alert(email);
		// disableButtonWithTimer();
		// Set up the AJAX request with CSRF token
	    $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });

	    // Make the AJAX request
	    $.ajax({
	        url: "{{ url('resend-otp') }}",
	        data: {
	            'email': email
	        },
	        type: 'POST',
	        // dataType: 'json',
	        success: function(result) {
	        	if (result.status == "success") {
		        	disableButtonWithTimer();
	        	}else{
	        		$('#timer').css('display','block');
	        		$('#timer').text('An OTP has already been sent to your email. Please wait for a while to resend.');
	        	}
	            console.log("===== " + result + " =====");
	        },
	        error: function(xhr, status, error) {
	            console.log("Error: " + error);
	        }
	    });
	}

   	function disableButtonWithTimer() {
	    var button = document.getElementById('resendOtpButton');
	    var timerDisplay = document.getElementById('timer');
	    var countdownDisplay = document.getElementById('countdown');
	    var countdownTime = 120; // 2 minutes in seconds

	    button.disabled = true;
	    timerDisplay.style.display = 'block';

	    var countdownInterval = setInterval(function() {
	        countdownTime--;
	        countdownDisplay.textContent = countdownTime;

	        if (countdownTime <= 0) {
	            clearInterval(countdownInterval);
	            button.disabled = false;
	            timerDisplay.style.display = 'none';
	        }
	    }, 1000);
	}
</script>
