@extends("template.admin")
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section("body")
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>List Coupons
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
                        <li class="breadcrumb-item">Coupons</li>
                        <li class="breadcrumb-item active">List Coupons</li>
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
                        {{-- <form class="form-inline search-form search-box">
                            <div class="form-group">
                                <input class="form-control-plaintext" type="search" placeholder="Search..">
                            </div>
                        </form> --}}
                        {{-- <form action="{{ route('coupon.search') }}" method="GET">
                            <input type="text" name="search" placeholder="Tìm kiếm">
                            <button type="submit">Tìm</button>
                        </form> --}}
                        <form action="{{ route('coupon.search') }}" method="GET" class="d-flex align-items-center mb-3">
                            <div class="input-group w-100">
                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm mã giảm giá..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">Tìm</button>
                            </div>
                        </form>

                        <a href="{{ route('coupon.create') }}" class="btn btn-primary mt-md-0 mt-2">Add New Coupon</a>
                    </div>

                    <div class="card-body">
                        {{-- @if(session('success'))
    <div id="alertBox" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span> <!-- nút X -->
        </button>
    </div>
@endif

@if(session('error'))
    <div id="alertBox" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span> <!-- nút X -->
        </button>
    </div>
@endif --}}

                        <div>
                            <div class="table-responsive table-desi">
                                <table class="all-package coupon-table table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                Thao tác
                                            </th>
                                            <th>Tên giảm giá</th>
                                            <th>Mô tả</th>
                                            <th>Tỷ lệ</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($promotions as $promotion)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('coupon.updatePromotion', ['id' => $promotion->id]) }}">Edit</a> | 
                                                    <a href="{{ route('coupon.deletePromotion', ['id'=>$promotion->id]) }}" class="text-danger btn-delete"
   data-name="{{ $promotion->name }}">Delete</a>
                                                </td>

                                                <td>{{ $promotion->name}}</td>
                                                <td>{{ $promotion->description}}</td>
                                                <td>{{ $promotion->discount_rate * 100 }}%</td>                                              

                                                <td class="order-warning">
                                                    <span>Waiting</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>                                
                            </div>
                            <!-- Hiển thị phân trang -->
                            <div class="d-flex justify-content-center mt-4">
    <nav aria-label="Page navigation">
        {!! $promotions->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>
</div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

@endsection

@section('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // js hộp thoại xác nhận xóa
        document.querySelectorAll('.btn-delete').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault(); // Ngăn việc chuyển trang ngay lập tức

            const href = this.getAttribute('href'); // Lấy đường dẫn xóa
            const name = this.getAttribute('data-name'); // Tên chương trình

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa?',
                text: `Chương trình "${name}" sẽ bị xóa vĩnh viễn!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Chuyển hướng thủ công nếu người dùng xác nhận
                    window.location.href = href;
                }
            });
        });
    });
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>
@endsection
