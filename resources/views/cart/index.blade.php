@extends("template.user")
@section("body")
<main class="main-wrapper">

    <!-- Start Cart Area  -->
    <div class="axil-product-cart-area axil-section-gap">
        <from action="" method="POST">
            @csrf
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
                                    <td class="product-quantity" data-title="Qty">
                                        <div class="pro-qty">
                                            <span class="dec qtybtn" data-token="{{ csrf_token() }}" data-id="{{ $item['product_item_id']}}">-</span>
                                            <input type="number" class="quantity-input" value="{{ $item['quantity'] }}">
                                            <span class="inc qtybtn" data-token="{{ csrf_token() }}" data-id="{{ $item['product_item_id']}}">+</span>
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
                                <h5 class="title mb--20">Order Summary</h5>
                                <div class="summery-table-wrap">
                                    <table class="table summery-table mb--30">
                                        <tbody>
                                            <tr class="order-subtotal">
                                                <td>Subtotal</td>
                                                <td class="cart-total">{{ number_format($totalMoney, 0, ",", ".") }} đ</td>
                                            </tr>
                                            <tr class="order-shipping">
                                                <td>Shipping</td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="radio" id="radio1" name="shipping" checked>
                                                        <label for="radio1">Free Shippping</label>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="radio" id="radio2" name="shipping">
                                                        <label for="radio2">Local: $35.00</label>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="radio" id="radio3" name="shipping">
                                                        <label for="radio3">Flat rate: $12.00</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="order-tax">
                                                <td>State Tax</td>
                                                <td>$8.00</td>
                                            </tr>
                                            <tr class="order-total">
                                                <td>Total</td>
                                                <td class="order-total-amount">$125.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="checkout.html" class="axil-btn btn-bg-primary checkout-btn">Process to Checkout</a>
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
            $.ajax({
                url: "/cart/" + ele.attr("data-id"),
                method: "patch",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity:
                ele.parents("tr").find(".quantity-input").val()},
                success: function (response) {
                    $(".item-total").text(response.item_total_formatted);
                    $(".cart-total").text(response.cart_total_formatted);
                },
                error: function (xhr) {
                console.log(xhr.responseText);
                }
            });
        });
    });
</script>
