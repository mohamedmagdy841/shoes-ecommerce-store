@extends('frontend.master')
@section('title',  config('app.name') . " | " . 'My Orders')
@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>My Orders</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('content')
    <div class="container">
        <table class="table table-bordered m-4">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Order ID</th>
                <th scope="col">Date</th>
                <th scope="col">Amount</th>
                <th scope="col">Payment</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($orders) > 0)
                @foreach($orders as $key => $order)
                    <tr>
                        <th scope="row">{{ $loop->iteration + $orders->firstItem() - 1 }}</th>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format("d M Y, h:i A") }}</td>
                        <td>{{ Number::currency($order->total_price,'EGP') }}</td>
                        <td>
                            {{ $order->payment_method }}
                        </td>
                        <td class="text-light">
                            @if ($order->status == 'pending')
                                <span class="badge bg-info">Pending</span>
                            @elseif ($order->status == 'processing')
                                <span class="badge bg-primary">Processing</span>
                            @elseif ($order->status == 'processing')
                                <span class="badge bg-warning">Processing</span>
                            @elseif ($order->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif ($order->status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                        <td>
{{--                            <a href="{{ route('user.order.details',$order->id) }}" class="btn-small d-block text-primary"> <i class="fas fa-eye"></i>View</a>--}}
                            @if ($order->status == 'completed')
                                <a href="{{ route('frontend.orders.invoice.download',$order->id) }}" class="btn-small d-block text-danger"> <i class="fa fa-download"></i> Invoice</a>
                            @else
                                No Invoice
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="m-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                var button = $(this);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: button.data('route'),
                            data: {
                                '_method': 'delete'
                            },
                            success: function (response, textStatus, xhr) {
                                Swal.fire({
                                    icon: 'success',
                                    confirmButtonColor: "#ffba00",
                                    title: response,
                                }).then((result) => {
                                    window.location='/myBlogs'
                                });
                            }
                        });
                    }
                });

            })
        });
    </script>
@endpush

