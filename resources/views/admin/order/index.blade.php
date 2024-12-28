@extends('admin.master')
@section('title', 'Manage Orders')
@section('order active', 'active')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">
                @if(auth('admin')->user()->can('manage_orders'))
                    <div class="text-end">
                        <a href="{{ route('admin.orders.export') }}" class="btn bg-gradient-primary">
                            Export Data
                        </a>
                    </div>
                @endif
                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center m-3">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-s font-weight-bolder">Order ID</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Ordered By</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Payment Method</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Number Of Items</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Total Price</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Created At</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Status</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $key => $order)
                                    <tr>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $order->id }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $order->user->name }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $order->payment_method }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $order->items_count }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span
                                                class=" text-s">{{ Number::currency($order->total_price, 'EGP') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $order->created_at->format('Y-m-d h:i a') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if(auth('admin')->user()->can('manage_orders'))
                                                <a href="#">
                                                    <span
                                                        class="badge badge-sm bg-gradient-@if($order->status=="cancelled")danger @else()success @endif ">{{ $order->status }}</span>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if(auth('admin')->user()->can('manage_orders'))
                                                <div class="dropdown" style="display: inline">
                                                    <button class="btn btn-secondary dropdown-toggle mt-3" type="button"
                                                            id="dropdownMenuButton{{$order->id}}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        Status
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton{{$order->id}}">
                                                        @foreach(['pending', 'processing', 'completed', 'cancelled'] as $status)
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                                                    method="POST"
                                                                    id="status-form-{{ $order->id }}-{{ $status }}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status"
                                                                           value="{{ $status }}">
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                       onclick="document.getElementById('status-form-{{ $order->id }}-{{ $status }}').submit();">
                                                                        {{ ucfirst($status) }}
                                                                    </a>
                                                                </form>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                            @endif

                                            @if(auth('admin')->user()->can('manage_orders'))
                                                <form method="POST" class="delete-form" style="display: inline"
                                                      data-route="{{route('admin.orders.destroy',$order)}}">
                                                    @csrf
                                                    @method('delete')

                                                    <button type="submit" style="border: 0" class="btn btn-danger mt-3">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="align-middle text-center"><span
                                                class="text-m font-weight-bold">No orders</span></td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {

            $('.delete-form').on('submit', function (e) {
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
                                    window.location = '/admin/orders'
                                });
                            }
                        });
                    }
                });

            })
        });
    </script>
@endpush
