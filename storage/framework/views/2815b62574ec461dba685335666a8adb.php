
<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.dashboards'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="d-flex flex-grow-1 gap-2">
                            <h2>Companies</h2>
                            <a href="#addRecordModal" class="btn btn-info add-btn" data-bs-toggle="modal">
                                <i class="ri-add-fill me-1 align-bottom"></i> Add New</a>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="hstack text-nowrap gap-2">
                                <button class="btn btn-danger" id="remove-actions" onclick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addmembers"><i
                                        class="ri-filter-2-line me-1 align-bottom"></i> Filters</button>
                                <button class="btn btn-soft-success">Import</button>
                                <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"
                                    class="btn btn-soft-info"><i class="ri-more-2-fill"></i></button>
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
                    <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Parent Company</th>
                                <th>Company Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sn = 0; ?>
                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-row-id="<?php echo e($company->id); ?>">
                                    <td><?php echo e(++$sn); ?></td>
                                    <td><?php echo e($company->parent ? $company->parent->name : ''); ?></td>
                                    <td><?php echo e($company->name); ?></td>
                                    <td>
                                        <!-- <a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a>  -->
                                        <a class="edit-item-btn" href="#showModal" data-bs-toggle="modal"
                                            data-company-id="<?php echo e($company->id); ?>" data-company-name="<?php echo e($company->name); ?>"
                                            data-parent-id="<?php echo e($company->parent_id); ?>"><i
                                                class="ri-pencil-fill align-bottom me-2 text-muted"
                                                style="color: green !important;"></i></a>
                                        <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal"
                                            data-company-id="<?php echo e($company->id); ?>"><i
                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"
                                                style="color: red !important;"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
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
                                            <label for="add-parent-company-field" class="form-label">Parent Company</label>
                                            <select id="add-parent-company-field" class="form-select">
                                                <option value="">Select parent company</option>
                                                <?php $__currentLoopData = $parentCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($parent->id); ?>"><?php echo e($parent->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-12">
                                            <label for="add-company-name-field" class="form-label">Company Name</label>
                                            <input type="text" id="add-company-name-field" class="form-control"
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

                <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header bg-soft-info p-3">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
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
                                                    <?php $__currentLoopData = $parentCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($parent->id); ?>"><?php echo e($parent->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-lg-12">
                                            <div>
                                                <label for="company_name-field" class="form-label">Company Name</label>
                                                <input type="text" id="company_name-field" class="form-control"
                                                    placeholder="Enter company name" required />
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
                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                            </div>
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4 class="fs-semibold">You are about to delete a contact ?</h4>
                                    <p class="text-muted fs-14 mb-4 pt-1">Deleting your contact will
                                        remove all of your information from our database.</p>
                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close"
                                            data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
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
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/jsvectormap/maps/world-merc.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.js')); ?>"></script>
    <!-- dashboard init -->
    <script src="<?php echo e(URL::asset('build/js/pages/dashboard-ecommerce.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>



    <script src="<?php echo e(URL::asset('build/libs/list.js/list.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/list.pagination.js/list.pagination.min.js')); ?>"></script>
    <!-- <script src="<?php echo e(URL::asset('build/js/pages/crm-contact.init.js')); ?>"></script> -->
    <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>

    <!-- Custom AJAX script -->

    <!-- Add Company -->
    <script>
        document.getElementById('add-btn').addEventListener('click', function () {
            const companyName = document.getElementById('add-company-name-field').value;
            const parentId = document.getElementById('add-parent-company-field').value;

            fetch('/companies', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
                    setTimeout(function () {
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
        const table = $('#model-datatables').DataTable();

        // Delegate event for dynamically generated buttons
        document.querySelector('#model-datatables').addEventListener('click', function (e) {
            const btn = e.target.closest('.edit-item-btn');
            if (btn) {
                const companyId = btn.getAttribute('data-company-id');
                const companyName = btn.getAttribute('data-company-name');
                const parentId = btn.getAttribute('data-parent-id');

                document.getElementById('id-field').value = companyId;
                document.getElementById('company_name-field').value = companyName;
                document.getElementById('parent-company-field').value = parentId;

                document.getElementById('exampleModalLabel').textContent = "Edit Company";
            }
        });

            // Handle update button click
            document.getElementById('edit-btn').addEventListener('click', function () {
                const id = document.getElementById('id-field').value;
                const companyName = document.getElementById('company_name-field').value;
                const parentId = document.getElementById('parent-company-field').value;

                // Send the updated data to the server via PUT request
                fetch(`/companies/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        name: companyName,
                        parent_id: parentId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    
                    // Close the modal after the update
                    const modal = bootstrap.Modal.getInstance(document.getElementById('showModal'));
                    modal.hide();

                    
                    // location.reload(); 

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
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
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
        const table = $('#model-datatables').DataTable(); // Initialize DataTable

        // 🧠 Use event delegation to catch delete button clicks (works across pages)
        document.querySelector('#model-datatables').addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-item-btn');
            if (btn) {
                companyId = btn.getAttribute('data-company-id');
            }
        });

        // ✅ When delete is confirmed from modal
        document.getElementById('delete-record').addEventListener('click', function () {
            if (!companyId) return;

            fetch(`/companies/${companyId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    // 🔥 Find the row by data-row-id and remove using DataTables API
                    const rowElement = document.querySelector(`[data-row-id="${companyId}"]`);
                    if (rowElement) {
                        table.row(rowElement).remove().draw(); // Remove and redraw
                    }

                    // 🧼 Close modal
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

<?php $__env->stopSection(); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="<?php echo e(URL::asset('build/js/pages/datatables.init.js')); ?>"></script>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\shushin_projects\pharmacy-laravel\resources\views/companies/index.blade.php ENDPATH**/ ?>