@extends('client.layouts.app')
@section('title', 'Cart  ')
@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Checkout</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Checkout Start -->

<div class="container-fluid pt-5">
    <form method="POST" action="{{ route('handle.checkout') }}" >
        @csrf
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label> Name</label>
                            <input class="form-control" type="text" placeholder="John" name="customer_name" value="{{ $user->name }}">
                            @error('customer_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com" name="customer_email" value="{{ $user->email }}">
                            @error('customer_email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" placeholder="+123 456 789" name="customer_phone" value="{{ $user->phone }}">
                            @error('customer_phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" placeholder="123 Street" name="customer_address" value="{{ $user->address }}">
                            @error('customer_address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Note</label>
                            <input class="form-control" type="text" placeholder="Write note" name="note">
                            @error('note')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- <div class="collapse mb-4" id="shipping-address">
                    <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" placeholder="John">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" placeholder="Doe">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" placeholder="+123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select class="custom-select">
                                <option selected>United States</option>
                                <option>Afghanistan</option>
                                <option>Albania</option>
                                <option>Algeria</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" type="text" placeholder="123">
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        @if(session('cart'))
                            @php
                                $subtotal = 0;
                            @endphp
                            @foreach (session('cart') as $id=>$details )
                                @php
                                    $subtotal +=$details['quantity']*$details['price'];
                                @endphp
                                <div class="d-flex justify-content-between">
                                    <p>{{ $details['quantity'] }} x {{ $details['name'] }}</p>
                                    <p>${{ $details['quantity']*$details['price'] }}</p>
                                </div>
                            @endforeach
                            <hr class="mt-0">
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Subtotal</h6>
                                <h6 class="font-weight-medium total-price" data-price="{{ $subtotal }}">
                                    ${{ $subtotal }}
                                </h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium shipping" data-price="20">$20</h6>
                                <input type="hidden" value="20" name="ship">
                            </div>
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Coupon</h6>
                                <h6 class="font-weight-medium coupon-div" data-price="{{ session('discount_amount_price') }}">
                                    ${{ session('discount_amount_price') }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold total-price-all"></h5>
                                <input type="hidden" id="total" value="" name="total">
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck" value="vnpay">
                                <label class="custom-control-label" for="directcheck" >VNPay</label>
                            </div>
                        </div>
                        <div class="">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer" value="money">
                                <label class="custom-control-label" for="banktransfer">Money</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" name="redirect" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3"> Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Checkout End -->
<script>
    $(function() {


        getTotalValue()

        function getTotalValue() {
            let total = $('.total-price').data('price')
            let couponPrice = $('.coupon-div')?.data('price') ?? 0;
            let shiping = $('.shipping').data('price')
            $('.total-price-all').text(`$${total + shiping - couponPrice}`)
            $('#total').val(total + shiping - couponPrice)
        }

    });
</script>

@endsection
