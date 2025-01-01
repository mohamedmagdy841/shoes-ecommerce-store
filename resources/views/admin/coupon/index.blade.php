@extends('admin.master')
@section('title', __('keywords.manage') . ' ' . __('keywords.coupons'))
@section('subtitle', __('keywords.manage') . ' ' . __('keywords.coupons'))
@section('coupon active', 'active')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">

                @if(auth('admin')->user()->can('add_coupon'))
                    <div class="text-end">
                        <a href="{{ route('admin.coupons.create') }}" class="btn bg-gradient-primary">
                            {{ __('keywords.add_new_coupon') }}
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
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.code') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.limit') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.type') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.value') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.start_date') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.end_date') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.is_valid') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.created_at') }}</th>
                                    @if(auth('admin')->user()->can('delete_coupon'))
                                        <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.action') }}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($coupons as $key => $coupon)
                                    <tr>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $loop->iteration + $coupons->firstItem() - 1 }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $coupon->code }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $coupon->limit }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $coupon->type }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $coupon->value }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $coupon->start_date->format('Y-m-d h:i a') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $coupon->end_date->format('Y-m-d h:i a') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-sm bg-gradient-@if($coupon->is_valid==1)success @else()danger @endif ">{{ $coupon->is_valid==1?'Valid':'Not Valid' }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $coupon->created_at->format('Y-m-d h:i a') }}</span>
                                        </td>
                                        <td class="align-middle">
                                                @if(auth('admin')->user()->can('edit_coupon'))
                                                    <a href="{{ route('admin.coupons.edit', ['coupon' => $coupon]) }}" class="badge badge-sm bg-gradient-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                @endif
                                                @if(auth('admin')->user()->can('delete_coupon'))
                                                    <form method="POST" class="delete-form" style="display: inline"  data-route="{{route('admin.coupons.destroy',$coupon)}}">
                                                        @csrf
                                                        @method('delete')

                                                        <button type="submit" style="border: 0" class="badge badge-sm bg-gradient-danger">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="align-middle text-center"><span class="text-m font-weight-bold">No coupons</span></td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $coupons->links() }}
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
                                    window.location='/admin/coupons'
                                });
                            }
                        });
                    }
                });

            })
        });
    </script>
@endpush
