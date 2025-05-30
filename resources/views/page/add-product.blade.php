@extends('template.admin')
@section('body')
<div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Thêm sản phẩm
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
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                                            <input class="form-control" id="validationCustom01" name="name" type="text" value="{{ old('name') }}">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="validationCustomtitle" class="col-form-label pt-0"><span>*</span> SKU</label>
                                            <input class="form-control" id="validationCustomtitle" name="SKU" type="text" value="{{ old('SKU') }}">
                                            @error('SKU')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label categories-basic"><span>*</span>
                                                Danh mục sản phẩm</label>
                                            <select class="custom-select form-control" name="product_category">
                                                @foreach ( $product_categories as  $product_category )
                                                    <option value="{{ $product_category->id }}">{{ $product_category->category_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_category')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="validationCustom02" class="col-form-label"><span>*</span>
                                                Giá sản phẩm</label>
                                            <input class="form-control" id="validationCustom02" name="price" type="text" value="{{ old('price') }}">
                                            @error('price')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="imageInput" class="col-form-label"><span>*</span> Upload ảnh</label>
                                            {{-- <input class="form-control" id="imageInput" name="image" type="file" accept="image/*"> --}}
                                            <input class="form-control" id="imageInput" name="image" type="file">
                                            @error('image')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <img id="previewImage" width="75%" src="">
                                        </div>
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
                                                <textarea id="editor1" name="description" cols="10" rows="4" style="display: none;">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="digital-add needs-validation">
                                        <div class="form-group">
                                            <label for="validationCustom05" class="col-form-label pt-0"><span>*</span>
                                                Số lượng</label>
                                            <input class="form-control" id="validationCustom05" name="qty-in-stock" type="text" value="{{ old('qty-in-stock') }}">
                                            @error('qty-in-stock')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label categories-basic"><span>*</span>
                                                Dung lượng</label>
                                            <select class="custom-select form-control" name="capacity">
                                                @foreach ($capacities as $capacity)
                                                    <option value="{{$capacity->id }}">{{ $capacity->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label categories-basic"><span>*</span>
                                                Màu sắc</label>
                                            <select class="custom-select form-control" name="color">
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}">{{ $color->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="product-buttons">
                                                <button type="submit" class="btn btn-primary">Thêm sản phẩm mới</button>
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
