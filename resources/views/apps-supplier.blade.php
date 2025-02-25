@extends('layouts.master')
@section('title') suppliers @endsection
@section('css')
<!-- jsvectormap css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

<!-- gridjs css -->
<link rel="stylesheet" href="{{URL::asset('build/libs/gridjs/theme/mermaid.min.css')}}">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Dashboards @endslot
@slot('title') Suppliers @endslot 
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row g-4 align-items-center">
                    <div class="col-sm-auto">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title mb-0 flex-grow-1 mx-1">Suppliers</h4>
                            <a href="/admin/supplier/add" class="btn btn-primary">Add New</a>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="d-flex justify-content-sm-end">
                            <div class="search-box ms-2">
                                <input type="text" class="form-control" id="searchResultList" placeholder="Search for Suppliers...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="recomended-category" class="table-card"></div>
                <script id="category-data" type="application/json">
                    <!-- {!! json_encode($suppliers) !!} -->
                </script>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection
@section('script')
<!-- apexcharts -->
<script src="{{URL::asset('build/libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- Vector map-->
<script src="{{URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
<!-- gridjs js -->
<script src="{{URL::asset('build/libs/gridjs/gridjs.umd.js')}}"></script>

<!-- Dashboard init -->
<script src="{{ asset('build/js/pages/category.init.js') }}"></script>

<!-- App js -->
<script src="{{URL::asset('build/js/app.js')}}"></script>
@endsection