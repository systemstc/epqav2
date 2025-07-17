@extends('master.master')


@section('title', 'Dashboard')

@section('content')
   <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" /> -->
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
<link rel="stylesheet" href="https://unpkg.com/leaflet-heat/dist/leaflet-heat.css" />


<div class="container">
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
        <!-- Product Views  -->
        <a href="{{ route('subadminapplications') }}">
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
        <a href="{{ route('subadminapplications') }}">
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
        <a href="{{ route('subadminapplications') }}">
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
      <h2 class="mt-4">Map's of Registration </h2>
      <div id="statemap"></div>
      <!-- <div class="mt-6" id="regions_div" style="width: 900px; height: 500px;"></div> -->
      <!-- <div id="map" style="height: 400px; width: 100%;"></div> -->

<!--           <div id="floating-panel">
      <button id="toggle-heatmap">Toggle Heatmap</button>
      <button id="change-gradient">Change gradient</button>
      <button id="change-radius">Change radius</button>
      <button id="change-opacity">Change opacity</button>
    </div>
    <div id="map"></div> -->
      <!-- <div class="mt-6" id="regions_div" style="width: 900px; height: 500px;"></div> -->
      <!-- <div class="px-10 pt-10"> -->
        <!-- <div id="container"></div> -->
      <!-- </div> -->


              <!-- chart start-->
              <!-- <div id="donut-chart"></div> -->
              <!-- chart end-->

</div>
@endsection


<!-- <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqE8obyq_wNf11YKtR2SDZgoF6Uf7y0Eo&loading=sync&libraries=visualization&callback=initMap">
</script> -->


<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->

<!-- <script type="text/javascript" src="http://yoursite.com/mapdata.js"></script>   
<script  type="text/javascript" src="http://yoursite.com/worldmap.js"></script> -->

<!-- <script type="module">
    // import ApexCharts from 'apexcharts';
    // const options = {
    //     // ...... 
    // };
    const chart = new ApexCharts(document.querySelector("#donut-chart"), options);
    chart.render();
</script> -->

<!-- 
<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqE8obyq_wNf11YKtR2SDZgoF6Uf7y0Eo&libraries=visualization&callback=initMap">
</script> -->

<!-- <script type="text/javascript">
let map, heatmap;

function initMap() {
    var lat = 19.0760;
    var lng = 72.8777;

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 13,
        center: { lat: lat, lng: lng },
        mapTypeId: "satellite",
    });

    heatmap = new google.maps.visualization.HeatmapLayer({
        data: getPoints(),
        map: map,
    });
}

function getPoints() {
    return [
        // Replace these with points in Maharashtra
        new google.maps.LatLng(19.7515, 75.7139), // Example: Center of Maharashtra
        new google.maps.LatLng(18.5204, 73.8567), // Example: Pune
        new google.maps.LatLng(19.0760, 72.8777), // Example: Mumbai
        // Add more points as necessary
    ];
}
</script> -->

<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {
    'packages': ['geochart'],
  });
  google.charts.setOnLoadCallback(drawRegionsMap);

  function drawRegionsMap() {
    var data = google.visualization.arrayToDataTable([
      // ['Country', 'Popularity'],
      // ['Maharashtra', 2196],
      // ['Delhi', 6854],
      // ['Belgaum', 13415],
      // ['Dharwad', 4260],
      // ['Udupi', 3880]

        ['City', 'Value'],
        ['Mumbai' ,21000],
        ['Pune' ,221000],
        ['Nagpur' ,2211000],
        // ['Bangalore Urban', 2196],
        // ['Mysore', 6854],
        // ['Belgaum', 13415],
        // ['Dharwad', 4260],
        // ['Udupi', 3880]

    ]);

    var options = {
      region: 'IN', // Country code (e.g., 'US' for the United States)
      displayMode: 'regions', // Display mode for regions (states/provinces)
      resolution: 'provinces', // Set to 'provinces' to show states
      colorAxis: {colors: ['#e0f7fa', '#00796b']} // Optional: Customize the color scale
    };

    var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

    chart.draw(data, options);
  }
</script> -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="{{ asset('leaflet-heat.js') }}"></script>
<!-- <script src="https://unpkg.com/leaflet-heat/dist/leaflet-heat.js"></script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create a map centered around Maharashtra
            var map = L.map('statemap', { scrollWheelZoom: false }).setView([<?= json_encode($data['ros_lat']) ?>, <?= json_encode($data['ros_lng']) ?>], 9); // Approximate center of Maharashtra

            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // City data for Maharashtra
            // var cities = [
            //     { name: 'Mumbai', lat: 19.0760, lon: 72.8777, intensity: 5 },
            //     { name: 'Pune', lat: 18.5204, lon: 73.8567, intensity: 4 },
            //     { name: 'Nagpur', lat: 21.1458, lon: 79.0882, intensity: 3 },
            //     { name: 'Aurangabad', lat: 19.8762, lon: 75.3433, intensity: 2 },
            //     { name: 'Nashik', lat: 20.0117, lon: 73.7903, intensity: 1 }
            // ];

            // // // Add markers for each city
            // cities.forEach(function(city) {
            //     L.marker([city.lat, city.lon])
            //         .addTo(map)
            //         .bindPopup(`<b>${city.name}</b>`)
            //         .openPopup();
            // });

            // console.log(L.heatLayer);
            // console.log(L.marker);
            var cities = <?= $data['latLng'] ?>;
            console.log(cities);

            // Filter out null values
            var validCities = cities.filter(function(city) {
                return city !== null;
            });
            console.log(validCities);

            // // Convert city data to heatmap format
            // var heatmapData = validCities.map(function(city) {
            //     return [parseFloat(city.lat), parseFloat(city.lon), 1]; // Assuming intensity as 1 for this example
            // });

            // Convert city data to heatmap format
            var heatmapData = validCities.map(function(city) {
                return [city.lat, city.lon];
            });

            // Check if leaflet-heat script is loaded
            if (L.heatLayer) {
                // Add heatmap layer
                L.heatLayer(heatmapData, { radius: 25, blur: 15, maxZoom: 10 }).addTo(map);
            } else {
                console.error("L.heatLayer is not a function. Ensure leaflet-heat plugin is loaded.");
            }
            // Maharashtra GeoJSON data (simplified example)
            var maharashtraBorder = {
                "type": "Feature",
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [[
                        [73.0000, 18.4660], [73.0000, 20.1100], [75.0000, 20.1100],
                        [75.0000, 18.4660], [73.0000, 18.4660]
                    ]]
                },
                "properties": {
                    "name": "Maharashtra"
                }
            };


            // // Add border for Maharashtra
            // L.geoJSON(maharashtraBorder, {
            //     style: function (feature) {
            //         return { color: '#FF5733', weight: 3 }; // Border color and thickness
            //     }
            // }).addTo(map);

            // Optionally, adjust the map view based on the cities data
            // if (validCities.length > 0) {
                var bounds = L.latLngBounds(<?= json_encode($data['ros_lat']) ?>, <?= json_encode($data['ros_lng']) ?>);
                map.fitBounds(bounds);
            // }
        });
    </script>


