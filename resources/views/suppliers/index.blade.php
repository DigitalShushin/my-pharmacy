@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!--datatable css-->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

    <style>
        .swal2-container .swal2-title {
            padding-left: 100px;
        }

        .custom-html {
            padding-left: 100px;
            padding-bottom: 20px;
        }
        .word-wrap {
            white-space: normal !important;
            word-break: break-word;
            max-width: 250px; /* Optional: Limit cell width */
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Supplier List
                        <a href="{{ route('suppliers.create') }}" class="btn btn-info add-btn float-right" style="float: right;"><i class="ri-add-fill me-1 align-bottom"></i> Add New</a></h5>
                    
                    <!-- <a class="addCompanyBtn btn btn-info add-btn" href="javascript:void(0);" data-bs-toggle="modal"><i class="ri-add-fill me-1 align-bottom text-muted"></i> Add New</a> -->
                </div>
                <div class="card-body">
                    <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th class="sort" data-sort="supplier_name" scope="col">Supplier Name</th>
                                <th class="sort" data-sort="contact_person" scope="col">Contact Person</th>
                                <th class="sort" data-sort="phone" scope="col">Phone No</th>
                                <th class="sort" data-sort="email_id" scope="col">Email ID</th>
                                <th class="sort" data-sort="address" scope="col">Address</th>
                                <th class="sort" data-sort="companies_array" scope="col">Companies Array</th>
                                <th class="sort" data-sort="pan" scope="col">Pan Number</th>
                                <th class="sort" data-sort="dda" scope="col">DDA Registration Number</th>
                        <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sn = 0; ?>
                            @foreach($suppliers as $supplier)
                                <tr data-row-id="{{ $supplier->id }}">
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->contact_person }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td class="word-wrap">{{ $supplier->company_names }}</td>
                                    <td>{{ $supplier->pan_number }}</td>
                                    <td>{{ $supplier->registration_number }}</td>
                                        
                                    <td>
                                        <a href="{{ route('suppliers.edit', $supplier->id) }}"><i class="ri-pencil-fill align-bottom me-2 text-muted" style="color: green !important;"></i></a>
                                        <a class="remove-item-btn" href="#deleteRecordModal" data-bs-toggle="modal" data-company-id="{{ $supplier->id }}"><i class="ri-delete-bin-fill align-bottom me-2 text-muted" style="color: red !important;"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Add Company Modal -->
                <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header bg-soft-primary p-3">
                                <h5 class="modal-title" id="addModalLabel">Add Company</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form class="tablelist-form" autocomplete="off">
                                <div class="modal-body">
                                    <div class="row g-3">
                                        

                                        <div class="col-lg-12">
                                            <label for="add-company-name-field" class="form-label">Company Name</label>
                                            <input type="text" name="company_name" id="add-company-name-field" class="form-control"
                                                placeholder="Enter company name" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success" id="add-btn">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end add modal-->

                <!-- Edit Company Modal -->
                <div class="modal fade" id="editCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header bg-soft-info p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Company</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                            </div>
                            <div class="modal-body" id="editCompanyModalBody">

                            </div>                
                        </div>
                    </div>
                </div>
                <!--end edit modal-->
                
                <!-- Delete Company Modal -->
                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4 class="fs-semibold">You are about to delete a Supplier</h4>
                                    <p class="text-muted fs-14 mb-4 pt-1">Deleting will remove all of your information from our database.</p>
                                    <input type="hidden" id="delete-company-id" />
                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close"
                                            data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <button class="btn btn-danger" id="delete-record">Yes, Delete It!!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                                    aria-label="Close" id="btn-close"></button>
                            </div>
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4 class="fs-semibold">You are about to delete a Company</h4>
                                    <p class="text-muted fs-14 mb-4 pt-1">Deleting will
                                        remove all of your information from our database.</p>
                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <button class="btn btn-danger" id="delete-record">Yes,
                                            Delete It!!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!--end delete modal -->
            </div>
        </div>
        {{-- Success message --}}
        @if(session('success'))
        <div class="text-danger">{{ session('success') }}</div>
        @endif
    </div>
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js')}}"></script>
    <!-- dashboard init -->
    <script src="{{ URL::asset('build/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>



    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <!-- <script src="{{ URL::asset('build/js/pages/crm-contact.init.js') }}"></script> -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Custom AJAX script -->

    <!-- Add Company -->
    <script>
        document.getElementById('add-btn').addEventListener('click', function () {
            const companyName = document.getElementById('add-company-name-field').value;
            const parentId = document.getElementById('add-parent-company-field').value;

            fetch('/admin/company/add_process/', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: companyName,
                    parent_id: parentId
                })
            })
                .then(response => response.json())
                .then(data => {
                    // Optional: dynamically insert new row in the table

                    // Close the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addRecordModal'));
                    modal.hide();

                    //redirect()->route('companies.index')->with('success', 'Company added successfully!');

                    // Show success message
                    // Swal.fire('Added!', 'Company added successfully.', 'success');
                    Swal.fire({
                        title: 'Success!',
                        text: 'A new company has been added.',
                        icon: 'success',
                        customClass: {
                            title: 'swal2-title', // Custom class for title
                            htmlContainer: 'custom-html' // Custom class for HTML container
                        }
                    });

                    // Optional: reload the table or page
                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                })
                .catch(error => {
                    console.error(error);
                    // Swal.fire('Error!', 'Something went wrong while adding.', 'error');
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong with the adding.',
                        icon: 'error',
                        customClass: {
                            title: 'swal2-title', // Custom class for title
                            htmlContainer: 'custom-html' // Custom class for HTML container
                        }
                    });
                });
        });
    </script>
    <script>
        document.addEventListener('click', function (event) {
            if (event.target.closest('.remove-item-btn')) {
                const btn = event.target.closest('.remove-item-btn');
                const companyId = btn.getAttribute('data-company-id');
                document.getElementById('delete-company-id').value = companyId;
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Open delete modal and set company ID
            // document.querySelectorAll('.remove-item-btn').forEach(function (btn) {
            //     btn.addEventListener('click', function () {
            //         const companyId = this.getAttribute('data-company-id');
            //         alert('companyId :'+companyId );
            //         document.getElementById('delete-company-id').value = companyId;
            //     });
            // });

            // Handle delete confirmation
            document.getElementById('delete-record').addEventListener('click', function () {
                const supplierId = document.getElementById('delete-company-id').value;
                // Send DELETE request
                fetch(`/suppliers/${supplierId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteRecordModal'));
                        modal.hide();

                        // Remove the row from the table
                        const row = document.querySelector(`tr[data-row-id="${supplierId}"]`);
                        if (row) row.remove();

                        // Show success message
                        //Swal.fire('Deleted!', data.message, 'success');
                        Swal.fire({
                            title: 'Success!',
                            text: 'The selected Company has been deleted.',
                            icon: 'success',
                            customClass: {
                                title: 'swal2-title', // Custom class for title
                                htmlContainer: 'custom-html' // Custom class for HTML container
                            }
                        });
                        setTimeout(function () {
                        location.reload();
                    }, 2000);
                    } else {
                        // Show error message
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                });
            });
        });
    </script>
    <script>
        $(document).on('click', '.addCompanyBtn', function () {
            $.ajax({
                url: '/admin/company/add/',
                method: 'GET',
                success: function (response) {
                    $('#addCompanyModalBody').html(response);
                    $('#addCompanyModal').modal('show');
                },
                error: function () {
                    alert('Unable to fetch company data.');
                }
            });
        });
        $(document).on('click', '.editCompanyBtn', function () {
            var companyId = $(this).data('id');
            $.ajax({
                url: '/admin/company/edit/' + companyId,
                method: 'GET',
                success: function (response) {
                    $('#editCompanyModalBody').html(response);
                    $('#editCompanyModal').modal('show');
                },
                error: function () {
                    alert('Unable to fetch company data.');
                }
            });
        });
    </script>

@endsection
<style>
    .swal2-title {
    font-size: 1.5rem;
    color: green !important;
    }

    .custom-html {
        font-size: 1rem;
        color: #6c757d;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>