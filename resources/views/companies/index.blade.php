@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

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
                                <button class="btn btn-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addmembers"><i
                                        class="ri-filter-2-line me-1 align-bottom"></i> Filters</button>
                                <button class="btn btn-soft-success">Import</button>
                                <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown"
                                    aria-expanded="false" class="btn btn-soft-info"><i
                                        class="ri-more-2-fill"></i></button>
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
        <!--end col-->
        <div class="col-xxl-12">
            <div class="card" id="contactList">
                <div class="card-header">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="search-box">
                                <input type="text" class="form-control search"
                                    placeholder="Search for contact...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted">Sort by: </span>
                                <select class="form-control mb-0" data-choices data-choices-search-false
                                    id="choices-single-default">
                                    <option value="Name">Name</option>
                                    <option value="Company">Company</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                        <table class="table align-middle table-nowrap mb-0" id="customerTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 50px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                </div>
                            </th>
                            <th class="sort" data-sort="name" scope="col">Parent Company</th>
                            <th class="sort" data-sort="company_name" scope="col">Company Name</th>                            
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        @foreach($companies as $company)
                            <tr data-row-id="{{ $company->id }}">
                                <th scope="row">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                    </div>
                                </th>
                                
                                <td class="name">
                                    <div class="d-flex align-items-center">
                                        <!-- <div class="flex-shrink-0">
                                            <img src="{{ asset('build/images/users/' . $company->avatar) }}" alt="" class="avatar-xs rounded-circle">
                                        </div> -->
                                        <div class="flex-grow-1 ms-2">{{ $company->parent ? $company->parent->name : '' }}</div>
                                    </div>
                                </td>
                                <td class="company_name">{{ $company->name }}</td>
                                <!-- <td class="email_id">{{ $company->email }}</td>
                                <td class="phone">{{ $company->phone }}</td>
                                <td class="lead_score">{{ $company->lead_score }}</td>
                                <td class="tags">
                                    @foreach (explode(',', $company->tags) as $tag)
                                        <span class="badge badge-soft-primary">{{ $tag }}</span>
                                    @endforeach
                                </td>
                                <td class="date">{{ \Carbon\Carbon::parse($company->last_contacted)->format('d M, Y h:i A') }}</td> -->
                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li>
                                            <!-- <a class="list-inline-item edit-item-btn" href="#showModal" data-bs-toggle="modal"><i class="ri-pencil-fill align-bottom me-2 text-muted" title="Edit"></i> </a> -->
                                            <a class="list-inline-item edit-item-btn"
                                            href="#showModal"
                                            data-bs-toggle="modal"
                                            data-company-id="{{ $company->id }}"
                                            data-company-name="{{ $company->name }}"
                                            data-parent-id="{{ $company->parent_id }}">
                                            <i class="ri-pencil-fill align-bottom me-2 text-muted" title="Edit"></i>
                                            </a>
                                        </li>                                        
                                        <li>
                                            <a class="list-inline-item remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal" data-company-id="{{ $company->id }}">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted" title="Delete"></i> 
                                            </a>
                                        </li>
                                        <!-- <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Call">
                                            <a href="javascript:void(0);" class="text-muted d-inline-block">
                                                <i class="ri-phone-line fs-16"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Message">
                                            <a href="javascript:void(0);" class="text-muted d-inline-block">
                                                <i class="ri-question-answer-line fs-16"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item view-item-btn" href="javascript:void(0);"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                    <li><a class="dropdown-item edit-item-btn" href="#showModal" data-bs-toggle="modal"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li> -->
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                        trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ contacts We
                                        did not find any
                                        contacts for you search.</p>
                                </div>
                            </div>
                        </div>
                        <!-- pagination button -->
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2">
                                <!-- Previous button -->
                                <a class="page-item pagination-prev {{ $companies->onFirstPage() ? 'disabled' : '' }}" href="{{ $companies->previousPageUrl() }}">
                                    Previous
                                </a>

                                <!-- Page numbers -->
                                <ul class="pagination listjs-pagination mb-0">
                                    @foreach ($companies->getUrlRange(1, $companies->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $companies->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Next button -->
                                <a class="page-item pagination-next {{ $companies->hasMorePages() ? '' : 'disabled' }}" href="{{ $companies->nextPageUrl() }}">
                                    Next
                                </a>
                            </div>
                        </div><!-- end pagination button -->

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

                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                                        aria-label="Close" id="btn-close"></button>
                                </div>
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                        trigger="loop" colors="primary:#405189,secondary:#f06548"
                                        style="width:90px;height:90px"></lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4 class="fs-semibold">You are about to delete a contact ?</h4>
                                        <p class="text-muted fs-14 mb-4 pt-1">Deleting your contact will
                                            remove all of your information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button
                                                class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close"
                                                data-bs-dismiss="modal"><i
                                                    class="ri-close-line me-1 align-middle"></i>
                                                Close</button>
                                            <button class="btn btn-danger" id="delete-record">Yes,
                                                Delete It!!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end delete modal -->

                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <?php /* <div class="col-xxl-3">
            <div class="card" id="contact-view-detail">
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block">
                        <img src="{{ URL::asset('build/images/users/avatar-10.jpg') }}" alt=""
                            class="avatar-lg rounded-circle img-thumbnail">
                        <span class="contact-active position-absolute rounded-circle bg-success"><span
                                class="visually-hidden"></span>
                    </div>
                    <h5 class="mt-4 mb-1">Tonya Noble</h5>
                    <p class="text-muted">Nesta Technologies</p>

                    <ul class="list-inline mb-0">
                        <li class="list-inline-item avatar-xs">
                            <a href="javascript:void(0);"
                                class="avatar-title bg-soft-success text-success fs-15 rounded">
                                <i class="ri-phone-line"></i>
                            </a>
                        </li>
                        <li class="list-inline-item avatar-xs">
                            <a href="javascript:void(0);"
                                class="avatar-title bg-soft-danger text-danger fs-15 rounded">
                                <i class="ri-mail-line"></i>
                            </a>
                        </li>
                        <li class="list-inline-item avatar-xs">
                            <a href="javascript:void(0);"
                                class="avatar-title bg-soft-warning text-warning fs-15 rounded">
                                <i class="ri-question-answer-line"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Personal Information</h6>
                    <p class="text-muted mb-4">Hello, I'm Tonya Noble, The most effective objective is
                        one that is tailored to the job you are applying for. It states what kind of
                        career you are seeking, and what skills and experiences.</p>
                    <div class="table-responsive table-card">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-medium" scope="row">Designation</td>
                                    <td>Lead Designer / Developer</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium" scope="row">Email ID</td>
                                    <td>tonyanoble@velzon.com</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium" scope="row">Phone No</td>
                                    <td>414-453-5725</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium" scope="row">Lead Score</td>
                                    <td>154</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium" scope="row">Tags</td>
                                    <td>
                                        <span class="badge badge-soft-primary">Lead</span>
                                        <span class="badge badge-soft-primary">Partner</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium" scope="row">Last Contacted</td>
                                    <td>15 Dec, 2021 <small class="text-muted">08:58AM</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col--> */ ?>
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




