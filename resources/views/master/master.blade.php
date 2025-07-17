<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>
        <!-- Fonts -->
    <!--     <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> -->
        @vite('resources/css/app.css')
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"> -->

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">

            <!-- <link rel="stylesheet" href="./scss/app.scss" /> -->
    </head>
    <!-- Include this CSS to style the active link -->
<style>
    .menu a.active {
        color: #4A5568; /* Change this color to match your design */
        font-weight: bold;
    }
</style>
    <body>
        <div class="flex h-screen">

            @include('master.sidemenu')
        <!-- Content -->
        <div class="flex-1 flex flex-col">
            @include('master.header')

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')

                <!-- Open the modal using ID.showModal() method -->
                <!-- <button class="btn" onclick="my_modal_1.showModal()">open modal</button> -->
                <dialog id="my_modal_1" class="modal">
                  <div class="modal-box w-11/12 max-w-5xl">
                    <form method="dialog">
                      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <!-- <h3 class="text-lg font-bold">Hello!</h3> -->
                    <!-- <p class="py-4">Press ESC key or click the button below to close</p> -->
                    <!-- <div class="modal-action"> -->
                      <!-- <form method="dialog"> -->

                            <table id="search-table" class="table table-zebra w-full">
                              <thead>
                                  <tr>
                                      <th>Firm Name</th>
                                      <th>Email</th>
                                      <th>Mobile</th>
                                      <th>IE Code</th>
                                      <th>Registration Number</th>
                                      <th>Applied Date</th>
                                      <th>Issue Date</th>
                                      <th>Expired Date</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                        <!-- if there is a button in form, it will close the modal -->
                        <!-- <button class="btn">Close</button> -->
                 <!--      </form>
                    </div> -->
                  </div>
                </dialog>
            </main>
            </div>
        </div>



   		@vite('resources/js/app.js')
        <!-- ✅ FIRST - load jquery ✅ -->
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous">
    </script>

    <!-- ✅ SECOND - load jquery validate ✅ -->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer">
    </script>

    <!-- ✅ THIRD - load additional methods ✅ -->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"
      integrity="sha512-XZEy8UQ9rngkxQVugAdOuBRDmJ5N4vCuNXCh8KlniZgDKTvf7zl75QBtaVG1lEhMFe2a2DuA22nZYY+qsI2/xA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
<!-- jQuery -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!--     <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/jquery.dataTables.min.js" type="text/javascript"></script> -->
    </body>
</html>


<script>
// $(document).ready(function() {
<?php if(Auth::user()->user_type != 'customer') {?>
      var table = $('#search-table').DataTable({
          processing: true,
          serverSide: true,
          // searching: false,
          // paging: false,
          ajax: {
              url: '{{ route("search.results") }}',
              data: function(d) {
                  d.search = $('#header-search').val();
              }
          },
          columns: [
              { data: 'firm_name' },
              { data: 'email' },
              { data: 'telephone' },
              { data: 'ie_code' },
              { data: 'registration_no' },
              { data: 'applied_date' },
              { data: 'issue_date' },
              { data: 'expired_date' }
          ]
      });
    $('#header-search-btn').on('click', function() {
        table.draw();
        my_modal_1.showModal();
    });
  <?php } ?>
// });
</script>






