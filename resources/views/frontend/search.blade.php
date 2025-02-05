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
                                    <a href="{{ route('frontend.product', $product->slug) }}">
                                        <img class="img-fluid" src="{{ asset($product->images->first()->path) }}" alt="{{$product->full_name}}">
                                    </a>
                                    <div class="product-details">
                                        <a href="{{ route('frontend.product', $product->slug) }}">
                                            <h6>{{ $product->full_name }}</h6>
                                        </a>
                                        <div class="price">
                                            <h6>{{Number::currency($product->price,'EGP')}}</h6>
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
