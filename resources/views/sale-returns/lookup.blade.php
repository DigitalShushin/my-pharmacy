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
        Sale Returns
    @endslot
@endcomponent

<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Enter Sale ID to Start a Return</h4>
                
            </div><!-- end card header -->

            <div class="card-body">
                
                <div class="live-preview">

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('sale-returns.create') }}" method="GET">
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
@endsection