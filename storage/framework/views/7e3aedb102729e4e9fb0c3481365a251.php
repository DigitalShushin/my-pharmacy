
<form class="tablelist-form" autocomplete="off" action="<?php echo e(route('company.add')); ?>" method="POST">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>
    <div class="modal-body">
        <input type="hidden" id="id-field" />
        <div class="row g-3">
            <div class="col-lg-12">
                <div>
                    <label for="parent-company-field" class="form-label">Parent Company</label>
                    <select name="parent_id" id="parent-company-field" class="form-select">
                        <option value="">Select parent company</option>
                        <?php $__currentLoopData = $parentCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($parent->id); ?>">
                                <?php echo e($parent->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>


            <div class="col-lg-12">
                <div>
                    <label for="company_name-field" class="form-label">Company Name</label>
                    <input name="name" type="text" id="company_name-field" class="form-control" placeholder="Enter company name" value="" required />
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="add-btn">Add</button>
        </div>
    </div>
</form><?php /**PATH C:\laravel\my-pharmacy\resources\views/company/add-form.blade.php ENDPATH**/ ?>