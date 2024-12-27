@extends('admin.master')
@section('title', 'Manage Roles')
@section('role active', 'active')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="text-end">
                <a href="{{ route('admin.roles.create') }}" class="btn bg-gradient-primary">
                    Add New Role
                </a>
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
                                    <th class="text-uppercase text-s font-weight-bolder">Created At</th>
                                    <th class="text-uppercase text-s font-weight-bolder">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($roles as $key => $role)
                                    <tr>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $loop->iteration + $roles->firstItem() - 1 }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $role->name }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class=" text-s">{{ $role->created_at->format('Y-m-d h-i a') }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <a href="{{ route('admin.roles.edit', ['role' => $role]) }}" class="badge badge-sm bg-gradient-info"><i class="fa fa-edit" aria-hidden="true"></i></a>

                                            <form method="POST" class="delete-form" style="display: inline"  action="{{route('admin.roles.destroy',['role' => $role])}}">
                                                @csrf
                                                @method('delete')

                                                <button type="submit" style="border: 0" class="badge badge-sm bg-gradient-danger">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="align-middle text-center"><span class="text-m font-weight-bold text-danger">No roles</span></td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection
