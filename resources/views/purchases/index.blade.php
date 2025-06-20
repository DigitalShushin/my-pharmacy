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
                    <h5 class="card-title mb-0">Purchase List
                        <a href="{{ route('purchases.create') }}" class="btn btn-info add-btn float-right" style="float: right;"><i class="ri-add-fill me-1 align-bottom"></i> Add New</a></h5>
                    
                    <!-- <a class="addCompanyBtn btn btn-info add-btn" href="javascript:void(0);" data-bs-toggle="modal"><i class="ri-add-fill me-1 align-bottom text-muted"></i> Add New</a> -->
                </div>
                <div class="card-body">
                    <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th class="sort" data-sort="date" scope="col">Date</th>
                                <th class="sort" data-sort="supplier_name" scope="col">Supplier Name</th>
                                <th class="sort" data-sort="invoice" scope="col">Invoice Number</th>
                                <th class="sort" data-sort="net_amount" scope="col">Net Amount</th>
                                <th class="sort" data-sort="vat" scope="col">VAT</th>
                                <th class="sort" data-sort="discount" scope="col">Discount</th>
                                <th class="sort" data-sort="total_amount" scope="col">Total Amount</th>
                        <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sn = 0; ?>
                            @foreach($purchases as $purchase)
                                <tr data-row-id="{{ $purchase->id }}">
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $purchase->purchase_date }}</td>
                                    <td>{{ $purchase->supplier->name ?? 'N/A' }}</td>
                                    <td>{{ $purchase->invoice_number }}</td>
                                    <td>{{ $purchase->net_amount }}</td>
                                    <td>{{ $purchase->vat }}</td>
                                    <td>{{ $purchase->discount }}</td>
                                    <td>{{ $purchase->total_amount }}</td>
                                        
                                    <td>
                                        <a href="{{ route('purchases.edit', $purchase->id) }}"><i class="ri-pencil-fill align-bottom me-2 text-muted" style="color: green !important;"></i></a>
                                        <a class="remove-item-btn" href="#deleteRecordModal" data-bs-toggle="modal" data-company-id="{{ $purchase->id }}"><i class="ri-delete-bin-fill align-bottom me-2 text-muted" style="color: red !important;"></i></a>
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
                                    <h4 class="fs-semibold">You are about to delete a Purchase</h4>
                                    <p class="text-muted fs-14 mb-4 pt-1">Deleting will remove all of your information from our database.</p>
                                    <input type="hidden" id="delete-purchase-id" />
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
    <script>
        document.addEventListener('click', function (event) {
            if (event.target.closest('.remove-item-btn')) {
                const btn = event.target.closest('.remove-item-btn');
                const companyId = btn.getAttribute('data-company-id');
                document.getElementById('delete-purchase-id').value = companyId;
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            
            // Handle delete confirmation
            document.getElementById('delete-record').addEventListener('click', function () {
                const supplierId = document.getElementById('delete-purchase-id').value;
                // Send DELETE request
                fetch(`/purchases/${supplierId}`, {
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
                            text: 'The selected Purchase has been deleted.',
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