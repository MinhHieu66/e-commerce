@extends('template.admin')
@section('body')
 <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Product List
                                        <small>Multikart Admin panel</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ol class="breadcrumb pull-right">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">
                                            <i data-feather="home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">Digital</li>
                                    <li class="breadcrumb-item active">Product List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <form class="form-inline search-form search-box">
                                        <div class="form-group">
                                            <input class="form-control-plaintext" type="search" placeholder="Search..">
                                        </div>
                                    </form>

                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-md-0 mt-2">Add New
                                        Product</a>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive table-desi">
                                        <table class="table list-digital all-package table-category "
                                            id="editableTable">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Mô tả</th>
                                                    <th>Danh mục</th>
                                                    <th>SKU</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng trong kho</th>
                                                    <th>Dung lượng - Màu sắc</th>
                                                    <th>Ảnh sản phẩm</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($product_items as $product_item)
                                                <tr>
                                                    {{-- {{ $product_items->currentPage() }} --}}
                                                    <td>{{ ($product_items->currentPage() - 1) * 10 + $loop->iteration }}</td>
                                                    <td>{{ $product_item->product->name }}</td>
                                                    <td class="text-truncate" style="max-width: 300px;">
                                                       {{ $product_item->product->description }}
                                                    </td>
                                                    <td>{{ $product_item->product->product_categories->category_name}}</td>
                                                    <td>{{  $product_item->SKU }}</td>
                                                    <td>{{ number_format($product_item->price, 0, ',', '.') }}</td>
                                                    <td>{{ $product_item->qty_in_stock }}</td>
                                                    <td>
                                                        {{ $product_item->variation_options->pluck('value')->implode(' - ') }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $imagePath = public_path('images/product/electric/' . $product_item->product_image);
                                                        @endphp

                                                        <img src="{{ file_exists($imagePath) ? asset('images/product/electric/' . $product_item->product_image) : asset('images/product/electric/default.png') }}"
                                                            alt="Product Images"
                                                            data-field="image">
                                                        {{-- <img src="{{ asset('images/product/electric/' . $product_item->product->product_image) }}" alt="Product Images"
                                                            data-field="image"> --}}
                                                    </td>
                                                    <td>{{ $product_item->created_at }}</td>
                                                    <td>
                                                       <form action="{{ route('admin.products.destroy', $product_item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm {{ $product_item->product->name }} {{ $product_item->variation_options->pluck('value')->implode(' - ') }}?');" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn" title="Xóa">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        <a href="{{ route('admin.products.edit', $product_item->id) }}">
                                                            <i class="fa fa-edit" title="Edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             {{ $product_items->links('pagination::bootstrap-4') }}
                <!-- Container-fluid Ends-->
            </div>
@endsection
