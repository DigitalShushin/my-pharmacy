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
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<style>
    .swal2-container .swal2-title{
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
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="d-flex flex-grow-1 gap-2">
                        <h2>Companies</h2>
                        <a href="#addRecordModal" class="btn btn-info add-btn" data-bs-toggle="modal">                                
                            <i class="ri-add-fill me-1 align-bottom"></i> Add New</a>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="hstack text-nowrap gap-2">
                            <button class="btn btn-danger" id="remove-actions" onclick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addmembers"><i class="ri-filter-2-line me-1 align-bottom"></i> Filters</button>
                            <button class="btn btn-soft-success">Import</button>
                            <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-soft-info"><i class="ri-more-2-fill"></i></button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                <li><a class="dropdown-item" href="#">All</a></li>
                                <li><a class="dropdown-item" href="#">Last Week</a></li>
                                <li><a class="dropdown-item" href="#">Last Month</a></li>
                                <li><a class="dropdown-item" href="#">Last Year</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Modal Data Datatables</h5>
            </div>
            <div class="card-body">
                <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Parent Company</th>
                            <th>Company Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sn=0; ?>
                        @foreach($companies as $company)
                        <tr>
                            <td>{{ ++$sn }}</td>
                            <td>{{ $company->parent ? $company->parent->name : '' }}</td>
                            <td>{{ $company->name }}</td>
                            <td>
                                <!-- <a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a>  -->
                                <a class="edit-item-btn" href="#showModal" data-bs-toggle="modal" data-company-id="{{ $company->id }}" data-company-name="{{ $company->name }}" data-parent-id="{{ $company->parent_id }}"><i class="ri-pencil-fill align-bottom me-2 text-muted" style="color: green !important;"></i></a> 
                                <a class="remove-item-btn" href="#deleteRecordModal" data-company-id="{{ $company->id }}"><i class="ri-delete-bin-fill align-bottom me-2 text-muted" style="color: red !important;"></i></a>
                            </td>
                        </tr>                        
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-soft-primary p-3">
                                    <h5 class="modal-title" id="addModalLabel">Add Company</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close" id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" autocomplete="off">
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <label for="add-parent-company-field" class="form-label">Parent Company</label>
                                                <select id="add-parent-company-field" class="form-select">
                                                    <option value="">Select parent company</option>
                                                    @foreach($parentCompanies as $parent)
                                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-12">
                                                <label for="add-company-name-field" class="form-label">Company Name</label>
                                                <input type="text" id="add-company-name-field" class="form-control" placeholder="Enter company name" required />
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

                    <div class="modal fade" id="showModal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-soft-info p-3">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close" id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" autocomplete="off">
                                    <div class="modal-body">
                                        <input type="hidden" id="id-field" />
                                        <div class="row g-3">
                                            <div class="col-lg-12">                                                
                                                <div>                                                   
                                                    <label for="parent-company-field" class="form-label">Parent Company</label>
                                                    <select id="parent-company-field" class="form-select">
                                                        <option value="">Select parent company</option>
                                                        @foreach($parentCompanies as $parent)
                                                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="company_name-field" class="form-label">Company Name</label>
                                                    <input type="text" id="company_name-field" class="form-control" placeholder="Enter company name" required />
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success" id="edit-btn">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end edit modal-->
        </div>
    </div>
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

        fetch('/companies', {
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
                title: 'Added!',
                text: 'Company added successfully.',
                icon: 'success',
                customClass: {
                    title: 'swal2-title', // Custom class for title
                    htmlContainer: 'custom-html' // Custom class for HTML container
                }
            });

            // Optional: reload the table or page
            setTimeout(function() {
                location.reload();
            }, 3000);

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

<!-- Edit Comapny -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle Edit button click
        document.querySelectorAll('.edit-item-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                // Set company ID
                const companyId = this.getAttribute('data-company-id');
                const companyName = this.getAttribute('data-company-name');
                const parentId = this.getAttribute('data-parent-id');

                // Fill the modal form fields with the company details from the data attributes
                document.getElementById('id-field').value = companyId;
                document.getElementById('company_name-field').value = companyName;
                document.getElementById('parent-company-field').value = parentId;

                // Optional: set modal title (customize this based on context)
                document.getElementById('exampleModalLabel').textContent = "Edit Company";
            });
        });

        // Handle update button click
        document.getElementById('edit-btn').addEventListener('click', function () {
            const id = document.getElementById('id-field').value;
            const companyName = document.getElementById('company_name-field').value;
            const parentId = document.getElementById('parent-company-field').value;

            // Send the updated data to the server via PUT request
            fetch(`/companies/${id}`, {
                method: 'PUT',
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
                // Find the row in the table by data-row-id
                const row = document.querySelector(`tr[data-row-id="${id}"]`);

                if (row) {
                    // Update the company name in the table row
                    const companyNameCell = row.querySelector('.company_name');
                    companyNameCell.textContent = companyName;

                    // Update the parent company name in the table row
                    const parentCompanyCell = row.querySelector('.name .flex-grow-1');
                    const parentSelect = document.getElementById('parent-company-field');
                    const selectedOption = parentSelect.options[parentSelect.selectedIndex];
                    const parentCompanyName = selectedOption.textContent === 'Select parent company' ? '' : selectedOption.textContent;
                    parentCompanyCell.textContent = parentCompanyName;
                
                    const aTag = row.querySelector('.list-inline-item'); // or use a more specific selector
                    aTag.setAttribute('data-company-id', id);
                    aTag.setAttribute('data-company-name', companyName);
                    aTag.setAttribute('data-parent-id', parentId);
                }

                // Close the modal after the update
                const modal = bootstrap.Modal.getInstance(document.getElementById('showModal'));
                modal.hide();

                // Show success message
                // Swal.fire('Updated!', 'Company updated successfully.', 'success');
                Swal.fire({
                title: 'Updated!',
                text: 'Company updated successfully.',
                icon: 'success',
                customClass: {
                    title: 'swal2-title', // Custom class for title
                    htmlContainer: 'custom-html' // Custom class for HTML container
                }
            });
            })
            .catch(error => {
                console.error(error);
                // Swal.fire('Error!', 'Something went wrong with the update.', 'error');
                Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong with the update.',
                        icon: 'error',
                        customClass: {
                            title: 'swal2-title', // Custom class for title
                            htmlContainer: 'custom-html' // Custom class for HTML container
                        }
                    });
            });
        });
    });
