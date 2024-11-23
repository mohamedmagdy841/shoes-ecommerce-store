@extends('frontend.master')

@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Login</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('frontend.index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('login') }}">Login</a>
                    </nav>
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
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="{{ asset('assets/frontend') }}/img/login.jpg" alt="">
                        <div class="hover">
                            <h4>New to our website?</h4>
                            <a class="primary-btn" href="{{ route('register') }}">Create an Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Login</h3>

                        <form class="row login_form" action="{{ route('login') }}" method="post" id="contactForm">
                            @csrf
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" id="email" name="email" value="{{ old("email") }}" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="creat_account">
                                    <input type="checkbox" id="f-option2" name="selector">
                                    <label for="f-option2">Keep me logged in</label>
                                </div>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="col-md-12 form-group">
                                    <button type="submit" value="submit" class="primary-btn">Sign In</button>
                                    <a href="#">Forgot Password?</a>
                                </div>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->
@endsection
