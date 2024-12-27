@extends('admin.master')
@section('title', 'Add New role')
@section('role active', 'active')
@section('content')
    <div class="container py-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                There were some errors with your request.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('admin.roles.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>
                <div class="form-group col-12 mt-2">
                    <div class="row">
                        @if (count($permissions) > 0)
                            @foreach ($permissions as $permission)
                                <div class="col-md-6">
                                    <div class="form-check form-check-primary mt-1">
                                        <input class="form-check-input" type="checkbox"
                                               name="permissionArray[{{ $permission->name }}]"
                                               id="formCheckcolor{{ $permission->id }}">
                                        <label class="form-check-label"
                                               for="formCheckcolor{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
    </script>
@endpush
