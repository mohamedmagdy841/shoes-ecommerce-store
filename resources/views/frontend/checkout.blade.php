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
                    <!-- Left Column: Address & Payment -->
                    <div class="col-lg-6 mb-4">
                        <h3>Delivery Address</h3>
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="card-title">Home</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $user->full_address }}</h6>
                                <p class="card-text">{{ $user->phone }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <h3>Payment Method</h3>
                        <div class="card w-100" style="background-color: #f7f7f7;">
                            <div class="card-body">
                                <h5 class="card-title">Select Payment Method</h5>
                                <p>Select your preferred payment method to complete your order.</p>

                                <form action="{{ route('payment.process') }}" method="post" id="payment_form">
                                    @csrf
                                    <input type="hidden" name="gateway_type" id="gateway_type">

                                    <div class="payment_options">
                                        <div class="payment_option" id="cash_on_delivery" data-method="cash_on_delivery">
                                            <div class="option_card">
                                                <h6>Cash On Delivery</h6>
                                            </div>
                                        </div>
                                        <div class="payment_option" id="paymob" data-method="paymob">
                                            <div class="option_card">
                                                <h6>Paymob</h6>
                                            </div>
                                        </div>
                                        <div class="payment_option" id="myfatoorah" data-method="myfatoorah">
                                            <div class="option_card">
                                                <h6>MyFatoorah</h6>
                                            </div>
                                        </div>
                                        <div class="payment_option" id="stripe" data-method="stripe">
                                            <div class="option_card">
                                                <h6>Stripe</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="submit_payment" disabled>
                                        Proceed to Pay <i class="icofont-long-arrow-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary - Full Width Below -->
                    <div class="col-lg-12 mt-4">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            <ul class="list">
                                <li><a href="#">Product <span>Total</span></a></li>
                                @foreach($cartItems as $item)
                                    <li><a href="#">{{ $item->name }} <span class="middle">x {{ $item->quantity }}</span> <span class="last">{{ Number::currency($item->price * $item->quantity, 'EGP') }}</span></a></li>
                                @endforeach
                            </ul>
                            <ul class="list list_2">
                                <li><a href="#">Subtotal <span>{{ Number::currency($subtotal, 'EGP') }}</span></a></li>
                                <li>
                                    @if($appliedCoupon)
                                        <p>Coupon Applied: {{ $appliedCoupon }}</p>
                                        <p>Discount Amount: - {{ Number::currency($discountAmount, 'EGP') }}</p>
                                        <a href="#">Final Total: <span>{{ Number::currency($discountedTotal, 'EGP') }}</span></a>
                                    @else
                                        <p>No coupon applied.</p>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .payment_options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }
        .payment_option {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment_option.selected {
            border-color: #007bff;
            background-color: #e6f7ff;
        }
        .payment_option:hover {
            background-color: #f0f0f0;
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .option_card h6 {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .option_card p {
            font-size: 0.9rem;
            color: #555;
        }
        #submit_payment {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
        }
        #submit_payment:hover {
            background-color: #0056b3;
        }
    </style>
@endsection

@push('js')
    <script>
        const paymentOptions = document.querySelectorAll('.payment_option');
        const paymentMethodInput = document.getElementById('gateway_type');
        const submitButton = document.getElementById('submit_payment');

        paymentOptions.forEach(option => {
            option.addEventListener('click', function () {
                paymentOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                paymentMethodInput.value = this.getAttribute('data-method');
                submitButton.disabled = false;
            });
        });

        document.getElementById('payment_form').addEventListener('submit', function (e) {
            if (!paymentMethodInput.value) {
                e.preventDefault();
                alert("Please select a payment method.");
            }
        });
    </script>
@endpush
