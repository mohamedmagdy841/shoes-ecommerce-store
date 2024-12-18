@extends('admin.master')
@section('title', 'Manage Products')
@section('product active', 'active')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">

                <div class="text-end">
                    <!-- Button trigger modal -->
                    <a href="{{ route('admin.products.create') }}" class="btn bg-gradient-primary">
                        Add New Product
                    </a>
                </div>

                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center m-3">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-s font-weight-bolder">#</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Name</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Category</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Price</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Quantity</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Color</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Width</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Height</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Depth</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Weight</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Created At</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Status</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Action</th>
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
                                            <a href="{{ route('admin.products.changeStatus', $product->id) }}">
                                            <span class="badge badge-sm bg-gradient-@if($product->status==1)success @else()danger @endif ">{{ $product->status==1?'Active':'Not Active' }}</span>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <a href="javascript:void(0)" class="badge bg-gradient-primary" data-bs-toggle="modal"
                                               data-bs-target="#edit-category-{{ $product->id }}"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('admin.products.edit', ['product' => $product]) }}" class="badge badge-sm bg-gradient-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            <form method="POST" class="delete-form" style="display: inline"  data-route="{{route('admin.products.destroy',$product)}}">
                                                @csrf
                                                @method('delete')

                                                <button type="submit" style="border: 0" class="badge badge-sm bg-gradient-danger">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @include('admin.product.view')
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
