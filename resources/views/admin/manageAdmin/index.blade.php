@extends('admin.master')
@section('title', 'Manage Admins')
@section('admin active', 'active')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="text-end">
                <!-- Button trigger modal -->
                @if(auth('admin')->user()->can('add_admin'))
                    <a href="{{ route('admin.admins.create') }}" class="btn bg-gradient-primary">
                        Add New Product
                    </a>
                @endif
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center m-3">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-s font-weight-bolder">#</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Name</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Email</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Role</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Created At</th>
                                    @if(auth('admin')->user()->can('delete_admin'))
                                        <th class="text-uppercase text-s font-weight-bolder">Status</th>
                                        <th class="text-uppercase text-s font-weight-bolder">Action</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($admins as $key => $admin)
                                    <tr>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $loop->iteration + $admins->firstItem() - 1 }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $admin->name }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $admin->email }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $admin->getRoleNames()[0] }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $admin->created_at->format('Y-m-d h-i a') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if(auth('admin')->user()->can('delete_admin'))
                                                <a href="{{ route('admin.admins.changeStatus', $admin->id) }}">
                                                    <span class="badge badge-sm bg-gradient-@if($admin->status==1)success @else()danger @endif ">{{ $admin->status==1?'Active':'Not Active' }}</span>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if(auth('admin')->user()->can('edit_admin'))
                                                <a href="{{ route('admin.admins.edit', ['admin' => $admin]) }}" class="badge badge-sm bg-gradient-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            @endif
                                            @if(auth('admin')->user()->can('delete_admin'))
                                                <form method="POST" class="delete-form" style="display: inline"  data-route="{{route('admin.admins.destroy',['admin' => $admin])}}">
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
                                        <td colspan="7" class="align-middle text-center"><span class="text-m font-weight-bold text-danger">No Admins</span></td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                            {{ $admins->links() }}
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
                                    window.location='/admin/admins'
                                });
                            }
                        });
                    }
                });

            })
        });
    </script>
@endpush
