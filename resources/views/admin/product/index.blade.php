@extends('admin.master')
@section('title', __('keywords.manage') . ' ' . __('keywords.products'))
@section('subtitle', __('keywords.manage') . ' ' . __('keywords.products'))
@section('product active', 'active')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">

                @if(auth('admin')->user()->can('add_product'))
                    <div class="text-end">
                        <a href="{{ route('admin.products.create') }}" class="btn bg-gradient-primary">
                            {{ __('keywords.add_new_product') }}
                        </a>
                    </div>
                @endif
                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center m-3">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-s font-weight-bolder">#</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.name') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.category') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.price') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.quantity') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.color') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.width') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.height') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.depth') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.weight') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.created_at') }}</th>
                                    @if(auth('admin')->user()->can('delete_product'))
                                        <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.status') }}</th>
                                        <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.action') }}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($products as $key => $product)
                                    <tr>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $loop->iteration + $products->firstItem() - 1 }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $product->full_name }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $product->category->name }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ Number::currency($product->price, 'EGP') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $product->qty }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $product->color }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $product->width }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $product->height }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $product->depth }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $product->weight }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $product->created_at->format('Y-m-d h:i a') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if(auth('admin')->user()->can('delete_product'))
                                                <a href="{{ route('admin.products.changeStatus', $product->id) }}">
                                                <span class="badge badge-sm bg-gradient-@if($product->status==1)success @else()danger @endif ">{{ $product->status==1?'Active':'Inactive' }}</span>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if(auth('admin')->user()->can('show_product'))
                                                <a href="javascript:void(0)" class="badge bg-gradient-primary" data-bs-toggle="modal"
                                                   data-bs-target="#view-product-{{ $product->id }}"><i class="fa fa-eye"></i></a>
                                            @endif
                                                @if(auth('admin')->user()->can('edit_product'))
                                                <a href="{{ route('admin.products.edit', ['product' => $product]) }}" class="badge badge-sm bg-gradient-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            @endif
                                                @if(auth('admin')->user()->can('delete_product'))
                                                <form method="POST" class="delete-form" style="display: inline"  data-route="{{route('admin.products.destroy',$product)}}">
                                                    @csrf
                                                    @method('delete')

                                                    <button type="submit" style="border: 0" class="badge badge-sm bg-gradient-danger">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @if(auth('admin')->user()->can('show_product'))
                                        @include('admin.product.view')
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="7" class="align-middle text-center"><span class="text-m font-weight-bold">No Products</span></td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $products->links() }}
            </div>
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
                                    window.location='/admin/products'
                                });
                            }
                        });
                    }
                });

            })
        });
    </script>
@endpush
