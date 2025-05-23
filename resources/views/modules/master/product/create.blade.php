@extends('layouts.main')

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Products</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Master Data</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Products</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Create</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-body pt-10">
                            <form class="w-[60%]" method="POST" action="{{route('products.save')}}" enctype="multipart/form-data">
                                @csrf
                                <!-- Product Code -->
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Kode</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text" name="code" id="code" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <!-- Product Name -->
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Nama</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text" name="name" id="name" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <!-- Product Category -->
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Kategori</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="category_id">
                                                <option value="">-</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->id }} - {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <!-- Media Section -->
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Media</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="fv-row mb-2">
                                            <label for="media" class="form-label fw-bold fs-6 mb-2">Upload Image</label>
                                            <input type="file" name="media" id="media" class="form-control" accept="image/*" onchange="previewImage(event)" />
                                        </div>
                                        <div class="text-muted fs-7">Upload an image for the product.</div>
                                        <!-- Image Preview -->
                                        <div id="image-preview" class="mt-3" style="display: none;">
                                            <h5>Image Preview:</h5>
                                            <img id="preview-img" src="" alt="Image Preview" class="img-fluid" style="max-width: 300px; border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <!-- Is Active -->
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Is Active</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="is_active">
                                                <option value=""></option>
                                                <option value="1" selected>Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <!-- Submit Button -->
                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{route('products.index')}}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
@endsection

@section('script')
<script>
    // Function to preview the uploaded image
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview-img');
                const previewContainer = document.getElementById('image-preview');
                preview.src = reader.result;
                previewContainer.style.display = 'block'; // Show image preview
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
