@extends('frontend.master')

@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Forgot Password</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('frontend.index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('password.request') }}">Forgot Password</a>
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
                <div class="col-lg-12">
                    <div class="login_form_inner">
                        <h3>Forgot Password</h3>

                        <form class="row login_form" action="{{ route('password.email') }}" method="post" id="contactForm">
                            @csrf
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" id="email" name="email" value="{{ old("email") }}" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="primary-btn">Email Password Reset Link</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->
@endsection

