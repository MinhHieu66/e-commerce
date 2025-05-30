@extends("template.admin")
@section("body")
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Create Coupon
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
                                    <li class="breadcrumb-item">Coupons </li>
                                    <li class="breadcrumb-item active">Create Coupon</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="card tab2-card">
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="general" role="tabpanel"
                                    aria-labelledby="general-tab">
                                    {{-- Hiển thị lỗi từ session nếu có --}}
                                    @if(session('error'))
                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <form class="needs-validation" action="{{ route('coupon.postPromotion') }}" method="POST" novalidate="">
                                        @csrf
                                        <h4>General</h4>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                {{-- Tên khuyến mãi --}}
                                                <div class="form-group row">
                                                    <label for="name" class="col-xl-3 col-md-4"><span>*</span> Coupon Name</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                                            id="name" value="{{ old('name') }}" required>
                                                        @error('name')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Mô tả --}}
                                                <div class="form-group row">
                                                    <label for="description" class="col-xl-3 col-md-4">Description</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                                            id="description" value="{{ old('description') }}" required>
                                                        @error('description')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Ngày bắt đầu --}}
                                                <div class="form-group row">
                                                    <label for="start_date" class="col-xl-3 col-md-4">Start Date</label>
                                                    <div class="col-md-7">
                                                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                                                            id="start_date" value="{{ old('start_date') }}">
                                                        @error('start_date')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Ngày kết thúc --}}
                                                <div class="form-group row">
                                                    <label for="end_date" class="col-xl-3 col-md-4">End Date</label>
                                                    <div class="col-md-7">
                                                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                                                            id="end_date" value="{{ old('end_date') }}">
                                                        @error('end_date')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Tỷ lệ chiết khấu --}}
                                                <div class="form-group row">
                                                    <label for="discount_rate" class="col-xl-3 col-md-4">Discount Rate</label>
                                                    <div class="col-md-7">
                                                        <select name="discount_rate" class="form-control @error('discount_rate') is-invalid @enderror" required>
                                                            <option value="">Chọn tỷ lệ</option>
                                                            @foreach([0.05, 0.1, 0.15, 0.2, 0.25, 0.3, 0.35, 0.4, 0.45, 0.5, 0.55, 0.6, 0.65, 0.7, 0.75, 0.8, 0.85, 0.9, 0.95] as $rate)
                                                                <option value="{{ $rate }}" {{ old('discount_rate') == $rate ? 'selected' : '' }}>
                                                                    {{ $rate * 100 }}%
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('discount_rate')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
@endsection