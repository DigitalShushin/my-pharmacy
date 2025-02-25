-category-add.blade.php
@extends('layouts.master')
@section('title') Add Category @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Categories @endslot
    @slot('title') Add Category @endslot
@endcomponent

<form id="addcategory-form" action="{{ route('category.store') }}" method="POST" class="needs-validation" novalidate>
    @csrf
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
@endsection