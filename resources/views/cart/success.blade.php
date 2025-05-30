@extends('template.user')
@section("body")
<main class="main-wrapper">

    <!-- Start Checkout Area  -->
    <div class="axil-checkout-area axil-section-gap">
        <div class="container">
            <form action="#">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="axil-checkout-notice">
                            <div class="axil-toggle-box">
                                <div class="toggle-bar"><i class="fas fa-user"></i> Returning customer? <a href="javascript:void(0)" class="toggle-btn">Click here to login <i class="fas fa-angle-down"></i></a>
                                </div>
                                <div class="axil-checkout-login toggle-open">
                                    <p>If you didn't Logged in, Please Log in first.</p>
                                    <div class="signin-box">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <div class="form-group mb--0">
                                            <button type="submit" class="axil-btn btn-bg-primary submit-btn">Sign In</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="axil-toggle-box">
                                <div class="toggle-bar"><i class="fas fa-pencil"></i> Have a coupon? <a href="javascript:void(0)" class="toggle-btn">Click here to enter your code <i class="fas fa-angle-down"></i></a>
                                </div>

                                <div class="axil-checkout-coupon toggle-open">
                                    <p>If you have a coupon code, please apply it below.</p>
                                    <div class="input-group">
                                        <input placeholder="Enter coupon code" type="text">
                                        <div class="apply-btn">
                                            <button type="submit" class="axil-btn btn-bg-primary">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="axil-checkout-billing">
                            <h4 class="title mb--40">Chi tiết thanh toán</h4>
                            <div class="form-group">
                                <label>Họ và tên <span>*</span></label>
                                <input type="text" id="company-name" placeholder="VD: Nguyễn Thị Nở">
                            </div>
                            <div class="form-group">
                                <label for="province">Tỉnh/Thành phố <span>*</span></label>
                                <select id="province" name="province" class="select2">
                                    <option value="">-- Chọn tỉnh/thành phố --</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quận/Huyện <span>*</span></label>
                                <select id="district" name="district">
                                    <option value="">-- Chọn quận/huyện --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Phường/Xã <span>*</span></label>
                                <select id="ward" name="ward">
                                    <option value="">-- Chọn phường/xã --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Số nhà, đường <span>*</span></label>
                                <input type="text" id="address1" class="mb--15" placeholder="VD: 123 Lê Thị Hoa">
                            </div>
                            <div class="form-group">
                                <label>Điện thoại <span>*</span></label>
                                <input type="tel" id="phone">
                            </div>
                            <div class="form-group">
                                <label>Email <span>*</span></label>
                                <input type="email" id="email" placeholder="VD: hp123@gmail.com">
                            </div>
                            <div class="form-group input-group">
                                <input type="checkbox" id="checkbox1" name="account-create">
                                <label for="checkbox1">Create an account</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="axil-order-summery order-checkout-summery">
                            <h5 class="title mb--20">Đơn hàng của bạn</h5>
                            <div class="summery-table-wrap">
                                <table class="table summery-table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Phụ thu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $item)
                                        <tr class="order-product">
                                            <td>{{ $item['name'] }} <span class="quantity">x{{ $item['quantity'] }}</span></td>
                                            <td>{{ number_format($item['price'] * $item['quantity'], 0, ",", ".") }}đ</td>
                                        </tr>
                                        @endforeach
                                        <tr class="order-shipping">
                                            <td colspan="2">
                                                <div class="shipping-amount">
                                                    <span class="title">Phương thức vận chuyển</span>
                                                    <span id="shipping" class="amount">12.000.000đ</span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="radio" id="radio2" name="shipping" checked value="12000">
                                                    <label for="radio2">Tiêu chuẩn</label>
                                                </div>
                                                <div class="input-group">
                                                    <input type="radio" id="radio3" name="shipping" value="35000">
                                                    <label for="radio3">Hỏa tốc</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <td>Tổng tiền:</td>
                                            <input id="subtotal" type="hidden" name="total" value="{{ number_format($totalMoney, 0, ",", ".") }}đ">
                                            <td id="total-amount" class="order-total-amount">{{ number_format($totalMoney, 0, ",", ".") }}đ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="order-payment-method">
                                <div class="single-payment">
                                    <div class="input-group">
                                        <input type="radio" id="radio4" name="payment">
                                        <label for="radio4">Thanh toán khi nhận hàng</label>
                                    </div>
                                    {{-- <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p> --}}
                                </div>
                                <div class="single-payment">
                                    <div class="input-group">
                                        <input type="radio" id="radio5" name="payment" value="momo">
                                        <label for="radio5">Momo</label>
                                    </div>
                                    {{-- <p>Pay with cash upon delivery.</p> --}}
                                </div>
                                <div class="single-payment">
                                    <div class="input-group justify-content-betDirect bank transfween align-items-center">
                                        <input type="radio" id="radio6" name="payment" value="paypal">
                                        <label for="radio6">Paypal</label>
                                        <img src="{{ asset('images/others/payment.png') }}" alt="Paypal payment">
                                    </div>
                                    {{-- <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p> --}}
                                </div>
                            </div>
                            <button type="submit" id="checkoutBtn" class="axil-btn btn-bg-primary checkout-btn">Thanh toán</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="form-momo" class="payment-form" style="display:none;">
    <form action="{{ route('payment.momo') }}" method="POST">
        @csrf
        <input type="hidden" id="momo" name="amount" value="1000000">
        <button type="submit">Thanh toán với Momo</button>
    </form>
    </div>
    <!-- End Checkout Area  -->
    <form action="{{ route("payment.paypal") }}" id="frmCreateOrder" method="post">
        @csrf
        <div class="form-group">
            <label for="amount">Số tiền</label>
            {{-- <p>{{ $totalMoney }}</p> --}}
            {{-- <input class="form-control" data-val="true" data-val-number="The field Amount must be a number." data-val-required="The Amount field is required." id="amount" max="100000000" min="1" name="amount" type="number" value="1000000"/> --}}
            <input class="form-control" id="amount" name="amount" type="number" value="1000000"/>
        </div>
         <h4>Chọn phương thức thanh toán</h4>
        <div class="form-group">
            <h5>Cách 1: Chuyển hướng sang Cổng VNPAY chọn phương thức thanh toán</h5>
           <input type="radio" Checked="True" id="bankCode" name="bankCode" value="">
           <label for="bankCode">Cổng thanh toán VNPAYQR</label><br>
        </div>
        <div class="form-group">
            <h5>Chọn ngôn ngữ giao diện thanh toán:</h5>
             <input type="radio" id="language" Checked="True" name="language" value="vn">
             <label for="language">Tiếng việt</label><br>

        </div>
        <button type="submit" class="btn btn-default" href>Thanh toán</button>
    </form>
