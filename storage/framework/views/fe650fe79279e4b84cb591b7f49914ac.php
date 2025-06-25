
<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.dashboards'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

<!-- Search for input -->
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Nepali Date Picker CSS -->
<!-- <link rel="stylesheet" href="https://unpkg.com/nepali-date-picker@2.0.2/dist/nepaliDatePicker.min.css"> -->

<!-- Nepali Date Picker CSS -->
<link href="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v4.0.8.min.css" rel="stylesheet" type="text/css"/>


<!-- jQuery (must be loaded first) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<style>
    .nepali-date-picker {
        
        width: 29% !important;
        z-index: 9999; /* Make sure it stays on top */
    }
    

    .product-column-width{
        width: 160px !important;
    }

    .table-column-width{
        width: 120px !important;
    }

    
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Forms
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Purchases
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    

    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add Purchase</h4>
                    
                </div><!-- end card header -->

                <div class="card-body">
                    
                    <div class="live-preview">
                    <form action="<?php echo e(route('purchases.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                        
                            <!-- Invoice Number -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="invoiceInput" class="form-label">Invoice Number</label>
                                    <input type="text" class="form-control" name="invoice_number" placeholder="DASR0011059" id="invoiceInput" required>
                                </div>
                            </div>
                            
                            <!-- Nepali Date Input -->
                            <div class="col-md-4 ">
                                <div class="mb-3">
                                    <label for="nepaliDate" class="form-label">Purchase Date (B.S.)</label>
                                    <input type="text" class="form-control" name="purchase_date" id="nepaliDate" placeholder="Select Nepali Date">
                                </div>
                            </div>

                            <!-- Supplier Dropdown -->
                            <div class="col-md-4"> 
                                <div class="mb-3">
                                    <label for="supplierSelect" class="form-label">Supplier Name</label>
                                    <select name="supplier_id" id="supplierSelect" class="form-control" required>
                                        <option value="" disabled selected>Select a supplier</option>
                                        <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Product Entry Table -->
                            <div class="col-12">
                                <table class="table table-bordered" id="productTable">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Pack</th>
                                            <th class="table-column-width">Batch</th>
                                            <th>Expiry Date</th>
                                            <th>Quantity</th>
                                            <th>Bonus</th>
                                            <th class="table-column-width">Rate</th>
                                            <th>CC %</th>
                                            <th>CC on bonus</th>
                                            <!-- <th>M.R.F.</th> -->
                                            <th>Amount</th>
                                            <th>Selling Price</th>
                                            <th><button type="button" class="btn btn-sm btn-success" id="addRowBtn">+</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>                                           
                                            <td>
                                                <select name="products[0][product_id]" class="form-control select2" required>
                                                    <option value="" disabled selected>Select Product</option>
                                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($product->id); ?>" <?php echo e(old('products.0.product_id') == $product->id ? 'selected' : ''); ?>>
                                                            <?php echo e($product->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>

                                            <td><input type="number" name="products[0][pack]" class="form-control"></td>
                                            <td><input type="text" name="products[0][batch]" class="form-control"></td>
                                            <td><input type="date" name="products[0][expiry_date]" class="form-control"></td>
                                            <td><input type="number" name="products[0][quantity]" class="form-control"></td>
                                            <td><input type="number" name="products[0][bonus]" class="form-control"></td>
                                            <td><input type="text" name="products[0][rate]" class="form-control"></td>
                                            <td><input type="number" name="products[0][cc]" class="form-control" step="0.1" min="0"></td>
                                            <td><input type="text" name="products[0][cc_on_bonus]" class="form-control"></td>
                                            <!-- <td><input type="text" name="products[0][marked_rate]" class="form-control"></td> -->
                                            <td><input type="text" name="products[0][amount]" class="form-control"></td>
                                            <td><input type="text" name="products[0][sp]" class="form-control"></td>
                                            <!-- <td><input type="text" name="products[0][mrp]" class="form-control"></td> -->
                                            <td><button type="button" class="btn btn-sm btn-danger removeRowBtn">-</button></td>
                                        </tr>
                                    </tbody>
                                     
                                </table>
                            </div>                            


                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="col-md-6">
                                    <!-- Left Column (empty or use as needed) -->
                                </div>

                                <div class="col-md-6">
                                    <!-- Net Amount -->
                                    <div class="d-flex align-items-center mb-3">
                                        <label for="netamountInput" class="form-label me-2" style="min-width: 120px;">Net Amount</label>
                                        <input type="text" class="form-control" name="net_amount" placeholder="Enter net amount" id="netamountInput">
                                    </div>

                                    <!-- Discount -->
                                    <div class="d-flex align-items-center mb-3">
                                        <label for="discountNumber" class="form-label me-2" style="min-width: 120px;">Discount</label>
                                        <input type="text" class="form-control" name="discount" placeholder="Enter discount amount" id="discountNumber">
                                    </div>

                                    <!-- VAT Toggle and Input (aligned properly) -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="d-flex align-items-center me-3" style="min-width: 110px;">
                                            <input class="form-check-input me-2" type="checkbox" id="vatToggle">
                                            <label class="form-check-label mb-0" for="vatToggle">Apply VAT</label>
                                        </div>
                                        <input type="text" class="form-control" name="vat" id="vatInput">
                                    </div>

                                    <!-- Total Amount -->
                                    <div class="d-flex align-items-center mb-3">
                                        <label for="totalAmount" class="form-label me-2" style="min-width: 120px;">Total Amount</label>
                                        <input type="text" class="form-control" name="total_amount" placeholder="Enter total amount" id="totalAmount">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit -->
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
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

<!-- Search for input -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select Product',
            allowClear: true
        });
    });
