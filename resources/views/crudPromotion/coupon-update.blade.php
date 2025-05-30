@extends("template.admin")
@section("body")
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Cập nhật chương trình khuyến mãi
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
                                    <li class="breadcrumb-item">Chương trình khuyến mãi </li>
                                    <li class="breadcrumb-item active">Cập nhật chương trình</li>
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
                                    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
                                    <form class="needs-validation" action="{{ route('coupon.postUpdatePromotion', ['id' => $promotion->id]) }}" method="POST" novalidate="">
                                        @csrf
                                        <h4>Chung</h4>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="hidden" name="updated_at" value="{{ $promotion->updated_at->format('Y-m-d H:i:s') }}">
                                                {{-- Tên khuyến mãi --}}
                                                <div class="form-group row">
                                                    <label for="name" class="col-xl-3 col-md-4">Tên chương trình</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                                            id="name" value="{{$promotion->name}}">
                                                        @error('name')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Mô tả --}}
                                                <div class="form-group row">
                                                    <label for="description" class="col-xl-3 col-md-4">Mô tả</label>
                                                    <div class="col-md-7">
                                                        <textarea id="editor1" name="description" cols="10" rows="4" style="display: none;"> {{ old('description', $promotion->description) }}</textarea>
                                                        @error('description')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                        {{-- <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                                            id="description" value="{{$promotion->description}}">
                                                        @error('description')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror --}}
                                                    </div>
                                                </div>

                                                {{-- Ngày bắt đầu --}}
                                                <div class="form-group row">
                                                    <label for="start_date" class="col-xl-3 col-md-4">Start Date</label>
                                                    <div class="col-md-7">
                                                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                                                            id="start_date" value="{{ $promotion->start_date ? \Carbon\Carbon::parse($promotion->start_date)->format('Y-m-d') : '' }}">

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
                                                            id="end_date" value="{{ $promotion->end_date ? \Carbon\Carbon::parse($promotion->end_date)->format('Y-m-d') : '' }}">

                                                        @error('end_date')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Tỷ lệ chiết khấu --}}
                                                <div class="form-group row">
                                                    <label for="discount_rate" class="col-xl-3 col-md-4">Discount Rate</label>
                                                    <div class="col-md-7">
                                                        <select name="discount_rate" class="form-control @error('discount_rate') is-invalid @enderror">
                                                            <option value="">Chọn tỷ lệ</option>
                                                            @foreach([0.05, 0.1, 0.15, 0.2, 0.25, 0.3, 0.35, 0.4, 0.45, 0.5, 0.55, 0.6, 0.65, 0.7, 0.75, 0.8, 0.85, 0.9, 0.95] as $rate)
                                                                <option value="{{ $rate }}" {{ $promotion->discount_rate == $rate ? 'selected' : '' }}>
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