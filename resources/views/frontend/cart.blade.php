@extends('frontend.master')

@section('title',  config('app.name') . " | " . 'My Cart')
@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>My Cart</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('content')
    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            @if(isset($items) && $items->count() > 0)
                <div class="cart_inner">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img style="width: 100px; height: 100px;" src="{{ $item->attributes->image }}" alt="">
                                            </div>
                                            <div class="media-body">
                                                <p>{{ $item->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h5>{{Number::currency($item->price,'EGP')}}</h5>
                                    </td>
                                    <td>
                                        <button data-id="{{ $item->id }}" data-action="decrease" class="btn btn-default bootstrap-touchspin-down update-quantity" style="background-color: #ffba00; line-height: 1;">-</button>
                                        <input style="width: 40px;" type="text" value="{{ $item->quantity }}" name="quantity" readonly>
                                        <button data-id="{{ $item->id }}" data-action="increase" class="btn btn-default bootstrap-touchspin-up update-quantity" style="background-color: #ffba00; line-height: 1;">+</button>

                                    </td>
                                    <td>
                                        <h5>{{Number::currency($item->price * $item->quantity,'EGP')}}</h5>
                                    </td>
                                    <td>
                                        <a class="delete-item btn btn-danger waves-effect waves-light ml-2" data-id="{{ $item->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="bottom_button">
                                <td>
                                    <a class="gray_btn" href="{{ route('frontend.cart.clear') }}">Clear Cart</a>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="cupon_text d-flex align-items-center">
                                        <input id="coupon-code" type="text" placeholder="Coupon Code" style="border: 1px solid; color: #333; margin-right: 0.25rem">
                                        <a class="primary-btn coupon">Apply</a>
                                        <a class="gray_btn cancelCoupon">Remove Coupon</a>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td class="subtotal">
                                    <h5>{{Number::currency($subtotal,'EGP')}}</h5>
                                </td>
                            </tr>
                            <tr class="discounted-subtotal" style="display: none;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h5>New Subtotal</h5>
                                </td>
                                <td class="subtotal-discounted">
                                    <h5></h5>
                                </td>
                            </tr>
                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" style="width: 230px" href="{{ route('frontend.shop') }}">Continue Shopping</a>
                                        <a class="primary-btn" style="width: 220px" href="{{ route('frontend.checkout.index') }}">Proceed to checkout</a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <h3>Your Cart Is Empty</h3>
                    <a class="primary-btn mt-2" href="{{ route('frontend.shop') }}">Continue Shopping</a>
                </div>

            @endif
        </div>
    </section>
    <!--================End Cart Area =================-->
@endsection
@push('js')
    <script>
        const notyf = new Notyf();
        $(document).ready(function() {

            $('.delete-item').on('click', function (event) {
                event.preventDefault();

                const id = $(this).data('id');

                $.ajax({
                    url: `/cart/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        notyf.success(response.message);
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            $('.update-quantity').on('click', function (event) {
                event.preventDefault();

                const productId = $(this).data('id');
                const action = $(this).data('action');

                $.ajax({
                    url: `/cart/${productId}/update-quantity/${action}`,
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            $('.coupon').on('click', function (event) {
                event.preventDefault();

                const couponCode = $('#coupon-code').val();  // Get the input value

                $.ajax({
                    url: '{{ route('frontend.coupon.apply_coupon') }}',
                    method: 'GET',
                    data: {
                        coupon_code: couponCode,
                    },
                    success: function (response) {
                        if (response.success) {
                            $('.subtotal-discounted').html(`<h5>${response.total}</h5>`);
                            $('.discounted-subtotal').show();
                            notyf.success('Coupon applied successfully!');
                        } else {
                            notyf.error(response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                        notyf.error('Failed to apply coupon.');
                    }
                });
            });

            $('.cancelCoupon').on('click', function (event) {
                event.preventDefault();
                $.ajax({
                    url: '{{ route('frontend.coupon.cancel_coupon') }}',
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            $('.discounted-subtotal').hide();
                            $('#coupon-code').val('');
                            notyf.success('Coupon canceled successfully!');
                        } else {
                            notyf.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                        notyf.error('Failed to cancel coupon.');
                    },
                });
            });

        });
    </script>
@endpush
