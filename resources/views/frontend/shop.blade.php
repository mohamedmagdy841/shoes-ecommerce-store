@extends('frontend.master')

@section('title',  config('app.name') . " | " . 'Shop')
@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shop</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('frontend.index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('frontend.shop') }}">Shop</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('shop-active', 'active')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="sidebar-categories mt-4">
                    <div class="head">Browse Categories</div>

{{--                    <form id="filter-form">--}}

                    blade
                    Copy code
                    <form method="get" action="{{ route('frontend.shop') }}">
                        <!-- Categories Filter -->
                        @if(count($categories) > 0)
                            @foreach($categories as $category)
                                <div class="switch-wrap d-flex justify-content-between m-3">
                                    <p>{{ $category->name }}</p>
                                    <div class="primary-checkbox">
                                        <input class="filter-input" type="checkbox" name="categories[]"
                                               id="primary-checkbox {{ $category->id }}"
                                               value="{{ $category->id }}"
                                            {{ in_array($category->id, request()->get('categories', [])) ? 'checked' : '' }}>
                                        <label for="primary-checkbox {{ $category->id }}"></label>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Brands Filter -->
                        <div class="head">Brands</div>
                        @if(count($brands) > 0)
                            @foreach($brands as $brand)
                                <div class="switch-wrap d-flex justify-content-between m-3">
                                    <p>{{ $brand }}</p>
                                    <div class="primary-checkbox">
                                        <input class="filter-input" value="{{ $brand }}" type="checkbox"
                                               id="primary-checkbox {{ $brand }}" name="brands[]"
                                            {{ in_array($brand, request()->get('brands', [])) ? 'checked' : '' }}>
                                        <label for="primary-checkbox {{ $brand }}"></label>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Colors Filter -->
                        <div class="head">Color</div>
                        @if(count($colors) > 0)
                            @foreach($colors as $color)
                                <div class="switch-wrap d-flex justify-content-between m-3">
                                    <p>{{ $color }}</p>
                                    <div class="primary-checkbox">
                                        <input class="filter-input" value="{{ $color }}" type="checkbox"
                                               id="primary-checkbox {{ $color }}" name="colors[]"
                                            {{ in_array($color, request()->get('colors', [])) ? 'checked' : '' }}>
                                        <label for="primary-checkbox {{ $color }}"></label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <!-- Price Filter -->
                        <div class="head">Price</div>

                        <div class="switch-wrap d-flex justify-content-between m-3">
                            <p>From $50 to $100</p>
                            <div class="primary-checkbox">
                                <input class="filter-input" type="checkbox" name="price_range[]" id="price-50-100" value="50-100"
                                    {{ in_array('50-100', request()->get('price_range', [])) ? 'checked' : '' }}>
                                <label for="price-50-100"></label>
                            </div>
                        </div>

                        <div class="switch-wrap d-flex justify-content-between m-3">
                            <p>From $100 to $150</p>
                            <div class="primary-checkbox">
                                <input class="filter-input" type="checkbox" name="price_range[]" id="price-100-150" value="100-150"
                                    {{ in_array('100-150', request()->get('price_range', [])) ? 'checked' : '' }}>
                                <label for="price-100-150"></label>
                            </div>
                        </div>

                        <div class="switch-wrap d-flex justify-content-between m-3">
                            <p>From $150 to $200</p>
                            <div class="primary-checkbox">
                                <input class="filter-input" type="checkbox" name="price_range[]" id="price-150-200" value="150-200"
                                    {{ in_array('150-200', request()->get('price_range', [])) ? 'checked' : '' }}>
                                <label for="price-150-200"></label>
                            </div>
                        </div>

                        <div class="switch-wrap d-flex justify-content-between m-3">
                            <p>$200 and above</p>
                            <div class="primary-checkbox">
                                <input class="filter-input" type="checkbox" name="price_range[]" id="price-200-above" value="200-above"
                                    {{ in_array('200-above', request()->get('price_range', [])) ? 'checked' : '' }}>
                                <label for="price-200-above"></label>
                            </div>
                        </div>

                        <!-- Sorting Dropdown -->
                        <div class="filter-bar d-flex flex-wrap align-items-center mb-3">
                            <div class="head">Sort By</div>
                            <select name="sort_by" class="filter-input">
                                <option value="" {{ request('sort_by') === null ? 'selected' : '' }}>Default sorting</option>
                                <option value="price_asc" {{ request('sort_by') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort_by') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="primary-btn submit_btn">Apply</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7">
                <!-- Start Best Seller -->
                <section class="lattest-product-area pb-40 category-list">
                    <div class="row">
                        <!-- single product -->
                            @foreach($products as $product)
                                <div class="col-lg-4 col-md-6">
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
                                                    <p class="hover-text">view more</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- single product -->
                    </div>
                </section>
                <!-- End Best Seller -->
                <div class="pagination-custom mb-3">

                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>

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
            $('.filter-input').on('change', function () {
                if ($('.filter-input:checked').length > 0) {
                    const formData = $('#filter-form').serialize();

                    $.ajax({
                        url: '{{ route("frontend.shop") }}',
                        method: 'GET',
                        data: formData,
                        success: function (data) {
                            $('.category-list .row').empty();
                            $('.pagination-custom').hide();
                            $.each(data.products.data, function (index, product) {
                                $('.category-list .row').append(`
                            <div class="col-lg-4 col-md-6">
                                <div class="single-product">
                                    <img class="img-fluid" src="${product.images[0].path}" alt="">
                                    <div class="product-details">
                                        <h6>${product.brand} ${product.name}</h6>
                                        <div class="price">
                                            <h6>$${product.price}</h6>
                                        </div>
                                        <div class="prd-bottom">
                                            <a href="#" class="social-info">
                                                <span class="ti-bag"></span>
                                                <p class="hover-text">add to bag</p>
                                            </a>
                                            <a href="#" class="social-info addToWishlist" data-product-id="${product.id}">
                                                <span class="lnr lnr-heart"></span>
                                                <p class="hover-text">Wishlist</p>
                                            </a>
                                            <a href="#" class="social-info">
                                                <span class="lnr lnr-move"></span>
                                                <p class="hover-text">view more</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                            });
                        },
                        error: function () {
                            alert('Failed to fetch products. Please try again.');
                        }
                    });
                } else {
                    window.history.pushState({}, '', '{{ route("frontend.shop") }}');
                    window.location.replace('{{ route("frontend.shop") }}');
                }
            });

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
