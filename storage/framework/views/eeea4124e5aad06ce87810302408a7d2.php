
<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.dashboards'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />

<!-- Search for input -->
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (must be loaded first) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?>
        Forms
    <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?>
        Sale Returns
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Enter Sale ID to Start a Return</h4>
                
            </div><!-- end card header -->

            <div class="card-body">
                
                <div class="live-preview">

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('sale-returns.create')); ?>" method="GET">
                        <div class="form-group">
                            <label for="sale_id">Sale ID</label>
                            <input type="number" name="sale_id" id="sale_id" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Fetch Sale</button>
                    </form>
                </div> <!-- end live preview -->
            </div> <!-- end card body --> 
        </div> <!-- end card -->
    </div> <!-- end col -->  
</div> <!-- end row --> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\shushin_projects\pharmacy-laravel\resources\views/sale-returns/lookup.blade.php ENDPATH**/ ?>