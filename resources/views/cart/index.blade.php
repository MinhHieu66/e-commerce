@extends("template.user")
@section("body")
<main class="main-wrapper">

    <!-- Start Cart Area  -->
    <div class="axil-product-cart-area axil-section-gap">
        <from action="" method="POST">
            @csrf
            <input type="hidden" name="shipping_fee" id="shipping_fee">
            <input type="hidden" name="total_amount" id="total_amount_value">
            <div class="container">
                <div class="axil-product-cart-wrap">
                    <div class="product-table-heading">
                        <h4 class="title">Your Cart</h4>
                        <a href="#" class="cart-clear">Clear Shoping Cart</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table axil-product-table axil-cart-table mb--40">
                            <thead>
                                <tr>
                                    <th scope="col" class="product-remove"></th>
                                    <th scope="col" class="product-thumbnail">Hình ảnh</th>
                                    <th scope="col" class="product-title">Tên sản phẩm</th>
                                    <th scope="col" class="product-price">Giá</th>
                                    <th scope="col" class="product-quantity">Số lượng</th>
                                    <th scope="col" class="product-subtotal">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $item)
                                <tr >
                                    <td class="product-remove">
                                        <form action="{{ route('cart.destroy', $item['product_item_id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><i class="fal fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                    <td class="product-thumbnail"><a href="single-product.html"><img src="images/product/electric/{{ $item['image'] }}" alt="Digital Product"></a></td>
                                    <td class="product-title"><a href="single-product.html">{{ $item['name'] }}</a></td>
                                    <td class="product-price" data-title="Price">{{ number_format($item['price'], 0, ",", ".") }} đ</td>
                                    <td class="product-quantity quantity-control" data-title="Qty" data-id="{{ $item['product_item_id'] }}" data-token="{{ csrf_token() }}">
                                        <div class="pro-qty">
                                            <input type="number" class="quantity-input" value="{{ $item['quantity'] }}">
                                        </div>
                                    </td>
                                    <td class="product-subtotal item-total" data-title="Subtotal">{{ number_format($item['total'], 0, ",", ".") }} đ</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="cart-update-btn-area">
                        <div class="input-group product-cupon">
                            <input placeholder="Enter coupon code" type="text">
                            <div class="product-cupon-btn">
                                <button type="submit" class="axil-btn btn-outline">Apply</button>
                            </div>
                        </div>
                        <div class="update-btn">
                            <a href="#" class="axil-btn btn-outline">Update Cart</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 offset-xl-7 offset-lg-5">
                            <div class="axil-order-summery mt--80">
                                <div class="summery-table-wrap">
                                    <table class="table summery-table mb--30">
                                        <tbody>
                                            <tr class="order-subtotal">
                                                <td>Tạm tính</td>
                                                <td style="font-size: 23px" id="subtotal" class="cart-total">{{ number_format($totalMoney, 0, ",", ".") }} đ</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" id="checkoutBtn"><a href="{{ route('cart.success') }}" class="axil-btn btn-bg-primary checkout-btn">Thanh toán ngay</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </from>

    </div>
    <!-- End Cart Area  -->

</main>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".qtybtn").on("click", function (e) {
            e.preventDefault();
            var ele = $(this);
            var row = ele.closest("tr");
            var parent = ele.closest(".quantity-control"); // lấy thẻ cha chứa data-id và data-token
            console.log(parent.attr("data-id"));
            $.ajax({
                url: "/cart/" + parent.attr("data-id"),
                method: "patch",
                data: {_token: '{{ csrf_token() }}', id: parent.attr("data-id"), quantity:
                ele.parents("tr").find(".quantity-input").val()},
                success: function (response) {
                    // chỉ update item-total trong dòng hiện tại
                    row.find(".item-total").text(response.item_total_formatted);
                    $(".cart-total").text(response.cart_total_formatted);
                },
                error: function (xhr) {
                console.log(xhr.responseText);
                }
            });
        });
    });
</script>




