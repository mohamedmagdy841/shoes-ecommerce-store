@extends('frontend.master')

@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('content')
        <div class="container">
            <div class="row">
                @foreach($products as $product)
                            <div class="col-lg-3 col-md-6 mt-5">
                                <div class="single-product">
                                    <img class="img-fluid" src="{{ asset('storage/'.$product->images->first()->path) }}" alt="">
                                    <div class="product-details">
                                        <h6>{{ $product->name }}</h6>
                                        <div class="price">
                                            <h6>${{ $product->price }}</h6>
                                            <h6 class="l-through">$210.00</h6>
                                        </div>
                                        <div class="prd-bottom">

                                            <a href="" class="social-info">
                                                <span class="ti-bag"></span>
                                                <p class="hover-text">add to bag</p>
                                            </a>
                                            <a href="" class="social-info">
                                                <span class="lnr lnr-heart"></span>
                                                <p class="hover-text">Wishlist</p>
                                            </a>
                                            <a href="" class="social-info">
                                                <span class="lnr lnr-sync"></span>
                                                <p class="hover-text">compare</p>
                                            </a>
                                            <a href="" class="social-info">
                                                <span class="lnr lnr-move"></span>
                                                <p class="hover-text">view more</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                @endforeach
            </div>
        </div>

    {{ $products->links() }}
@endsection
