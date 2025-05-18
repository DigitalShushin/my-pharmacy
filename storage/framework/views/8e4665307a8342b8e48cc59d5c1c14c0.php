
<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.dashboards'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />


<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Forms
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Suppliers
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add Supplier Form</h4>
                    
                </div><!-- end card header -->

                <div class="card-body">
                    
                    <div class="live-preview">
                    <form action="<?php echo e(route('suppliers.update', $supplier->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?> <!-- Use PUT for updating -->

                    <div class="row">
                        <!-- Supplier Name -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="companyNameinput" class="form-label">Supplier Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Supplier name" id="supplierNameinput" value="<?php echo e($supplier->name); ?>" required>
                            </div>
                        </div>

                        <!-- Contact Person -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contactNameinput" class="form-label">Contact Person</label>
                                <input type="text" class="form-control" name="contact_person" placeholder="Enter contact person's name" id="contactNameinput" value="<?php echo e($supplier->contact_person); ?>">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phonenumberInput" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" placeholder="+(245) 451 45123" id="phonenumberInput" value="<?php echo e($supplier->phone); ?>" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="emailidInput" class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" placeholder="example@gmail.com" id="emailidInput" value="<?php echo e($supplier->email); ?>">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="address1ControlTextarea" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Address 1" id="address1ControlTextarea" value="<?php echo e($supplier->address); ?>" required>
                            </div>
                        </div>

                        <!-- Companies Array (checkboxes) -->
                        <div class="col-lg-12">
                            <h6 class="fw-semibold">Companies Array</h6>
                            <div class="border p-3 rounded bg-light">
                                <div class="row">
                                    <?php if($companies->has(null)): ?>
                                        <?php $__currentLoopData = $companies[null]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-3 mb-3">
                                                <!-- Parent checkbox -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="companies_array[]"
                                                        value="<?php echo e($parent->id); ?>" id="company_parent_<?php echo e($parent->id); ?>"
                                                        <?php echo e(in_array($parent->id, $selectedCompanies ?? []) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="company_parent_<?php echo e($parent->id); ?>">
                                                        <?php echo e($parent->name); ?>

                                                    </label>
                                                </div>

                                                <?php if($companies->has($parent->id)): ?>
                                                    <div class="row ms-1">
                                                        <?php $__currentLoopData = $companies[$parent->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-12">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="companies_array[]"
                                                                        value="<?php echo e($child->id); ?>" id="company_<?php echo e($child->id); ?>"
                                                                        <?php echo e(in_array($child->id, $selectedCompanies ?? []) ? 'checked' : ''); ?>>
                                                                    <label class="form-check-label" for="company_<?php echo e($child->id); ?>">
                                                                        <?php echo e($child->name); ?>

                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>


                        <!-- Pan Number -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="panNumber" class="form-label">Pan Number</label>
                                <input type="text" class="form-control" name="pan_number" placeholder="Enter Pan number" id="panNumber" value="<?php echo e($supplier->pan_number); ?>">
                            </div>
                        </div>

                        <!-- Registration Number -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="registrationNumber" class="form-label">Registration Number</label>
                                <input type="text" class="form-control" name="registration_number" placeholder="Enter registration number" id="registrationNumber" value="<?php echo e($supplier->registration_number); ?>">
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </form>

                    </div>
                    
                </div>
            </div>
        </div> <!-- end col -->

        
    </div>
    <!--end row-->

    
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

<script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>

<!--jquery cdn-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!--select2 cdn-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="<?php echo e(URL::asset('build/js/pages/select2.init.js')); ?>"></script>

<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\shushin_projects\pharmacy-laravel\resources\views/suppliers/edit.blade.php ENDPATH**/ ?>