</main>
@endsection
<!-- jQuery -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<!-- jQuery JS -->
@section("script")
<script>
    $(document).ready(function() {
        $('#province').change(function () {
        let provinceID = $(this).val();
        $('#district').empty().append('<option value="">-- Chọn quận/huyện --</option>');
        $('#ward').empty().append('<option value="">-- Chọn phường/xã --</option>');

        if (provinceID) {
            $.get('/get-districts/' + provinceID, function (data) {
                $.each(data, function (index, district) {
                    $('#district').append('<option value="' + district.id + '">' + district.name + '</option>');
                });
            });
        }

        $('#district').change(function () {
            let districtID = $(this).val();
            $('#ward').empty().append('<option value="">-- Chọn phường/xã --</option>');
                if (districtID) {
                    $.get('/get-wards/' + districtID, function (data) {
                        $.each(data, function (index, ward) {
                            $('#ward').append('<option value="' + ward.id + '">' + ward.name + '</option>');
                        });
                    });
                }
            });
         });

        function formatCurrency(number) {
            return number.toLocaleString('vi-VN') + "đ";
        }

        function updateTotal() {
            const raw = document.getElementById("subtotal").value;
            const cleaned = raw.replace(/[^\d]/g, "");
            const subtotal = parseInt(cleaned);

            const shipping = parseInt(document.querySelector("input[name='shipping']:checked").value);
            const total = subtotal + shipping;
            document.getElementById("shipping").innerHTML = formatCurrency(shipping);
            document.getElementById("total-amount").innerHTML = formatCurrency(total);
        }

        const shippingRadios = document.querySelectorAll("input[name='shipping']");
        shippingRadios.forEach(radio => {
            radio.addEventListener("change", updateTotal);
        });

        updateTotal();

        document.getElementById("checkoutBtn").addEventListener("click", function () {
            updateTotal();
        });

        $('#frmCreateOrder').hide();
        var rawText = $('#total-amount').text();
        var cleaned = rawText.replace(/[^\d]/g, '');
        var number = parseInt(cleaned, 10);
        $('#amount').val(number);
        $('#momo').val(number);

       $('#checkoutBtn').on('click', function(e){
    e.preventDefault();

    // Lấy phương thức thanh toán được chọn
    var method = $('input[name="payment"]:checked').val();
    console.log(method);
    // Cập nhật action cho form dựa vào lựa chọn
    if (method === 'momo') {
        alert("MOMO");
         $('#form-momo form').submit(); // form Momo
        // $('#frmCreateOrder').attr('action', '{{ route("payment.momo") }}');
    } else if (method === 'paypal') {
        alert("paypal");
        $('#frmCreateOrder').submit();
        // $('#frmCreateOrder').attr('action', '{{ route("payment.paypal") }}');
    }else{
        alert("That bai");
    }
    // Submit form
    // $('#frmCreateOrder').submit();
    });

    });
</script>
@endsection