</script>



<!-- Delete Company -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let companyId = null;

        // Step 1: When clicking on the trash/delete icon
        document.querySelectorAll('.remove-item-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                companyId = this.getAttribute('data-company-id');
            });
        });

        // Step 2: When confirming delete in modal
        document.getElementById('delete-record').addEventListener('click', function () {
            if (!companyId) return;

            fetch(`/companies/${companyId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    // Remove row from table
                    const row = document.querySelector(`[data-row-id="${companyId}"]`);
                    if (row) row.remove();

                    // Close the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteRecordModal'));
                    modal.hide();

                    // Swal.fire('Deleted!', 'Company deleted successfully.', 'success');
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Company deleted successfully.',
                        icon: 'success',
                        customClass: {
                            title: 'swal2-title', // Custom class for title
                            htmlContainer: 'custom-html' // Custom class for HTML container
                        }
                    });
                    
                } else {
                    // Swal.fire('Error!', 'Could not delete the company.', 'error');
                    Swal.fire({
                        title: 'Error!',
                        text: 'Could not delete the company.',
                        icon: 'error',
                        customClass: {
                            title: 'swal2-title', // Custom class for title
                            htmlContainer: 'custom-html' // Custom class for HTML container
                        }
                    });
                }
            })
            .catch(error => {
                console.error(error);
                // Swal.fire('Error!', 'Something went wrong.', 'error');
                Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong.',
                        icon: 'error',
                        customClass: {
                            title: 'swal2-title', // Custom class for title
                            htmlContainer: 'custom-html' // Custom class for HTML container
                        }
                    });
            });
        });
    });
</script>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>



