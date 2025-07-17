@extends('master.master')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<style type="text/css">
    #statemap {
        height: 50vh;
        width: 50%;
       /*pointer-events: none;*/
    }
  #container {
    margin-top: 50px;
    height: 500px;
    min-width: 310px;
    max-width: 800px;
    left: 0;
    /*margin: 0 auto;*/
}

.loading {
    margin-top: 10em;
    text-align: center;
    color: gray;
}

.leaflet-container {
            pointer-events: all; /* Re-enable interactions for the map container */
        }

</style>

<div class="container">
    <h1 class="text-2xl font-bold">Welcome to the Dashboard</h1>
    <p class="mt-4">This is your dashboard where you can manage your activities.</p>
    <br>
    <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
        <!-- Product Views  -->
        <a href="{{ route('adminapplications') }}">
          <div class="card shadow-xl">
            <div class="card-body flex items-center justify-center gap-4">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-warning bg-opacity-20 text-warning">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box text-3xl"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg> -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>

              </div>
              <div class="flex flex-1 flex-col gap-1 items-center">
                <p class="text-sm tracking-wide text-slate-500">Pending Applications</p>
                <div class="flex flex-wrap items-baseline justify-between gap-2">
                  <h4 class="justify-center">{{$data['pending']}}</h4>
                  <!-- <span class="flex items-center text-xs font-medium text-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3px" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-right h-3 w-3"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>2.2%</span> -->
                </div>
              </div>
            </div>
          </div>                 
        </a>        
        <a href="{{ route('adminapplications') }}">
          <div class="card shadow-xl">
            <div class="card-body flex items-center justify-center gap-4">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-success bg-opacity-20 text-success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" width="24" height="24">
                <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

              </div>
              <div class="flex flex-1 flex-col gap-1 items-center">
                <p class="text-sm tracking-wide text-slate-500">Approved Applications</p>
                <div class="flex flex-wrap items-baseline justify-between gap-2">
                  <h4 class="justify-center">{{$data['approved']}}</h4>
                  <!-- <span class="flex items-center text-xs font-medium text-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3px" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-right h-3 w-3"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>2.2%</span> -->
                </div>
              </div>
            </div>
          </div>                 
        </a>        
        <a href="{{ route('adminapplications') }}">
          <div class="card shadow-xl">
            <div class="card-body flex items-center justify-center gap-4">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary bg-opacity-20 text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>

              </div>
              <div class="flex flex-1 flex-col gap-1 items-center">
                <p class="text-sm tracking-wide text-slate-500">Total Applications</p>
                <div class="flex flex-wrap items-baseline justify-between gap-2">
                  <h4 class="justify-center">{{$data['total']}}</h4>
                  <!-- <span class="flex items-center text-xs font-medium text-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3px" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-right h-3 w-3"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>2.2%</span> -->
                </div>
              </div>
            </div>
          </div>                 
        </a>
      </section>
    <br>
	<p class="mt-4">Map's </p>
  	<div class="mt-6" id="regions_div" style="width: 50%; height: 50vh;"></div>
</div>
@endsection


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {
    'packages': ['geochart'],
  });
  google.charts.setOnLoadCallback(drawRegionsMap);

  var states = <?= $data['states'] ?>;
  console.log(states);

  function drawRegionsMap() {
    // var data = google.visualization.arrayToDataTable([
      
      var dataArray = [['State', 'Value']];
      states.forEach(function(row) {
      	dataArray.push([row.state, row.state_count]);
      });
      // ['Maharashtra', 2196],
      // ['Delhi', 6854],
      // ['Gujrat', 13415],
      // ['Goa', 4260],
      // ['Uttar Pradesh', 3880]
    // ]);
    var data = google.visualization.arrayToDataTable(dataArray);

    var options = {
      region: 'IN', // Country code (e.g., 'US' for the United States)
      displayMode: 'regions', // Display mode for regions (states/provinces)
      resolution: 'provinces', // Set to 'provinces' to show states
      colorAxis: {colors: ['#e0f7fa', '#00796b']} // Optional: Customize the color scale
    };

    var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

    chart.draw(data, options);
  }
</script>