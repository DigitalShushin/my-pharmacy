@extends('layouts.master')
@section('title') Categories @endsection
@section('css')
<!-- jsvectormap css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

<!-- gridjs css -->
<link rel="stylesheet" href="{{URL::asset('build/libs/gridjs/theme/mermaid.min.css')}}">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Dashboards @endslot
@slot('title') Categories @endslot 
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row g-4 align-items-center">
                    <div class="col-sm-auto">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title mb-0 flex-grow-1 mx-1">Categories</h4>
                            <button class="btn btn-primary">Add New</button>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="d-flex justify-content-sm-end">
                            <div class="search-box ms-2">
                                <input type="text" class="form-control" id="searchResultList" placeholder="Search for categories...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <form action="/admin/category/edit-process" method="post" enctype="multipart/form-data"> 
            <!-- Hidden field to store the category ID -->
            <input type="hidden" name="id" value="<?= esc($category['id']); ?>">
            <div class="card">
                <div class="card-body">    
                    <div class="row">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Parent Category Selection -->
                        <div class="col-md-6">
                            <label for="parent_id" class="form-label">Parent Category:</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">Select Parent Category</option>
                                <?php foreach ($parentCategories as $parentCategory): ?>
                                    <option value="<?= esc($parentCategory['id']) ?>" <?= (isset($category['parent_id']) && $category['parent_id'] == $parentCategory['id']) ? 'selected' : '' ?>>
                                        <?= esc($parentCategory['category_title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Slug Field -->
                        <div class="col-md-6">
                            <label for="slug" class="form-label">Slug:</label>
                            <input type="text" name="slug" id="slug" class="form-control" value="<?= esc($category['slug'] ?? '') ?>">
                        </div>

                        <div class="col-md-6">
                        <!-- Category Title -->
                        <div class="col-md-12">
                            <label for="category_title" class="form-label">Category Title:</label>
                            <input type="text" name="category_title" id="category_title" class="form-control" value="<?= esc($category['category_title'] ?? '') ?>">
                        </div>

                        <!-- Category Description -->
                        <div class="col-md-12">
                            <label for="category_description" class="form-label">Category Description:</label>
                            <textarea name="category_description" id="category_description" class="form-control" rows="6"><?= esc($category['category_description'] ?? '') ?></textarea>
                        </div>

                        </div>

                        <!-- Category Image -->
                       <!-- <div class="col-md-6">
                            <label for="category_image" class="form-label">Category Image:</label>
                            <?php if (!empty($category['category_image'])): ?>
                                <img src="<?= base_url('uploads/' . esc($category['category_image'])) ?>" alt="Category Image" style="max-width: 75px;">
                            <?php endif; ?>
                            <input type="file" name="category_image" id="category_image" class="form-control">
                            
                        </div> -->

                        <div class="col-md-6">

                                            <label for="category_image" class="form-label">Category Image:</label>



                                            <!-- Image preview, which will be clickable to trigger file input -->

                                             

                                            <img id="category_image_preview" 

                                                src="<?= !empty($category['category_image']) ? base_url('uploads/' . esc($category['category_image'])) : base_url('path/to/placeholder-image.jpg') ?>" 

                                                alt="Set category image" 

                                                style="max-width: 210px; cursor: pointer; display: block;" class="form-control">



                                            <!-- Hidden file input field -->

            <input type="file" name="category_image" id="category_image" style="display: none;">

       <!-- Remove Image link, hidden by default -->
<a href="#" id="remove_image_link" style="color: red; text-decoration: underline; display: <?= empty($category['category_image']) ? 'none' : 'inline'; ?>;">
    Remove Image
</a>                         





    <script>
                                        document.getElementById('category_image_preview').onclick = function() {
                                            document.getElementById('category_image').click();
                                        };

                                        document.getElementById('category_image').onchange = function(event) {
                                            const [file] = event.target.files;
                                            if (file) {
                                                // Show the uploaded image preview
                                                document.getElementById('category_image_preview').src = URL.createObjectURL(file);

                                                // Show the "Remove Image" link
                                                document.getElementById('remove_image_link').style.display = 'inline';
                                            }
                                        };

                                        // Handle image removal
                                        document.getElementById('remove_image_link').onclick = function(event) {
                                            event.preventDefault(); // Prevent default link behavior

                                            // Reset the image preview to the placeholder
                                            document.getElementById('category_image_preview').src = '<?= base_url('path/to/placeholder-image.jpg') ?>';

                                            // Hide the "Remove Image" link
                                            document.getElementById('remove_image_link').style.display = 'none';

                                            // Clear the file input field value
                                            document.getElementById('category_image').value = '';

                                            // Add a hidden input to indicate the image should be removed
                                            const removeImageInput = document.createElement('input');
                                            removeImageInput.type = 'hidden';
                                            removeImageInput.name = 'remove_image';
                                            removeImageInput.value = '1';
                                            document.forms[0].appendChild(removeImageInput);
                                        };
                                    </script>
                        
                        

                       

                        
                                    </div>
                        <!-- Meta Keywords -->
                        <div class="col-md-6">
                            <label for="meta_keywords" class="form-label">Meta Keywords:</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="<?= esc($category['meta_keywords'] ?? '') ?>">
                        </div>

                        <!-- Meta Description -->
                        <div class="col-md-6">
                            <label for="meta_description" class="form-label">Meta Description:</label>
                            <textarea name="meta_description" id="meta_description" class="form-control"><?= esc($category['meta_description'] ?? '') ?></textarea>
                        </div>

                        <!-- Save Button -->
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
            
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection

       