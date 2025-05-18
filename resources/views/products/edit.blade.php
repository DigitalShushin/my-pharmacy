@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Forms
        @endslot
        @slot('title')
            Product / Medicine
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add Product / Medicine</h4>
                    
                </div><!-- end card header -->

                <div class="card-body">
                    
                    <div class="live-preview">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- This is critical -->

                        <div class="row">
                            <!-- Company Name -->
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="companySelect" class="form-label">Company Name</label>
                                    <select class="form-control select2" name="company_id" id="companySelect" required>
                                    <option value="" disabled selected>Select a company</option>

                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" 
                                            {{ (old('company_id', $product->company_id) == $company->id) ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>

                                        @foreach($company->children as $child)
                                            <option value="{{ $child->id }}" 
                                                {{ (old('company_id', $product->company_id) == $child->id) ? 'selected' : '' }}>
                                                &nbsp; {{ $child->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            

                            <!-- Medicine Name -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contactNameinput" class="form-label">Medicine Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter medicine name" id="nameinput" value="{{ $product->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="col-md-1">
                                <div class="mb-3">
                                    <label for="contactNameinput" class="form-label">&nbsp;</label>
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


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#companySelect').select2();
    });
</script>

@endsection
