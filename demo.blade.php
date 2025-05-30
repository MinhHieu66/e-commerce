<tbody>
    @if(Cart::count() > 0) @foreach(Cart::content() as $details)
    <tr id="product-show">
        <td data-th="Product">
            <div class="row">
                <div class="col-sm-3 hidden-xs img-responsive">
                    <img
                        src="img/{!!$details->options->image!!}"
                        width="100"
                        height="100"
                    />
                </div>
                <div class="col-sm-9">
                    <h4 class="nomargin">{{ $details->name }}</h4>
                </div>
            </div>
        </td>
        <td data-th="Price">{{ $details->price }} RON</td>
        <td data-th="Quantity">
            <input
                type="number"
                value="{{ $details->qty }}"
                class="form-control quantity"
                class="quantity"
            />
        </td>
        <td data-th="Subtotal" class="text-center" id="total-price">
            {{ $details->price * $details->qty }} RON
        </td>
        <td class="actions text-center" data-th="">
            <button
                class="btn btn-info btn-sm update-cart"
                data-token="{{ csrf_token() }}"
                data-id="{{ $details->rowId}}"
                style="margin: 10px"
            >
                <i class="fa fa-refresh"></i> Refresh
            </button>
            <button
                class="btn btn-danger btn-sm remove-from-cart"
                data-token="{{ csrf_token() }}"
                data-id="{{ $details->rowId}}"
                style="margin: 10px"
            >
                <i class="fa fa-trash-o"></i>Delete
            </button>
        </td>
    </tr>
    @endforeach @endif
</tbody>


<script>
$(".update-cart").click(function (e) {
    e.preventDefault();
    var ele = $(this);
    $.ajax({
    url: "{{ url('update-cart') }}",
    method: "patch",
    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity:
    ele.parents("tr").find(".quantity").val()},
    success: function (response) {
        window.location.reload();
    }
});
});
</script>

<?php
public function updateCart(Request $request){
    $cart = Cart::content()->where('rowId', $request->id);
    //update quantity
    //dd($cart);
    return view('pages.cart')->with('cart-success', 'Cart updated');
}


