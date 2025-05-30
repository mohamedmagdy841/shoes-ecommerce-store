@extends('frontend.master')

@section('title',  config('app.name') . " | " . 'Home')
@section('banner')
    <!-- start banner Area -->
    <section class="banner-area">
        <div id="image-sources"
             data-prev="{{ asset('assets/frontend/img/banner/prev.png') }}"
             data-next="{{ asset('assets/frontend/img/banner/next.png') }}">
        </div>
        <div id="product-image-sources"
             data-prev="{{ asset('assets/frontend/img/product/prev.png') }}"
             data-next="{{ asset('assets/frontend/img/product/next.png') }}">
        </div>
        <div class="container">
            <div class="row fullscreen align-items-center justify-content-start">
                <div class="col-lg-12">
                    <div class="active-banner-slider owl-carousel">
                        <!-- single-slide -->
                        <div class="row single-slide align-items-center d-flex">
                            <div class="col-lg-5 col-md-6">
                                <div class="banner-content">
                                    <h1>Nike New <br>Collection!</h1>
                                    <p>Check out the latest Nike collection! Explore stylish and comfortable shoes perfect for every occasion. Get ready to step up your game with the newest designs.</p>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="banner-img">
                                    <img class="img-fluid" src="{{ asset('assets/frontend') }}/img/banner/banner-img.png" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- single-slide -->
                        <div class="row single-slide">
                            <div class="col-lg-5">
                                <div class="banner-content">
                                    <h1>Adidas New <br>Collection!</h1>
                                    <p>Discover the newest Adidas collection! Elevate your style with innovative designs that blend comfort and performance. Find your perfect pair today!</p>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="banner-img">
                                    <img class="img-fluid" src="{{ asset('assets/frontend') }}/img/banner/banner-img.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->
