@extends('frontend.master')
@section('title',  config('APP_NAME') . "|" . 'User Reset Password')
@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Reset Password</h1>
{{--                    <nav class="d-flex align-items-center">--}}
{{--                        <a href="{{ route('frontend.index') }}">Home<span class="lnr lnr-arrow-right"></span></a>--}}
{{--                        <a href="{{ route('password.request') }}">Forgot Password</a>--}}
{{--                    </nav>--}}
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('login-active', 'active')

@section('content')
    <!--================Login Box Area =================-->
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="login_form_inner">
                        <h3>Reset Password</h3>

                        <form class="row login_form" action="{{ route('password.store') }}" method="post" id="contactForm">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" id="email" name="email" value="{{ old("email") }}" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="New Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirm Password'">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="primary-btn">Reset Password</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->
@endsection
