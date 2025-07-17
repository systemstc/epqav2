@include('auth.master.master')
<div class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md flex w-full max-w-3xl">
        <!-- Left Side (Image) -->
        <div class="w-1/2">
            <img src="{{ asset('public/image/admin-login.jpg') }}" alt="Login Image" class="w-full h-full object-cover rounded">
        </div>
        <!-- Right Side (Login Form) -->
        <div class="w-1/2 px-8">
            <h2 class="text-2xl font-bold mb-8">Login</h2>
                @if (session('error'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
            <form action="{{ route('adminlogin') }}" method="POST">
                @csrf
                <input type="hidden" name="user_type" value="admin">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus>

                    @error('email')
					    <div class="alert alert-danger">{{ $message }}</div>
					@enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') is-invalid @enderror">

                    @error('password')
					    <div class="alert alert-danger">{{ $message }}</div>
					@enderror
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Login</button>
                <a href="{{route('password.forgot')}}"><p class="block text-sm font-small text-gray-500 mt-4">Forgot Password ?</p></a>
                <!-- <a href="{{route('customerregister')}}"><p class="block text-sm font-small text-gray-500 mt-8 text-center">Creat an Account</p></a> -->
            </form>
        </div>
    </div>
</div>
