@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Search for input -->
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (must be loaded first) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1')
        Forms
    @endslot
    @slot('title')
        Sales
    @endslot
@endcomponent

<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Edit Sale</h4>
                
            </div><!-- end card header -->

            <div class="card-body">
                
                <div class="live-preview">
                <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        
                        <!-- Customer's phone number -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Customer's Phone Number</label>
                                <input type="text" name="customer_phone" id="customer_phone" class="form-control" value="{{ old('customer_phone', optional($sale->customer)->phone) }}" required>
                            </div>
                        </div>

                        <!-- Customer's name -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Customer's Name</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name', optional($sale->customer)->name) }}" required>
                            </div>
                        </div>

                        <!-- Customer's address -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="customer_address" class="form-label">Customer's Address</label>
                                <input type="text" name="customer_address" id="customer_address" class="form-control" value="{{ old('customer_address', optional($sale->customer)->address) }}">
                            </div>
                        </div>

                        <!-- Customer's contact person -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="customer_contact" class="form-label">Contact Person</label>
                                <input type="text" name="customer_person" id="customer_person" class="form-control" value="{{ old('contact_person', optional($sale->customer)->contact_person) }}">
                            </div>
                        </div>

                        <!-- Customer's email -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Customer's email</label>
                                <input type="text" name="customer_email" id="customer_email" class="form-control" value="{{ old('customer_email', optional($sale->customer)->email) }}">
                            </div>
                        </div>

                        <!-- Sales Date -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="sales_date" class="form-label">Sales Date</label>
                                <input type="date" name="sales_date" id="sales_date" class="form-control" value="{{ old('sales_date', $sale->sales_date) }}">
                            </div>
                        </div>

                        <!-- Sales Items Table -->
                        <div class="col-12">
                            <table class="table table-bordered" id="salesItemsTable">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <!-- <th>Stock</th> -->
                                        <th>Quantity</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                        <th><button type="button" class="btn btn-sm btn-success" id="addRowBtn">+</button></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($sale->items as $index => $item)
                                    <tr>
                                        <td>
                                            <select name="sales[{{ $index }}][product_id]" class="form-control select2" data-row="{{ $index }}" required>
                                                <option value="" disabled>Select Product</option>
                                                @foreach($products as $product)
                                                    @if($product->stock > 0)
                                                    <option value="{{ $product->id }}"
                                                            data-selling-price="{{ $product->selling_price }}"
                                                            data-stock="{{ $product->stock }}"
                                                            {{ old("sales.$index.product_id", $item->product_id) == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }} (In Stock: {{ $product->stock }})
                                                    </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" name="sales[{{ $index }}][quantity]" class="form-control" data-row="{{ $index }}" required value="{{ old("sales.$index.quantity", $item->quantity) }}"></td>
                                        <td><input type="text" name="sales[{{ $index }}][rate]" class="form-control" data-row="{{ $index }}" value="{{ old("sales.$index.rate", $item->rate) }}" readonly></td>
                                        <td><input type="text" name="sales[{{ $index }}][amount]" class="form-control" data-row="{{ $index }}" value="{{ old("sales.$index.amount", $item->quantity * $item->rate) }}"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger removeRowBtn">-</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                    
                            </table>
                        </div>

                        <div class="col-md-12 d-flex justify-content-between">
                            <div class="col-md-6">
                                <!-- Left Column (empty or use as needed) -->
                            </div>

                            <div class="col-md-6">

                                <!-- Financials -->
                                <div class="d-flex align-items-center mb-3">
                                    <label for="totalAmount" class="form-label me-2" style="min-width: 120px;">Net Amount</label>
                                    <input type="text" name="net_amount" class="form-control" id="netamountInput" value="{{ old('net_amount', $sale->net_amount) }}">
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <label for="discount_percent" class="form-label me-2">Discount Percentage (%)</label>
                                    <input type="number" name="discount_percent" class="form-control" min="0" max="100" step="0.01" value="{{ old('discount_percentage', $sale->discount_percentage ?? '') }}" id="discountPercentage">
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <label for="totalAmount" class="form-label me-2" style="min-width: 120px;">Discount</label>
                                    <input type="text" name="discount" class="form-control" value="{{ old('discount', $sale->discount) }}" id="discountNumber">
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <label for="totalAmount" class="form-label me-2" style="min-width: 120px;">Total Amount</label>
                                    <input type="text" name="total_amount" class="form-control" id="totalAmount" value="{{ old('total_amount', $sale->total_amount) }}">
                                </div>        

                                <!-- Submit -->
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
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

