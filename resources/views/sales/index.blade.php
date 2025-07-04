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
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Sales List
                    <a href="{{ route('sales.create') }}" class="btn btn-info add-btn float-right" style="float: right;"><i class="ri-add-fill me-1 align-bottom"></i> Add New</a>
                    </h5>
                </div>
                <div class="card-body">
                    <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th class="sort" data-sort="sales_id" scope="col">Sales ID</th>
                                <th class="sort" data-sort="customer_id" scope="col">Customer ID</th>
                                <th class="sort" data-sort="net_amount" scope="col">Net Amount</th>
                                <th class="sort" data-sort="vat" scope="col">VAT</th>
                                <th class="sort" data-sort="discount" scope="col">Discount</th>
                                <th class="sort" data-sort="total_amount" scope="col">Total Amount</th>
                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sn = 0; ?>
                            @foreach($sales as $sale)
                                <tr data-row-id="{{ $sale->id }}">
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $sale->id }}</td>
                                    <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                                    <td>{{ $sale->net_amount }}</td>
                                    <td>{{ $sale->vat }}</td>
                                    <td>{{ $sale->discount }}</td>
                                    <td>{{ $sale->total_amount }}</td>
                                        
                                    <td>
                                        <a href="{{ route('sales.edit', $sale->id) }}"><i class="ri-pencil-fill align-bottom me-2 text-muted" style="color: green !important;"></i></a>
                                        <a class="remove-item-btn" href="#deleteRecordModal" data-bs-toggle="modal" data-sale-id="{{ $sale->id }}"><i class="ri-delete-bin-fill align-bottom me-2 text-muted" style="color: red !important;"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>               
                               
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
                                    <h4 class="fs-semibold">You are about to delete a Sale</h4>
                                    <p class="text-muted fs-14 mb-4 pt-1">Deleting will remove all of your information from our database.</p>
                                    <input type="hidden" id="delete-sale-id" />
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
                <!--end delete modal -->

                
            </div>
        </div>
        {{-- Success message --}}
        @if(session('success'))
        <div class="text-danger">{{ session('success') }}</div>
        @endif

        {{-- Error messages --}}
        @if($errors->any())
        <div class="text-danger">{{ $error }}</div>
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

    
    <script>
        document.addEventListener('click', function (event) {
            if (event.target.closest('.remove-item-btn')) {
                const btn = event.target.closest('.remove-item-btn');
                const saleId = btn.getAttribute('data-sale-id');
                document.getElementById('delete-sale-id').value = saleId;
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            

            // Handle delete confirmation
            document.getElementById('delete-record').addEventListener('click', function () {
                const saleId = document.getElementById('delete-sale-id').value;
                // Send DELETE request
                fetch(`/sales/${saleId}`, {
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
                        const row = document.querySelector(`tr[data-row-id="${saleId}"]`);
                        if (row) row.remove();

                        // Show success message
                        //Swal.fire('Deleted!', data.message, 'success');
                        Swal.fire({
                            title: 'Success!',
                            text: 'The selected sale has been deleted.',
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