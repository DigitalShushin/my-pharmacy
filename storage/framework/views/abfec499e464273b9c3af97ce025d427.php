
<?php $__env->startSection('title'); ?> Categories <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<!-- jsvectormap css -->
<link href="<?php echo e(URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />

<!-- gridjs css -->
<link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/gridjs/theme/mermaid.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> Dashboards <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Categories <?php $__env->endSlot(); ?> 
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row g-4 align-items-center">
                    <div class="col-sm-auto">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title mb-0 flex-grow-1 mx-1">Categories</h4>
                            <button class="btn btn-primary">Add New</button>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="d-flex justify-content-sm-end">
                            <div class="search-box ms-2">
                                <input type="text" class="form-control" id="searchResultList" placeholder="Search for categories...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="recomended-category" class="table-card"></div>
                <script id="category-data" type="application/json">
                    <?php echo json_encode($categories); ?>

                </script>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<!-- apexcharts -->
<script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>

<!-- Vector map-->
<script src="<?php echo e(URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/jsvectormap/maps/world-merc.js')); ?>"></script>
<!-- gridjs js -->
<script src="<?php echo e(URL::asset('build/libs/gridjs/gridjs.umd.js')); ?>"></script>

<!-- Dashboard init -->
<script src="<?php echo e(asset('build/js/pages/category.init.js')); ?>"></script>

<!-- App js -->
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laravel\my-pharmacy\resources\views/apps-category.blade.php ENDPATH**/ ?>