@endsection
@section('home-active', 'active')
@section('content')
    <!-- start features Area -->
    <section class="features-area section_gap">
        <div class="container">
            <div class="row features-inner">
                <!-- single features -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-features">
                        <div class="f-icon">
                            <img src="{{ asset('assets/frontend') }}/img/features/f-icon1.png" alt="">
                        </div>
                        <h6>Free Delivery</h6>
                        <p>Free Shipping on all order</p>
                    </div>
                </div>
                <!-- single features -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-features">
                        <div class="f-icon">
                            <img src="{{ asset('assets/frontend') }}/img/features/f-icon2.png" alt="">
                        </div>
                        <h6>Return Policy</h6>
                        <p>Free Shipping on all order</p>
                    </div>
                </div>
                <!-- single features -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-features">
                        <div class="f-icon">
                            <img src="{{ asset('assets/frontend') }}/img/features/f-icon3.png" alt="">
                        </div>
                        <h6>24/7 Support</h6>
                        <p>Free Shipping on all order</p>
                    </div>
                </div>
                <!-- single features -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-features">
                        <div class="f-icon">
                            <img src="{{ asset('assets/frontend') }}/img/features/f-icon4.png" alt="">
                        </div>
                        <h6>Secure Payment</h6>
                        <p>Free Shipping on all order</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end features Area -->

    <!-- Start category Area -->
    <section class="category-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Shop By Category</h1>
                        <p>Shop by category to find the perfect shoes for men, women, and kids. Discover a wide range of styles designed for comfort, quality, and every occasion!</p>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="single-deal">
                                <div class="overlay"></div>
                                <img class="img-fluid w-100" src="{{ asset('assets/frontend') }}/img/category/c3.jpg" alt="">
                                <a
                                    href="{{ route('frontend.shop', ['categories' => [1]]) }}"
                                    target="_blank">
                                    <div class="deal-details">
                                        <h6 class="deal-title">Shoes for Men</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="single-deal">
                                <div class="overlay"></div>
                                <img class="img-fluid w-100" src="{{ asset('assets/frontend') }}/img/category/c2.jpg" alt="">
                                <a href="{{ route('frontend.shop', ['categories' => [2]]) }}" target="_blank">
                                    <div class="deal-details">
                                        <h6 class="deal-title">Shoes for Women</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="single-deal">
                                <div class="overlay"></div>
                                <img class="img-fluid w-100" src="{{ asset('assets/frontend') }}/img/exclusive.jpg" alt="">
                                <a href="{{ route('frontend.shop', ['categories' => [3]]) }}" target="_blank">
                                    <div class="deal-details">
                                        <h6 class="deal-title">Shoes for Kids</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End category Area -->
    @php
        $chunks = $home_products instanceof \Illuminate\Support\Collection
            ? $home_products->chunk(8)
            : collect();
    @endphp
    <!-- start product Area -->
    <section class="owl-carousel active-product-area section_gap">
        <!-- single product slide -->
        @foreach($chunks as $chunk)
            <div class="single-product-slider">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <div class="section-title">
                                <h1>Latest Products</h1>
                                <p>Explore our latest collection of shoes, featuring the newest styles and trends for men, women, and kids. Find your next favorite pair today!</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- single product -->
                        @foreach($chunk as $product)
                            <div class="col-lg-3 col-md-6">
                                <div class="single-product">
                                    <a href="{{ route('frontend.product', $product->slug) }}">
                                        <img class="img-fluid" src="{{ asset($product->images->first()->path) }}" alt="">
                                    </a>
                                    <div class="product-details">
                                        <a href="{{ route('frontend.product', $product->slug) }}">
                                            <h6>{{ $product->full_name }}</h6>
                                        </a>
                                        <div class="price">
                                            <h6>{{Number::currency($product->price,'EGP')}}</h6>
                                        </div>
                                        <div class="prd-bottom">

                                            <a href="" class="social-info addToCart" data-product-id="{{ route('frontend.cart.add', $product->id) }}">
                                                <span class="ti-bag"></span>
                                                <p class="hover-text">add to bag</p>
                                            </a>
                                            <a href="" class="social-info addToWishlist" data-product-id="{{ route('frontend.wishlist.add', $product->id) }}">
                                                <span class="lnr lnr-heart"></span>
                                                <p class="hover-text">Wishlist</p>
                                            </a>
                                            <a href="{{ route('frontend.product', $product->slug) }}" class="social-info">
                                                <span class="lnr lnr-move"></span>
                                                <p class="hover-text">View More</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- single product -->
                    </div>
                </div>
            </div>
        @endforeach

    </section>
    <!-- end product Area -->

    <!-- Start exclusive deal Area -->
    <section class="exclusive-deal-area">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 no-padding exclusive-left">
                    <div class="row clock_sec clockdiv" id="clockdiv">
                        <div class="col-lg-12">
                            <h1>Exclusive Hot Deal Ends Soon!</h1>
                            <p>Who are in extremely love with eco friendly system.</p>
                        </div>
                        <div class="col-lg-12">
                            <div class="row clock-wrap">
                                <div class="col clockinner1 clockinner">
                                    <h1 class="days">150</h1>
                                    <span class="smalltext">Days</span>
                                </div>
                                <div class="col clockinner clockinner1">
                                    <h1 class="hours">23</h1>
                                    <span class="smalltext">Hours</span>
                                </div>
                                <div class="col clockinner clockinner1">
                                    <h1 class="minutes">47</h1>
                                    <span class="smalltext">Mins</span>
                                </div>
                                <div class="col clockinner clockinner1">
                                    <h1 class="seconds">59</h1>
                                    <span class="smalltext">Secs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('frontend.shop') }}" class="primary-btn">Shop Now</a>
                </div>
                <div class="col-lg-6 no-padding exclusive-right">
                    <div class="single-exclusive-slider">
                        <img class="img-fluid" src="{{ asset($product->images->first()->path) }}" alt="">
                        <div class="product-details">
                            <div class="price">
                                <h6>{{Number::currency($product->price,'EGP')}}</h6>
                            </div>
                            <a href="{{ route('frontend.product', $product->slug) }}">
                                <h3>{{ $product->full_name }}</h3>
                            </a>
                            <div class="add-bag d-flex align-items-center justify-content-center">
                                <a href="" class="social-info addToCart" data-product-id="{{ route('frontend.cart.add', $product->id) }}">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End exclusive deal Area -->

    <!-- Start brand Area -->
    <section class="brand-area section_gap">
        <div class="container">
            <div class="row">
                <a class="col single-img" href="#">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('assets/frontend') }}/img/brand/1.png" alt="">
                </a>
                <a class="col single-img" href="#">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('assets/frontend') }}/img/brand/2.png" alt="">
                </a>
                <a class="col single-img" href="#">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('assets/frontend') }}/img/brand/3.png" alt="">
                </a>
                <a class="col single-img" href="#">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('assets/frontend') }}/img/brand/4.png" alt="">
                </a>
                <a class="col single-img" href="#">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('assets/frontend') }}/img/brand/5.png" alt="">
                </a>
            </div>
        </div>
    </section>
    <!-- End brand Area -->

    <section class="related-product-area section_gap_bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Deals of the Week</h1>
                        <p>Discover the best deals of the week on shoes for men, women, and kids. Don't miss out on exclusive discounts and limited-time offers!</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        @if($cheapest_products->count() > 0)
                            @foreach($cheapest_products as $cheapest_product)
                                <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                                    <div class="single-related-product d-flex">
                                        <a href="{{ route('frontend.product', $cheapest_product->slug) }}"><img src="{{ asset($cheapest_product->images->first()->path) }}" style="height: 70px; width: 70px" alt=""></a>
                                        <div class="desc">
                                            <a href="{{ route('frontend.product', $cheapest_product->slug) }}" class="title">{{ $cheapest_product->full_name }}</a>
                                            <div class="price">
                                                <h6>{{Number::currency($cheapest_product->price,'EGP')}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ctg-right">
                        <a href="{{ route('frontend.shop') }}" target="_blank">
                            <img class="img-fluid d-block mx-auto" src="{{ asset('assets/frontend') }}/img/category/c5.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        const notyf = new Notyf({
            duration: 3000,
            types: [
                {
                    type: 'warning',
                    background: 'orange',
                    icon: {
                        className: 'material-icons',
                        tagName: 'i',
                        text: 'warning'
                    }
                },
                {
                    type: 'success',
                    background: 'green',
                }
            ]
        });
        $(document).ready(function () {
            $('.addToWishlist').on('click', function (e) {
                e.preventDefault();

                @guest()
                Swal.fire({
                    title: "You Must Log In First",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                });
                @endguest

                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).attr('data-product-id'),
                    success: function (data) {
                        if(data.message === "Product added to wishlist")
                            notyf.open({
                                type: 'success',
                                message: data.message
                            });
                        else
                            notyf.open({
                                type: 'warning',
                                message: data.message
                            });
                    }
                });
            });

            $('.addToCart').on('click', function (e) {
                e.preventDefault();

                @guest()
                Swal.fire({
                    title: "You Must Log In First",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                });
                @endguest

                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).attr('data-product-id'),
                    success: function (data) {
                        notyf.open({
                            type: 'success',
                            message: data.message
                        });
                    }
                });
            });
        });
    </script>
@endpush