<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

<!--jquery cdn-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!--select2 cdn-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ URL::asset('build/js/pages/select2.init.js') }}"></script>

<script src="{{ URL::asset('build/js/app.js') }}"></script>

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

<script>
$(document).ready(function () {
    let tableBody = $('#salesItemsTable tbody');
    let rowIndex = tableBody.find('tr').length;

    // Initialize Select2
    function initSelect2(selectElement) {
        selectElement.select2({
            width: '100%',
            placeholder: 'Select Product',
            allowClear: true
        });
    }

    // Recalculate total
    function calculateNetTotal() {
        let netAmount = 0;
        tableBody.find('tr').each(function () {
            const amount = parseFloat($(this).find('input[name*="[amount]"]').val()) || 0;
            netAmount += amount;
        });

    //     $('#netamountInput').val(netAmount.toFixed(2));
    //     const discount = parseFloat($('#discountNumber').val()) || 0;
    //     const totalAmount = (netAmount - discount).toFixed(2);
    //     $('#totalAmount').val(totalAmount);
    // }

        $('#netamountInput').val(netAmount.toFixed(2));
        const discountPercentage = parseFloat($('#discountPercentage').val()) || 0;

        const discount = parseFloat($('#discountNumber').val()) || 0;
        
        const totalAmount = (netAmount - discount).toFixed(2);
        $('#totalAmount').val(totalAmount);
    }

    $('#discountPercentage').on('input', function () {
        const netAmount = parseFloat($('#netamountInput').val()) || 0;
        const discountPercentage = parseFloat($(this).val()) || 0;

        const discountAmount = (netAmount * discountPercentage / 100).toFixed(2);
        $('#discountNumber').val(discountAmount);

        const totalAmount = (netAmount - discountAmount).toFixed(2);
        $('#totalAmount').val(totalAmount);
    });

    $('#discountNumber').on('input', function () {
        const netAmount = parseFloat($('#netamountInput').val()) || 0;
        const discountAmount = parseFloat($(this).val()) || 0;

        const discountPercentage = ((discountAmount / netAmount) * 100).toFixed(2);
        $('#discountPercentage').val(discountPercentage);

        const totalAmount = (netAmount - discountAmount).toFixed(2);
        $('#totalAmount').val(totalAmount);
    });

    // Ajax for Cutomer field 
    $(document).ready(function () {
        $('#customer_phone').on('keyup', function () {
            let phone = $(this).val();

            if (phone === '') {
                // Clear all fields if phone input is empty
                $('#customer_name, #customer_address, #customer_email, #customer_person').val('');
                return;
            }

            $.ajax({
                url: '/sales/customer-by-phone',
                method: 'GET',
                data: { phone: phone },
                success: function (data) {
                    // Check if data is empty object or indicates no customer
                    if (!data || Object.keys(data).length === 0 || data.found === false) {
                        // no customer found - clear fields
                        $('#customer_name, #customer_address, #customer_email, #customer_person').val('');
                    } else {
                        // customer found - fill fields
                        $('#customer_name').val(data.name || '');
                        $('#customer_address').val(data.address || '');
                        $('#customer_email').val(data.email || '');
                        $('#customer_person').val(data.contact_person || '');
                    }
                }
                
            });
        });
    });

    // Attach logic to row
    function attachEventListeners(row) {
        row.find('select[name*="[product_id]"]').on('change', function () {
            const selectedOption = $(this).find('option:selected');
            const sellingPrice = parseFloat(selectedOption.data('selling-price')) || 0;

            row.find('input[name*="[rate]"]').val(sellingPrice.toFixed(2)).trigger('input');

            if (typeof updateSelectOptions === 'function') {
                updateSelectOptions();
            }
        });

        // row.find('input[name*="[quantity]"], input[name*="[rate]"]').on('input', function () {
        //     const qty = parseFloat(row.find('input[name*="[quantity]"]').val()) || 0;
        //     const rate = parseFloat(row.find('input[name*="[rate]"]').val()) || 0;
        //     const amount = (qty * rate).toFixed(2);
        //     row.find('input[name*="[amount]"]').val(amount);
        //     calculateNetTotal();
        // });

        row.find('input[name*="[quantity]"], input[name*="[rate]"]').on('input', function () {
            const qtyInput = row.find('input[name*="[quantity]"]');
            const qty = parseFloat(qtyInput.val()) || 0;
            const rate = parseFloat(row.find('input[name*="[rate]"]').val()) || 0;

            // Stock check
            const select = row.find('select[name*="[product_id]"]');
            const selectedOption = select.find('option:selected');
            const stock = parseInt(selectedOption.data('stock')) || 0;

            if (qty > stock) {
                alert(`Only ${stock} units are in stock.`);
                qtyInput.val(stock);
            }

            const finalQty = parseFloat(qtyInput.val()) || 0;
            const amount = (finalQty * rate).toFixed(2);
            row.find('input[name*="[amount]"]').val(amount);

            calculateNetTotal();
        });
    }

    // Disable duplicate products across rows
    function updateSelectOptions() {
        let selectedValues = [];
        tableBody.find('select[name*="[product_id]"]').each(function () {
            if ($(this).val()) selectedValues.push($(this).val());
        });

        tableBody.find('select[name*="[product_id]"]').each(function () {
            const currentVal = $(this).val();
            $(this).find('option').each(function () {
                const optVal = this.value;
                // this.disabled = selectedValues.includes(optVal) && optVal !== currentVal;
            });
        });
    }

    // Add new row
    $('#addRowBtn').on('click', function () {
        const lastRow = tableBody.find('tr:last');

        // Destroy existing Select2 to prevent duplication
        lastRow.find('select').select2('destroy');

        const newRow = lastRow.clone();

        newRow.find('input, select').each(function () {
            let name = $(this).attr('name');
            if (name) {
                name = name.replace(/\[\d+\]/, `[${rowIndex}]`);
                $(this).attr('name', name).attr('data-row', rowIndex);
            }

            // Reset values
            if ($(this).is('select')) {
                $(this).val(null); // Clear value
            } else {
                $(this).val('');
            }
        });

        // Clean up any Select2 artifacts
        newRow.find('select').each(function () {
            $(this).removeClass('select2-hidden-accessible')
                .removeAttr('data-select2-id')
                .removeAttr('aria-hidden')
                .next('.select2').remove();
        });

        tableBody.append(newRow);

        const appendedRow = tableBody.find('tr').last();
        initSelect2(appendedRow.find('select'));
        attachEventListeners(appendedRow);
        updateSelectOptions();

        rowIndex++;
    });

    // Remove row
    tableBody.on('click', '.removeRowBtn', function () {
        if (tableBody.find('tr').length > 1) {
            $(this).closest('tr').remove();
            calculateNetTotal();
            updateSelectOptions();
        }
    });

    // Recalculate on discount input
    // $('#discountNumber').on('input', function () {
    //     calculateNetTotal();
    // });

    // Initialize first row
    const firstRow = tableBody.find('tr:first');
    initSelect2(firstRow.find('select'));
    attachEventListeners(firstRow);
    updateSelectOptions();
});
</script>

@endsection
