@extends('frontend.master')

@section('title',  config('app.name') . " | " . 'Checkout')
@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Checkout</h1>

                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('content')
    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>Delivery Address</h3>
                        <div class="card" style="width: 25rem;">
                            <div class="card-body">
                                <h5 class="card-title">Home</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $user->full_address }}</h6>
                                <p class="card-text">{{ $user->phone }}</p>
                            </div>
                        </div>
                        <br>
                        <h3>Choose payment method</h3>
                        <div class="card" style="width: 25rem;">
                            <div class="card-body">
                                <h5 class="card-subtitle mb-2">Credit/Debit Cards</h5>
                                <div class="card-body">
                                    <div class="payment_item">
                                    <div class="radion_btn">
                                        <input type="radio" id="f-option5" name="selector">
                                        <label for="f-option5">Cash On Delivery</label>
                                        <div class="check"></div>
                                    </div>
                                    <p>Please send a check to Store Name, Store Street, Store Town, Store State / County,
                                        Store Postcode.</p>
                                </div>
                                </div>
                                <div class="card-body">
                                    <div class="payment_item active">
                                    <div class="radion_btn">
                                        <input type="radio" id="f-option6" name="selector">
                                        <label for="f-option6">Paypal </label>
                                        <img src="img/product/card.jpg" alt="">
                                        <div class="check"></div>
                                    </div>
                                    <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                        account.</p>
                                </div>
                                </div>
                                <div class="creat_account">
                                    <input type="checkbox" id="f-option4" name="selector">
                                    <label for="f-option4">I’ve read and accept the </label>
                                    <a href="#">terms & conditions*</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            <ul class="list">
                                <li><a href="#">Product <span>Total</span></a></li>
                                @foreach($cartItems as $item)
                                    <li><a href="#">{{ $item->name }} <span class="middle">x {{ $item->quantity }}</span> <span class="last">{{ Number::currency($item->price * $item->quantity,'EGP') }}</span></a></li>
                                @endforeach
                            </ul>
                            <ul class="list list_2">
                                <li><a href="#">Subtotal <span>{{ Number::currency($subtotal) }}</span></a></li>
                            </ul>
                            <form action="{{ route('frontend.orders.store') }}" method="post">
                                @csrf
                                <button type="submit" class="primary-btn" href="{{ route('frontend.orders.store') }}">Place Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->
@endsection
