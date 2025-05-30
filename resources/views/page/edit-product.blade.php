@extends('template.admin')
@section('body')
<div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Cập nhật sản phẩm
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ol class="breadcrumb pull-right">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">Digital</li>
                                    <li class="breadcrumb-item active">Add Product</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                <!-- Container-fluid starts-->
                <form action="{{ route('admin.products.update', ["id" => $product_item->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="updated_at" value="{{ $product_item->updated_at }}">
                <div class="container-fluid">
                    <div class="row product-adding">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Thông tin chung</h5>
                                </div>
                                <div class="card-body">
                                    <div class="digital-add needs-validation">
                                        <div class="form-group">
                                            <label for="validationCustom01" class="col-form-label pt-0"><span>*</span>
                                                Tên sản phẩm</label>
                                            <input class="form-control" id="validationCustom01" value="{{ $product_item->product->name }}" name="name" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label for="validationCustomtitle" class="col-form-label pt-0"><span>*</span> SKU</label>
                                            <input class="form-control" id="validationCustomtitle" value="{{  $product_item->SKU }}" name="SKU" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label categories-basic"><span>*</span>
                                                Danh mục sản phẩm</label>
                                            <select class="custom-select form-control" name="product_category">
                                                @foreach ( $product_categories as  $product_category )
                                                   <option {{ $product_item->product->product_categories->id == $product_category->id ? 'selected' : '' }} value="{{ $product_category->id }}">
                                                        {{ $product_category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="validationCustom02" class="col-form-label"><span>*</span>
                                                Giá sản phẩm</label>
                                            <input class="form-control" id="validationCustom02" value="{{ $product_item->price }}" name="price" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label for="imageInput" class="col-form-label"><span>*</span> Upload ảnh</label>
                                            <input class="form-control" id="imageInput" name="image" type="file" accept="image/*">
                                        </div>
                                        <div class="form-group">
                                            <img id="previewImage" width="75%" src="{{ asset('images/product/electric/laptop_1.png') }}">
                                        </div>
                                        {{-- <label class="col-form-label pt-0"> Upload ảnh</label>
                                        <form class="dropzone digits dz-clickable" id="singleFileUpload" action="https://themes.pixelstrap.com/upload.php">
                                            <div class="dz-message needsclick"><i class="fa fa-cloud-upload"></i>
                                                <h4 class="mb-0 f-w-600">Chọn ảnh từ máy</h4>
                                            </div>
                                        </form> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Mô tả sản phẩm</h5>
                                </div>
                                <div class="card-body">
                                    <div class="digital-add needs-validation">
                                        <div class="form-group mb-0">
                                            <div class="description-sm">
                                                <textarea id="editor1" name="editor1" cols="10" rows="4" style="display: none;"> {{ $product_item->product->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="digital-add needs-validation">
                                        <div class="form-group">
                                            <label for="validationCustom05" class="col-form-label pt-0">
                                                Số lượng</label>
                                            <input class="form-control" id="validationCustom05" value="{{ $product_item->qty_in_stock }}" name="qty-in-stock" type="text">
                                        </div>
                                        <div class="form-group">
                                            @php
                                                $selectedOptionIds = collect($product_item->product_configurations)->pluck('variation_option_id')->toArray();
                                            @endphp
                                            <label class="col-form-label categories-basic"><span>*</span>
                                                Dung lượng</label>
                                                {{-- <p>{{ $product_item->product_configurations }}</p> --}}
                                            <select class="custom-select form-control" name="capacity">
                                                @foreach ($capacities as $capacity)
                                                    <option value="{{ $capacity->id }}" {{ in_array($capacity->id, $selectedOptionIds) ? 'selected' : '' }}>
                                                        {{ $capacity->value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label categories-basic"><span>*</span>
                                                Màu sắc</label>
                                            <select class="custom-select form-control" name="color">
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}" {{ in_array($color->id, $selectedOptionIds) ? 'selected' : '' }}>
                                                        {{ $color->value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="product-buttons">
                                                <button type="submit" class="btn btn-primary">Cập sản phẩm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <!-- Container-fluid Ends-->
            </div>
@endsection

{{-- @if (Session::has('message'))
    <script>
        toastr.options = {
            "progressBar": true,
            "closeButton": true,
        };

        var type = "{{ Session::get('alert-type', 'info') }}";
        var message = "{{ Session::get('message') }}";
       alert(type + ': ' + message);
        switch(type){
            case 'info':
                toastr.info(message);
                break;
            case 'success':
                toastr.success(message);
                break;
            case 'warning':
                toastr.warning(message);
                break;
            case 'error':
                toastr.error(message);
                break;
        }
    </script>
@endif --}}