</script>

<!-- Nepali Date Picker JS -->
<script src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.8.min.js"></script>

<script>
$(document).ready(function () {
    const nepaliInput = document.getElementById('nepaliDate');
    
        $(nepaliInput).nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true
        });
    
});
</script>



<!-- VAT switch button -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const vatToggle = document.getElementById('vatToggle');
        const vatInput = document.getElementById('vatInput');

        vatToggle.addEventListener('change', function () {
            if (this.checked) {
                vatInput.disabled = false;
                vatInput.focus();
            } else {
                vatInput.value = '';
                vatInput.disabled = true;
            }
        });
    });
</script>


<!-- Calculate Amount of value input bu user -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#productTable tbody');
    const netAmountInput = document.getElementById('netamountInput');
    const discountInput = document.getElementById('discountNumber'); // now this will be the discount amount directly
    const vatToggle = document.getElementById('vatToggle');
    const vatInput = document.getElementById('vatInput');
    const totalAmountInput = document.getElementById('totalAmount');
    const VAT_PERCENTAGE = 13; // Change this if VAT % is different
    let rowIndex = 1;

    function recalculate(row) {
        const quantity = parseFloat(row.querySelector('[name*="[quantity]"]').value) || 0;
        const bonus = parseFloat(row.querySelector('[name*="[bonus]"]').value) || 0;
        const cc = parseFloat(row.querySelector('[name*="[cc]"]').value) || 0;
        const rate = parseFloat(row.querySelector('[name*="[rate]"]').value) || 0;
        const pack = parseFloat(row.querySelector('[name*="[pack]"]').value) || 0;

        const ccOnBonus = (bonus * rate * (cc / 100));
        const amount = (quantity * rate) + ccOnBonus;

        row.querySelector('[name*="[cc_on_bonus]"]').value = ccOnBonus.toFixed(2);
        row.querySelector('[name*="[amount]"]').value = amount.toFixed(2);

        updateNetAmount(); // Update net amount every time a row changes

        // Selling Price Calculation
        let sellingPrice = (rate * 1.16) / pack;

        if (vatToggle.checked) {
            sellingPrice *= 1.13;
        }

        row.querySelector('[name*="[sp]"]').value = sellingPrice.toFixed(2);
    }

    function updateNetAmount() {
        let netAmount = 0;
        const amountInputs = tableBody.querySelectorAll('[name*="[amount]"]');
        amountInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            netAmount += value;
        });

        netAmountInput.value = netAmount.toFixed(2);
        updateTotal(); // 🔁 Update total when net amount changes
    }

    function updateTotal() {
        const netAmount = parseFloat(netAmountInput.value) || 0;
        const discountAmount = parseFloat(discountInput.value) || 0; // now treated as direct discount value
        const afterDiscount = Math.max(netAmount - discountAmount, 0); // avoid negative

        let vatAmount = 0;
        if (vatToggle.checked) {
            vatAmount = (afterDiscount * VAT_PERCENTAGE) / 100;
        }

        const total = afterDiscount + vatAmount;
        const roundedTotal = Math.round(total); // Round to nearest whole number

        vatInput.value = vatAmount.toFixed(2);
        totalAmountInput.value = total.toFixed(2);
    }

    function attachEventListeners(row) {
        const inputs = row.querySelectorAll('[name*="[quantity]"], [name*="[bonus]"], [name*="[cc]"], [name*="[rate]"]');
        inputs.forEach(input => {
            input.addEventListener('input', () => recalculate(row));
        });
    }

    // Attach listeners to the initial row
    attachEventListeners(tableBody.querySelector('tr'));

    // When adding new rows
    document.getElementById('addRowBtn').addEventListener('click', function () {
    const newRow = tableBody.lastElementChild.cloneNode(true);
    
    // Clean Select2 from cloned row only (not all rows)
    const clonedSelect = newRow.querySelector('.select2');
    if (clonedSelect) {
        // Destroy Select2 and unwrap DOM
        $(clonedSelect).select2('destroy');
        const parent = clonedSelect.parentElement;
        parent.innerHTML = clonedSelect.outerHTML; // remove select2 wrapper markup
    }

    newRow.querySelectorAll('input, select').forEach(function (el) {
        // Clear values
        if (el.tagName === 'SELECT') {
            el.selectedIndex = 0;
        } else {
            el.value = '';
        }

        // Update name attributes to new index
        if (el.name) {
            el.name = el.name.replace(/\[\d+\]/, `[${rowIndex}]`);
        }

        // Specifically clear the product select
        if (el.classList.contains('select2')) {
            $(el).val('').trigger('change'); // Clear value and trigger Select2 UI reset
        }
    });

    // Append the new row first
    tableBody.appendChild(newRow);

    // Re-initialize Select2 on the new row
    $(newRow).find('.select2').select2({ width: '100%' });

    function updateSelectOptions() {
    const allSelects = tableBody.querySelectorAll('.select2');
    const selectedValues = [];

    // Gather all selected values
    allSelects.forEach(select => {
        const val = select.value;
        if (val) selectedValues.push(val);
    });

    allSelects.forEach(currentSelect => {
        const currentValue = currentSelect.value;

        // Enable all options first
        currentSelect.querySelectorAll('option').forEach(opt => {
            opt.disabled = false;
        });

        // Re-initialize Select2 to reflect changes
        $(currentSelect).select2({ width: '100%' });
    });
}

    // Add change listener to the product select
    newRow.querySelector('.select2').addEventListener('change', updateSelectOptions);

    // Attach input event listeners for calculations
    attachEventListeners(newRow);

    // Update dropdowns to disable selected products
    updateSelectOptions();

    // Increase the index for next row
    rowIndex++;
});


    tableBody.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('removeRowBtn')) {
            const row = e.target.closest('tr');
            if (row) {
                row.remove();
                updateNetAmount(); // Recalculate totals after removal
            }
        }
    });

    // Discount and VAT events
    discountInput.addEventListener('input', updateTotal);
    vatToggle.addEventListener('change', updateTotal);
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\shushin_projects\pharmacy-laravel\resources\views/purchases/create.blade.php ENDPATH**/ ?>