
<!-- Include this CSS to style the active link -->
<!-- <style>
    .menu a.active {
        color: primary; /* Change this color to match your design */
        font-weight: bold;
    }
</style> -->
<!-- Sidebar -->
<div class="w-64 bg-white sidebar shadow-md hidden sm:block">
        <a href="{{url('customer/dashboard')}}">
       <div class="flex items-center justify-left pt-2 p-6 pb-2">
            <img src="{{ asset('public/image/textiles_logo_200.png') }}" alt="Textiles Logo" style="width: 50px; height: auto; margin-right: 10px;">
            <h1 class="text-xl font-bold" style="color: #4A5568;">EPQA {{ Session::get('rotc') }}</h1>
        </div>
        </a>
    <div class="p-4">
<!--         <img src="{{asset('public/image/textiles_logo_200.png')}}">
        <h1 class="text-xl font-bold">EPQA {{Session::get('rotc')}}</h1> -->
        <ul class="menu w-56">
            <li><a class="active hover:text-gray-900" href="{{url('customer/dashboard')}}">Dashboard</a></li>
            @if(Auth::user()->user_type == 'customer')
            @if(Session::get('application_status') == '40' || Session::get('application_status') == '')
                <li><a class="hover:text-gray-900" href="{{url('customer/firm/create')}}">Register</a></li>
            @endif
                <li><a class="hover:text-gray-900">Renewal</a></li>
                <li><a class="hover:text-gray-900">Rex</a></li>
            @endif
            <li><a class="hover:text-gray-900">Report</a></li>
            <li><a class="hover:text-gray-900">Services</a></li>
            @if(Auth::user()->user_type == 'admin')
                <li><a class="hover:text-gray-900" href="{{url('admin/regional-office')}}">Regional Office</a></li>
            @endif
        </ul>
    </div>
</div>

<!-- JavaScript to handle the active state -->
<script>
    // Select all menu links
    const menuLinks = document.querySelectorAll('.sidebar .menu a');

    // Add click event listener to each link
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Remove active class from all links
            menuLinks.forEach(link => link.classList.remove('active'));
            // Add active class to the clicked link
            this.classList.add('active');
        });
    });

    // Set active class based on the current URL
    const currentUrl = window.location.href;
    menuLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');
        }
    });
</script>


