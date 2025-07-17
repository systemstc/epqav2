@include('auth.master.master')
<style>
	button:hover {
	  background-color: rgba(0, 0, 0, 1) !important;
	}	
	input:focus {
	  border-color: rgba(0, 0, 0, 0.8) !important;
	}
</style>

<div class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md flex w-full max-w-3xl">
        <!-- Left Side (Image) -->
        <div class="w-1/2">
            <img src="{{ asset('public/image/admin-login-1.jpg') }}" alt="Login Image" class="w-full h-full object-cover rounded">
        </div>
        <!-- Right Side (Login Form) -->
        <div class="w-1/2 px-8">
            <h2 class="text-2xl font-bold mb-8">Login</h2>
            @if (session('error'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
            <form action="{{ route('subadminlogin') }}" method="POST">
                @csrf
                <input type="hidden" name="user_type" value="sub-admin">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus>

                    @error('email')
					    <div class="alert alert-danger">{{ $message }}</div>
					@enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black-500 focus:border-black-500 sm:text-sm @error('password') is-invalid @enderror">

                    @error('password')
					    <div class="alert alert-danger">{{ $message }}</div>
					@enderror
                </div>
                <button type="submit" class="w-full text-white py-2 px-4 rounded" style="background-color: rgba(0, 0, 0, 0.8);">Login</button>
                <a href="#"><p class="block text-sm font-small text-gray-500 mt-4">Forgot Password ?</p></a>
                <!-- <a href="{{route('customerregister')}}"><p class="block text-sm font-small text-gray-500 mt-8 text-center">Creat an Account</p></a> -->
            </form>
        </div>
    </div>
</div>
