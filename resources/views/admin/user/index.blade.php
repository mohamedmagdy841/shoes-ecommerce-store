@extends('admin.master')
@section('title',  __('keywords.manage') . ' ' . __('keywords.users'))
@section('subtitle', __('keywords.manage') . ' ' . __('keywords.users'))
@section('user active', 'active')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center m-3">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-s font-weight-bolder">#</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.name') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.email') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.phone') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.address') }}</th>
                                    <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.created_at') }}</th>
                                    @if(auth('admin')->user()->can('delete_user'))
                                        <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.status') }}</th>
                                        <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.action') }}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $key => $user)
                                    <tr>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $loop->iteration + $users->firstItem() - 1 }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $user->name }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $user->email }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $user->phone }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $user->full_address }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $user->created_at->format('Y-m-d h-i a') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if(auth('admin')->user()->can('delete_user'))
                                                <a href="{{ route('admin.users.changeStatus', $user->id) }}">
                                                <span class="badge badge-sm bg-gradient-@if($user->status==1)success @else()danger @endif ">{{ $user->status==1?'Active':'Not Active' }}</span>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if(auth('admin')->user()->can('delete_user'))
                                                <form method="POST" class="delete-form"  data-route="{{route('admin.users.destroy',['id' => $user->id])}}">
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
                                        <td colspan="7" class="align-middle text-center"><span class="text-m font-weight-bold">No Users</span></td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $users->links() }}
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
                                    window.location='/admin/users'
                                });
                            }
                        });
                    }
                });

            })
        });
    </script>
@endpush
