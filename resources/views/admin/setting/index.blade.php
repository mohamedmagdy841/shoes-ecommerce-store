@extends('admin.master')
@section('title', 'Manage Settings')
@section('setting active', 'active')
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
        <form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" name="site_name" value="{{ $getSetting->site_name }}" class="form-control" id="name">
                        <x-input-error :messages="$errors->get('site_name')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" name="facebook" value="{{ $getSetting->facebook }}" class="form-control" id="facebook">
                        <x-input-error :messages="$errors->get('facebook')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="x" class="form-label">X</label>
                        <input type="text" name="x" value="{{ $getSetting->x }}" class="form-control" id="x">
                        <x-input-error :messages="$errors->get('x')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="instagram" class="form-label">Instagram</label>
                        <input type="text" name="instagram" value="{{ $getSetting->instagram }}" class="form-control" id="instagram">
                        <x-input-error :messages="$errors->get('instagram')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="youtube" class="form-label">Youtube</label>
                        <input type="text" name="youtube" value="{{ $getSetting->youtube }}" class="form-control" id="youtube">
                        <x-input-error :messages="$errors->get('youtube')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="about_us" class="form-label">About Us</label>
                        <textarea name="about_us" class="form-control" id="about_us">{{ $getSetting->about_us }}</textarea>
                        <x-input-error :messages="$errors->get('about_us')" class="mt-2" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="street" class="form-label">Street</label>
                        <input type="text" name="street" value="{{ $getSetting->street }}" class="form-control" id="street">
                        <x-input-error :messages="$errors->get('street')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" value="{{ $getSetting->city }}" class="form-control" id="city">
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" name="country" value="{{ $getSetting->country }}" class="form-control" id="country">
                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ $getSetting->email }}" class="form-control" id="email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" value="{{ $getSetting->phone }}" class="form-control" id="phone">
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <label for="favicon" class="form-label">Favicon</label>
                        <input class="form-control" name="favicon" type="file" id="favicon">
                        <x-input-error :messages="$errors->get('favicon')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input class="form-control" name="logo" type="file" id="logo">
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>
                </div>
                @if(auth('admin')->user()->can('manage_settings'))
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                @endif
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
    </script>
@endpush
