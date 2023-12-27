@extends('client.layouts.app')
@section('title', 'Cart  ')
@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('client.home') }}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shopping Cart</p>
        </div>
    </div>
</div>
<!-- Page Header End -->
<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Image</th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @php
                        if(!session('cart')){
                            $subtotal = 0;
                            $total = 0;
                        }else {
                            $subtotal = 0;
                            $total = 0;
                        }

                    @endphp
                    @if (session('cart'))
                        @foreach (session('cart') as $id=>$details )
                            @php
                                $subtotal +=$details['quantity']*$details['price'];
                            @endphp
                            <tr id="row_{{ $details['id'] }}">
                                <td>
                                    <img src="{{ $details['image'] }}" alt="Product Image" style="height: 50px; width: 50px !important">
                                </td>
                                <td class="align-middle">

                                    {{ $details['name'] }}
                                </td>

                                <td class="align-middle">
                                    <div class="row">
                                        @if (isset($details['discounted_price']) && (int)$details['sale_price'] > 0)
                                            <div class="col-lg-6">
                                                <span style="text-decoration: line-through;">${{ $details['price'] }}</span>
                                            </div>
                                            <div class="col-lg-6">${{ $details['discounted_price'] }}</div>
                                        @else
                                            <div class="col-lg-6">${{ $details['price'] }}</div>
                                            <div class="col-lg-6"></div> <!-- Đặt trống nếu không có giảm giá -->
                                        @endif
                                    </div>
                                </td>

                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus" data-product-id="{{ $details['id'] }}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm bg-secondary text-center" value="{{ $details['quantity'] }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus" data-product-id="{{ $details['id'] }}">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">{{ $details['size'] }}</td>
                                <td id="subTotal_{{ $details['id'] }}" class="align-middle">
                                    ${{ $details['price']*$details['quantity'] }}
                                </td>
                                <td class="align-middle ">
                                    <button class="delete-product btn btn-sm btn-primary" data-product-id="{{ $details['id'] }}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <form class="mb-5" action="{{ route('apply.coupon') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control p-4" placeholder="Coupon Code" name="coupon_code"
                    value="{{ session()->get('coupon_code') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
            </form>
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium" id="subAllTotal" data-price="{{ $subtotal }}">
                            {{ $subtotal}}
                        </h6>
                    </div>
                    @if (session('discount_amount_price'))
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Coupon</h6>
                            <h6 class="font-weight-medium coupon-div" data-price="{{ session('discount_amount_price') }}">
                                ${{ session('discount_amount_price') }}
                            </h6>
                        </div>
                    @endif

                </div>
                <div class="card-footer border-secondary bg-transparent">

                    @if(session('cart'))
                        @php
                        $total = 0;
                        $discountAmount = session('discount_amount_price', 0);
                        @endphp

                        @foreach(session('cart') as $id => $details)
                            @php
                                // Tính toán tổng tiền cho từng sản phẩm và cộng vào total
                                $subtotal = $details['price'] * $details['quantity'];
                                $total += $subtotal;
                            @endphp
                        @endforeach

                        {{-- Trừ đi khoản đã giảm giá --}}
                        @if ($discountAmount > 0)
                            @php
                                $total -= $discountAmount;
                            @endphp
                        @endif

                    @endif
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 id="cart-total"  class="font-weight-bold ">${{ $total }}</h5>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

    <script type="text/javascript">
    // getTotalValue()

    // function getTotalValue() {
    //     let total = $('#subAllTotal').data('price')
    //     let couponPrice = $('.coupon-div')?.data('price') ?? 0;

    //     $('#cart-total').text(`$${total  - couponPrice}`)
    //     $('#total').val(total - couponPrice)
    // }
       $(document).ready(function () {
        // Sự kiện khi ấn nút tăng
        $(".btn-plus").click(function () {
            handleCartAction($(this), 'plus');
        });
        // Sự kiện khi ấn nút giảm
        $(".btn-minus").click(function () {
            handleCartAction($(this), 'minus');
        });
        // Sự kiện khi ấn nút xóa
        $(".delete-product").click(function () {
            handleCartAction($(this), 'delete');
        });
        // Hàm xử lý chung cho các sự kiện
        function handleCartAction(button, action) {
            var productId = button.data('product-id');
            let couponPrice = $('.coupon-div')?.data('price') ?? 0;
            $.ajax({
                type: 'POST',
                url: '/update-cart',
                data: {
                    productId: productId,
                    action: action
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log('productId:', response.productId);
                    console.log('action:', response.action);
                    console.log('suballtotal:', response.subAllTotal);
                    // Cập nhật giá trị total trong giao diện người dùng
                    if (response.action === 'delete') {
                        $('#row_' + response.productId).hide();
                        $('#cart-quantity-badge').text(response.quantity);
                    } else {
                        // Cập nhật giá trị total trong giao diện người dùng
                        $('#subTotal_' + response.productId).text('$' + response.subTotal);
                        $('#subAllTotal').text('$' + response.subAllTotal);
                        $('#cart-total').text('$' + (response.total-couponPrice));
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
    </script>

@endsection

