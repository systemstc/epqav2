@extends('master.master')

@section('title', 'Dashboard')

@section('content')

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Applications</h1>

    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

<!--     <div class="tabs mb-4">
        <a class="tab tab-lifted tab-active" id="tab-10" data-status="10">Pending</a>
        <a class="tab tab-lifted tab-active" id="tab-20" data-status="20">Approved</a>
        <a class="tab tab-lifted" id="tab-30" data-status="30">Query</a>
        <a class="tab tab-lifted" id="tab-40" data-status="40">Rejected</a>
    </div> -->

    <div role="tablist" class="tabs tabs-boxed max-w-md mt-5 mb-5">
      <a role="tab" class="tab tab-active" id="tab-10" data-status="10">Pending</a>
      <a role="tab" class="tab" id="tab-20" data-status="20">Approved</a>
      <a role="tab" class="tab" id="tab-30" data-status="30">Query</a>
      <a role="tab" class="tab" id="tab-40" data-status="40">Rejected</a>
      <!-- <a role="tab" class="tab" id="tab-0" data-status="0">ReApplied</a> -->
    </div>

    <div class="overflow-x-auto">
        <div class="flex items-center mb-4">
            <input type="text" id="search" placeholder="Search" class="input input-bordered w-full max-w-sm">
            <button class="btn btn-primary ml-4" id="export-btn">Export</button>
        </div>

        <table id="candidates-table" class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>IEC Code</th>
                    <th>Email</th>
                    <th>Note</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div id="pagination" class="btn-group mt-4"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            let status = 10;
            let currentPage = 1;
            let searchQuery = '';
            let url = '';

            // if (user_type == 'sub-admin') {
            //     url = 'getApplications'
            // }else if(user_type == 'admin'){
            //     url = 'getApplications'
            // }

            // console.log(url);
            // console.log(user_type);
            function fetchData() {
                $.ajax({
                    url: `getApplications/${status}?page=${currentPage}&search=${searchQuery}`,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        let rows = '';
                        data.data.forEach(function(candidate) {
                             let note = candidate.notes ? candidate.notes.note : 'No Note Available';
                        let collapseId = `collapse-${candidate.id}`;
                        let createdAtDate = new Date(candidate.created_at).toISOString().split('T')[0];
                        let updatedAtDate = new Date(candidate.updated_at).toISOString().split('T')[0];

                                    // Assuming the response contains `renewals` and `reapplied` arrays
                        let renewalsContent = '';
                        candidate.renewals.forEach(function(renewal) {
                            // console.log(renewal.applied_date);
                            // console.log(renewal.expired_date);
                            let applied_date = '';
                            let expired_date = '';
                            if (renewal.applied_date != '') {
                                applied_date = new Date(renewal.applied_date).toISOString().split('T')[0];
                            }
                            if(renewal.expired_date != ''){
                                expired_date = new Date(renewal.expired_date).toISOString().split('T')[0];
                            }
                            renewalsContent += `
                                <tr>
                                    <td>${applied_date}</td>
                                    <td>${expired_date}</td>
                                </tr>
                            `;
                        });

                        let reappliedContent = '';
                            candidate.previous_applications.forEach(function(reapply) {
                                let application_date = '';
                                let rejected_date = '';
                                if (reapply.created_at != '') {
                                    application_date = new Date(reapply.created_at).toISOString().split('T')[0];
                                }
                                if(reapply.updated_at != ''){
                                    rejected_date = new Date(reapply.updated_at).toISOString().split('T')[0];
                                }
                                    reappliedContent += `
                                    <tr>
                                        <td>${application_date}</td>
                                        <td>${rejected_date}</td>
                                    </tr>
                                `;
                            });

                        rows += `
                            <tr class="accordion-toggle cursor-pointer" data-target="#${collapseId}">
                                <td>${candidate.firm_name}</td>
                                <td>${candidate.ie_code}</td>
                                <td>${candidate.email}</td>
                                <td>${note}</td>
                                <td>${candidate.status}</td>
                                <td>
                                    <a href="{{url('admin/viewApplications/${candidate.encrypted_id}')}}" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                            <tr id="${collapseId}" class="collapse hidden">
                                <td>
                                    <div class="p-4 bg-gray-100">
                                        <p><strong>Additional Info:</strong> 
                                            <td>
                                                <p>Applied on</p>
                                                <br>
                                                ${createdAtDate}
                                            </td>
                                            <td>
                                                <p><strong>Reapplied:</strong></p>
                                                <table>
                                                    <tr>
                                                        <th>Applied On</th>
                                                        <th>Rejected On</th>
                                                    </tr>
                                                    ${reappliedContent}
                                                </table>
                                            </td>
                                            <td>
                                                <p><strong>Renewals:</strong></p>
                                                <table>
                                                    <tr>
                                                        <th>Renewed On</th>
                                                        <th>Expire On</th>
                                                    </tr>
                                                    ${renewalsContent}
                                                </table>
                                                
                                            </td>
                                            <td>
                                                <p>Action on</p>
                                                    <br>
                                                ${createdAtDate}
                                            </td>
                                            <td>
                                                <p>Status</p>
                                                <br>
                                                ${createdAtDate}
                                            </td>
                                        </p>
                                        <!-- Add more detailed information here -->
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                    $('#candidates-table tbody').html(rows);

                    // Attach click event to toggle accordion
                    $('#candidates-table tbody').on('click', '.accordion-toggle', function() {
                         $('#candidates-table tbody tr[id^="collapse-"]').removeClass('collapse hidden');
                         $('#candidates-table tbody tr[id^="collapse-"]').addClass('collapse hidden');
                        let targetId = $(this).data('target');
                        // console.log(targetId);
                        $(targetId).toggleClass('collapse');
                        $(targetId).toggleClass('hidden');
                    });

                        // Handle pagination
                        let pagination = '';
                        if (data.last_page > 1) {
                            pagination += `<button class="btn ${currentPage === 1 ? 'btn-disabled' : ''}" data-page="${1}">&laquo; First</button>`;
                            pagination += `<button class="btn ${currentPage === 1 ? 'btn-disabled' : ''}" data-page="${data.prev_page_url ? data.prev_page : 1}">&lsaquo; Previous</button>`;
                            for (let i = 1; i <= data.last_page; i++) {
                                pagination += `<button class="btn ${i === data.current_page ? 'btn-active' : ''}" data-page="${i}">${i}</button>`;
                            }
                            pagination += `<button class="btn ${currentPage === data.last_page ? 'btn-disabled' : ''}" data-page="${data.next_page_url ? data.next_page : data.last_page}">Next &rsaquo;</button>`;
                            pagination += `<button class="btn ${currentPage === data.last_page ? 'btn-disabled' : ''}" data-page="${data.last_page}">Last &raquo;</button>`;
                        }
                        $('#pagination').html(pagination);

                        // Attach event to pagination buttons
                        $('#pagination button').click(function() {
                            const page = $(this).data('page');
                            if (page && page !== currentPage) {
                                currentPage = page;
                                fetchData();
                            }
                        });
                    }
                });
            }

            fetchData();

            $('.tab').click(function() {
                $('.tab').removeClass('tab-active');
                $(this).addClass('tab-active');
                status = $(this).data('status');
                currentPage = 1;
                fetchData();
            });

            $('#search').on('input', function() {
                searchQuery = $(this).val();
                currentPage = 1;
                fetchData();
            });

            $('#export-btn').click(function() {
                window.location.href = `/export/${status}`;
            });
        });
    </script>
</div>

@endsection
