
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
                    <form action="<?php echo e(route('products.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <!-- Company Name -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyNameinput" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter company name" id="companyNameinput" required>
                                </div>
                            </div>

                            <!-- Contact Person -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contactNameinput" class="form-label">Contact Person</label>
                                    <input type="text" class="form-control" name="contact_person" placeholder="Enter contact person's name" id="contactNameinput">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phonenumberInput" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" name="phone" placeholder="+(245) 451 45123" id="phonenumberInput" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emailidInput" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" placeholder="example@gmail.com" id="emailidInput">
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="address1ControlTextarea" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Address 1" id="address1ControlTextarea" required>
                                </div>
                            </div>

                            <!-- Companies Array (checkboxes) -->
                            

                            <!-- Pan Number -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="panNumber" class="form-label">Pan Number</label>
                                    <input type="text" class="form-control" name="pan_number" placeholder="Enter Pan number" id="panNumber">
                                </div>
                            </div>

                            <!-- Registration Number -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="registrationNumber" class="form-label">Registration Number</label>
                                    <input type="text" class="form-control" name="registration_number" placeholder="Enter registration number" id="registrationNumber">
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\shushin_projects\pharmacy-laravel\resources\views/products/create.blade.php ENDPATH**/ ?>