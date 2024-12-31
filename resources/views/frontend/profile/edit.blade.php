@extends('frontend.master')
@section('title',  config('app.name') . " | " . 'My Profile')
@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>My Profile</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('frontend.index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('frontend.profile.edit') }}">My Profile</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('content')
    <div class="container py-5">
        <h4>Update profile</h4>
        <br>
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

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
        <form method="post" action="{{ route('frontend.profile.update') }}">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" id="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" id="email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800">
                                    {{ __('Your email address is unverified.') }}

                                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" id="phone">
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="street" class="form-label">Street</label>
                        <input name="street" value="{{ old('street', $user->street) }}" class="form-control" id="street">
                        <x-input-error :messages="$errors->get('street')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}" class="form-control" id="city">
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" name="country" value="{{ old('country', $user->country) }}" class="form-control" id="country">
                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                    </div>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-warning">Update</button>
                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </div>
        </form>
            <br>
            <br>
            <h4>Update Password</h4>
            <br>

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" value="{{ old('current_password') }}" class="form-control" id="current_password">
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label for="update_password_password" class="form-label">New Password</label>
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control" id="update_password_password">
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control" id="update_password_password_confirmation">
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-warning">Save</button>
                        @if (session('status') === 'password-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </div>
            </form>

        <br>
        <br>
        <h4>Delete Account</h4>
        <br>

        <form method="post" action="{{ route('frontend.profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="row">
                <div class="col-6">
                    <p class="text-sm text-gray-600">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" value="{{ old('password') }}" class="form-control" id="password">
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
    <!--================Contact Area =================-->
@endsection
