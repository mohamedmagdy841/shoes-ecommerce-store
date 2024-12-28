@extends('admin.master')
@section('title', 'Edit Profile')
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
        <form method="post" action="{{ route('admin.profile.update', $admin) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" value="{{ $admin->name }}" class="form-control" id="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="street" class="form-label">Street</label>
                        <input type="text" name="street" value="{{ $admin->street }}" class="form-control" id="street">
                        <x-input-error :messages="$errors->get('street')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" value="{{ $admin->city }}" class="form-control" id="city">
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" name="country" value="{{ $admin->country }}" class="form-control" id="country">
                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                    </div>

                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ $admin->email }}" class="form-control" id="email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" value="{{ $admin->phone }}" class="form-control" id="phone">
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Password Confirmation</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirm Password'">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
{{--                    <div class="mb-3">--}}
{{--                        <label for="image" class="form-label">Upload Image</label>--}}
{{--                        <input class="form-control" name="image" type="file" id="image">--}}
{{--                        <x-input-error :messages="$errors->get('image')" class="mt-2" />--}}
{{--                    </div>--}}
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
