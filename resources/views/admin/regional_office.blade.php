@extends('master.master')

@section('content')
<h1 class="text-2xl">Regional Offices </h1> <a type="button" href="{{url('admin/add-regional-office')}}">Add</a>
<!-- <div class="breadcrumbs text-sm">
  <ul>
  	@foreach(Request::segments() as $segment)
	    <li><a href="{{$segment}}">{{$segment}}</a></li>
    @endforeach
  </ul>
</div> -->

<div class="container mx-auto mt-5">
<h2 class="text-2xl font-bold mb-5">Laravel DataTables with Tailwind CSS and DaisyUI</h2>
    <ul class="tabs">
        <li class="tab tab-bordered tab-active">
            <a class="nav-link active" data-toggle="tab" href="#active" data-status="active">Active</a>
        </li>
        <li class="tab tab-bordered">
            <a class="nav-link" data-toggle="tab" href="#inactive" data-status="inactive">Inactive</a>
        </li>
    </ul>

<div class="tab-content mt-5">
    <div id="active" class="tab-pane fade show active">
		<table id="example" class="table table-auto min-w-full bg-white shadow-md rounded-lg overflow-hidden table-zebra">
		    <thead class="bg-gray-200">
		        <tr>
			    <th>Sr No</th>
		        <th>Branch Name</th>
		        <th>Officer Incharge</th>
		        <th>Email</th>
		        <th>Address</th>
		        <th>State</th>
		      </tr>
		  </thead>
		</table>
	</div>
</div>

<div class="tab-content mt-5">
    <div id="inactive" class="tab-pane fade">
		<table id="example" class="table table-auto min-w-full bg-white shadow-md rounded-lg overflow-hidden table-zebra">
		    <thead class="bg-gray-200">
		        <tr>
			    <th>Sr No</th>
		        <th>Branch Name</th>
		        <th>Officer Incharge</th>
		        <th>Email</th>
		        <th>Address</th>
		        <th>State</th>
		      </tr>
		  </thead>
		</table>
	</div>
</div>
</div>





@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
	// alert('test');
	// alert('test');
    // $('#example').DataTable();

    function loadTable(status) {
    	// alert('test 1');
    	// alert(status);
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "{{ url('/admin/regional-office-lazy') }}",
            	type: 'POST',
                data: { status: status, "_token": "{{ csrf_token() }}", }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'officer_incharge', name: 'officer_incharge'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'state', name: 'state'}
            ],
            // pageLength: 15
            pageLength: 15,
            // dom: '<"flex items-center justify-between"<"flex items-center space-x-2"l<"ml-2"f>>t<"flex items-center justify-between"<"info"i>p>',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
                paginate: {
                    previous: "&lt;",
                    next: "&gt;"
                }
            }
        });
    }

    // Load the active users table by default
    loadTable('active');

    // $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    //     var status = $(e.target).data('status');
    //     loadTable(status);
    // });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var status = $(e.target).data('status');
        loadTable(status);
    });

});
</script>
