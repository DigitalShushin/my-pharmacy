-category-add.blade.php

<?php $__env->startSection('title'); ?> Add Category <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Categories <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Add Category <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<form id="addcategory-form" action="<?php echo e(route('category.store')); ?>" method="POST" class="needs-validation" novalidate>
    <?php echo csrf_field(); ?>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="category-name-input">Category Title</label>
                    <input type="hidden" id="formAction" name="formAction" value="add">
                    <input type="text" class="form-control d-none" id="category-id-input">
                    <input type="text" class="form-control" id="category-name-input" name="name" placeholder="Enter category title" required>
                    <div class="invalid-feedback">Please enter a category title.</div>
                </div>
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\shushin_projects\pharmacy\resources\views/apps-category-add.blade.php ENDPATH**/ ?>