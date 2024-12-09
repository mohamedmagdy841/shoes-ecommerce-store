@extends('frontend.master')

@section('title',  config('app.name') . " | " . 'Confirmation')
@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Order Confirmation</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('content')
    <!--================Order Details Area =================-->
    <section class="order_details section_gap">
        <div class="container">
            <h3 class="title_confirmation">Thank you. Your order has been received.</h3>
            <div class="row order_d_inner">
                <div class="col-lg-6">
                    <div class="details_item">
                        <h4>Order Info</h4>
                        <ul class="list">
                            <li><a href="#"><span>Order number</span> : {{ $order->id }}</a></li>
                            <li><a href="#"><span>Date</span> : {{ $order->created_at->format("d M Y, h:i A") }}</a></li>
                            <li><a href="#"><span>Total</span> : {{Number::currency($order->total_price)}}</a></li>
                            <li><a href="#"><span>Payment method</span> : Check payments</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="details_item">
                        <h4>Shipping Address</h4>
                        <ul class="list">
                            <li><a href="#"><span>Street</span> : {{ $user->street }}</a></li>
                            <li><a href="#"><span>City</span> : {{ $user->city }}</a></li>
                            <li><a href="#"><span>Country</span> : {{ $user->country }}</a></li>
                            <li><a href="#"><span>Phone </span> : {{ $user->phone }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="order_details_table">
                <h2>Order Details</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <p>{{ $item->product->full_name }}</p>
                                </td>
                                <td>
                                    <h5>x {{ $item->quantity }}</h5>
                                </td>
                                <td>
                                    <p>{{ $item->price * $item->quantity }}</p>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>
                                <h4>Total</h4>
                            </td>
                            <td>
                                <h5></h5>
                            </td>
                            <td>
                                <p>{{ Number::currency($order->total_price) }}</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--================End Order Details Area =================-->
@endsection
