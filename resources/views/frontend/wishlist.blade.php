@extends('frontend.master')

@section('title',  config('app.name') . " | " . 'My Wishlist')
@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>My Wishlist</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('frontend.index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('frontend.wishlist.get') }}">My Wishlist</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('contact-active', 'active')

@section('content')
    <div class="container mt-5">
        <div class="row">
        @foreach($wishlist as $product)
            <div class="col-lg-3 col-md-6">
                <div class="single-product">
                    <a href="{{ route('frontend.product', $product->slug) }}">
                        <img class="img-fluid" src="{{ $product->images->first()->path }}" alt="">
                    </a>
                    <div class="product-details">
                        <a href="{{ route('frontend.product', $product->slug) }}">
                            <h6>{{ $product->name }}</h6>
                        </a>
                        <div class="price">
                            <h6>${{ $product->price }}</h6>
                            <h6 class="l-through">$210.00</h6>
                        </div>
                        <div class="prd-bottom">
                            <form method="post" action="{{ route('frontend.wishlist.remove', $product->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="social-info btn btn-danger waves-effect waves-light">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endpush
