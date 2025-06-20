@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />


@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Forms
        @endslot
        @slot('title')
            Suppliers
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Edit Supplier</h4>
                    
                </div><!-- end card header -->

                <div class="card-body">
                    
                    <div class="live-preview">
                    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Use PUT for updating -->

                    <div class="row">
                        <!-- Supplier Name -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="companyNameinput" class="form-label">Supplier Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Supplier name" id="supplierNameinput" value="{{ $supplier->name }}" required>
                            </div>
                        </div>

                        <!-- Contact Person -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contactNameinput" class="form-label">Contact Person</label>
                                <input type="text" class="form-control" name="contact_person" placeholder="Enter contact person's name" id="contactNameinput" value="{{ $supplier->contact_person }}">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phonenumberInput" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" placeholder="+(245) 451 45123" id="phonenumberInput" value="{{ $supplier->phone }}" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="emailidInput" class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" placeholder="example@gmail.com" id="emailidInput" value="{{ $supplier->email }}">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="address1ControlTextarea" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Address 1" id="address1ControlTextarea" value="{{ $supplier->address }}" required>
                            </div>
                        </div>

                        <!-- Companies Array (checkboxes) -->
                        <div class="col-lg-12">
                            <h6 class="fw-semibold">Companies Array</h6>
                            <div class="border p-3 rounded bg-light">
                                <div class="row">
                                    @if($companies->has(null))
                                        @foreach($companies[null] as $parent)
                                            <div class="col-md-3 mb-3">
                                                <!-- Parent checkbox -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="companies_array[]"
                                                        value="{{ $parent->id }}" id="company_parent_{{ $parent->id }}"
                                                        {{ in_array($parent->id, $selectedCompanies ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="company_parent_{{ $parent->id }}">
                                                        {{ $parent->name }}
                                                    </label>
                                                </div>

                                                @if($companies->has($parent->id))
                                                    <div class="row ms-1">
                                                        @foreach($companies[$parent->id] as $child)
                                                            <div class="col-12">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="companies_array[]"
                                                                        value="{{ $child->id }}" id="company_{{ $child->id }}"
                                                                        {{ in_array($child->id, $selectedCompanies ?? []) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="company_{{ $child->id }}">
                                                                        {{ $child->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>


                        <!-- Pan Number -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="panNumber" class="form-label">Pan Number</label>
                                <input type="text" class="form-control" name="pan_number" placeholder="Enter Pan number" id="panNumber" value="{{ $supplier->pan_number }}">
                            </div>
                        </div>

                        <!-- Registration Number -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="registrationNumber" class="form-label">Registration Number</label>
                                <input type="text" class="form-control" name="registration_number" placeholder="Enter registration number" id="registrationNumber" value="{{ $supplier->registration_number }}">
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


@endsection
