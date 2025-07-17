@extends('master.master')


@section('title', 'Dashboard')

@section('content')
{{-- @for($i=0 ; $i<=10 ;$i++) --}}
<div class="container">
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
    <h1 class="text-2xl font-bold">Welcome to the Dashboard</h1>
    <p class="mt-4">This is your dashboard where you can manage your activities.</p>
    <br>

<!--     <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold">Card 1</h2>
            <p class="mt-2 text-gray-600">Content for card 1 goes here.</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold">Card 2</h2>
            <p class="mt-2 text-gray-600">Content for card 2 goes here.</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold">Card 3</h2>
            <p class="mt-2 text-gray-600">Content for card 3 goes here.</p>
        </div>
    </div> -->

    <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <!-- Status Views  -->
                @if(Auth::user()->user_type == 'customer')
                  @if(Session::get('application_status') != '')
                    <a href="{{route('customerviewapplication', ['id' => encrypt(Auth::user()->id)])}}">
                  @endif
                  <div class="card shadow-xl {{ 
                        isset($application) && $application->status == 10 ? 'bg-indigo-200' : (
                        isset($application) && $application->status == 20 ? 'bg-green-200' : (
                        isset($application) && $application->status == 30 ? 'bg-yellow-200' : (
                        isset($application) && $application->status == 40 ? 'bg-red-200' : ''))) 
                    }}">
                    <div class="card-body flex items-center gap-4">
                      <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary bg-opacity-20 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box text-3xl"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                      </div>
                      <div class="flex flex-1 flex-col gap-1">
                        <p class="text-sm tracking-wide text-slate-500">Application Status</p>
                        <div class="flex flex-wrap items-center justify-center gap-2">
                          @if($application != '')
                            <h4 class="">{{$application_status}}</h4>
                          @else
                            <h4 class="">--</h4>
                          @endif
                          <!-- <span class="flex items-center text-xs font-medium text-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3px" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-right h-3 w-3"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>2.2%</span> -->
                        </div>
                      </div>
                    </div>
                  </div>
                  @if(Session::get('application_status') != '')
                    </a>
                  @endif
                  <!-- Expiry Sold  -->
                  @if(Session::get('application_status') != '')
                    <a href="{{route('customereditapplication', ['id' => encrypt(Auth::user()->id)])}}">
                  @endif
                  <div class="card shadow-xl {{ isset($application) && $is_Expired ? 'bg-red-200' : (isset($application) && $is_Expired == false ? 'bg-success bg-opacity-20' : '')}}">
                    <div class="card-body flex items-center gap-4">
                      <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-[#ff38ad] bg-opacity-20 text-[#ff38ad]">
                        <i class="bx bx-dollar-circle text-3xl"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>

                      </div>
                      <div class="flex flex-1 flex-col gap-1 items-center justify-center">
                        <p class="text-sm tracking-wide text-[#ff385b]">Expire Status</p>
                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                          @if($application_expiry != '')
                            <h4 class="text-slate-500">{{$application_expiry}}</h4>
                          @else
                            <h4 class="text-slate-500">--</h4>
                          @endif
                          <!-- <span class="flex items-center text-xs font-medium text-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3px" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down-left h-3 w-3"><line x1="17" y1="7" x2="7" y2="17"></line><polyline points="17 17 7 17 7 7"></polyline></svg> 0.5%</span> -->
                        </div>
                      </div>
                    </div>
                  </div>
                  @if(Session::get('application_status') != '')
                    </a>
                  @endif
                  <!-- Rex  -->
                  <div class="card shadow-xl">
                    <div class="card-body flex items-center gap-4">
                      <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-warning bg-opacity-20 text-warning">
                        <i class="ti ti-thumb-up text-3xl"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>

                      </div>
                      <div class="flex flex-1 flex-col gap-1 items-center justify-center">
                        <p class="text-sm tracking-wide text-slate-500">Rex</p>
                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                          <h4>46,256</h4>
                          <span class="flex items-center text-xs font-medium text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3px" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-right h-3 w-3"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg> 1.2%</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Conversation Rate  -->
                  @if(Session::get('application_status') != '')
                    <a href="{{route('customerviewapplication', ['id' => encrypt(Auth::user()->id)])}}">
                  @endif
                  <div class="card shadow-xl">
                    <div class="card-body flex items-center gap-4">
                      <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-info bg-opacity-20 text-info">
                        <i class="ti ti-message-2-cog text-3xl"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                      </svg>

                      </div>
                      <div class="flex flex-1 flex-col gap-1 items-center justify-center">
                        <p class="text-sm tracking-wide text-slate-500">Queris</p>
                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                          <h4>1</h4>
                          <!-- <span class="flex items-center text-xs font-medium text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3px" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-right h-3 w-3"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg> 3.2%</span> -->
                        </div>
                      </div>
                    </div>
                  </div>
                  @if(Session::get('application_status') != '')
                    </a>
                  @endif                  
                @endif
              </section>


              <!-- chart start-->
              <div id="donut-chart"></div>
              <!-- chart end-->
</div>
{{-- @endfor --}}
@endsection

<script type="module">
    // import ApexCharts from 'apexcharts';
    // const options = {
    //     // ...... 
    // };
    // const chart = new ApexCharts(document.querySelector("#donut-chart"), options);
    // chart.render();

        // Set a timeout to remove alert after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';  // Fade out effect

            // Remove alert from DOM after fade out
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000); // Adjust time as needed (5000 ms = 5 seconds)
</script>
