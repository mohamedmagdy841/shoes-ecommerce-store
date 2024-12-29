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
    <style>

        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;}
    </style>

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-6">
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
                        <div class="card" style="width: 25rem; background-color: #dddddd">
                            <div class="card-body">
                                <h5 class="card-subtitle mb-2">Cash On Delivery</h5>

                                <div class="card-body">
                                    <div class="payment_item">
                                        <form action="{{ route('frontend.orders.cash_order') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="payment_method" value="cash_on_delivery">

                                            <button type="submit" class="btn btn-success btn-block btn-lg">PAY
                                                <i class="icofont-long-arrow-right"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <br>
                                <h5 class="card-subtitle mb-2">Credit/Debit Cards</h5>
                                <div class="card-body">
                                    <div class="payment_item active">
                                        <form action="{{ route('frontend.orders.stripe_order') }}" method="post" id="payment-form">
                                            @csrf
                                            <label for="card-element"></label>
                                            <input type="hidden" name="payment_method" value="stripe">
                                            <div id="card-element">
                                            </div>
                                            <div id="card-errors" role="alert">
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-success btn-block btn-lg">PAY
                                                <i class="icofont-long-arrow-right"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            <ul class="list">
                                <li><a href="#">Product <span>Total</span></a></li>
                                @foreach($cartItems as $item)
                                    <li><a href="#">{{ $item->name }} <span class="middle">x {{ $item->quantity }}</span> <span class="last">{{ Number::currency($item->price * $item->quantity,'EGP') }}</span></a></li>
                                @endforeach
                            </ul>
                            <ul class="list list_2">
                                <li><a href="#">Subtotal <span>{{ Number::currency($subtotal, 'EGP') }}</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->
@endsection
@push('js')
    <script type="text/javascript">
        const stripePublicKey = "{{ config('services.stripe.public_key') }}";
        var stripe = Stripe(stripePublicKey);
        var elements = stripe.elements();
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        var card = elements.create('card', {style: style});
        card.mount('#card-element');
        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });
        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
@endpush
