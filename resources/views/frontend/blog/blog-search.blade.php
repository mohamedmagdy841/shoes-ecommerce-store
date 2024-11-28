@extends('frontend.master')

@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('content')
    <!--================Blog Area =================-->
    <section class="blog_area m-5">
        <div class="container">
            <div class="col-lg-12">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget search_widget">
                        <div class="input-group">
                            <form action="{{ route('blogs.search') }}" method="post">
                                @csrf
                                <input type="text" class="form-control" name="search" placeholder="Search Posts" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Posts'">
                                <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="lnr lnr-magnifier"></i></button>
                                    </span>
                            </form>
                        </div><!-- /input-group -->
                    </aside>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mt-5">
                    <div class="blog_left_sidebar">
                        @if(count($blogs) > 0)
                            @foreach($blogs as $blog)
                                <article class="row blog_item">
                                    <div class="col-md-3">
                                        <div class="blog_info text-right">
                                            <div class="post_tag">
                                                <a href="#">Food,</a>
                                                <a class="active" href="#">Technology,</a>
                                                <a href="#">Politics,</a>
                                                <a href="#">Lifestyle</a>
                                            </div>
                                            <ul class="blog_meta list">
                                                <li><a href="#">{{ $blog->user->name }}<i class="lnr lnr-user"></i></a></li>
                                                <li><a href="#">{{ $blog->created_at->format("d M Y") }}<i class="lnr lnr-calendar-full"></i></a></li>
                                                <li><a href="#">{{ $blog->number_of_views }} Views<i class="lnr lnr-eye"></i></a></li>
                                                <li><a href="#">@if (count($blog->blog_comments) > 0) {{ count($blog->blog_comments) }} @else 0 @endif Comments<i class="lnr lnr-bubble"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="blog_post">
                                            <a href="{{ route('blogs.show', ['blog' => $blog]) }}">
                                                <img src="{{ asset('storage/blog/' . $blog->image) }}" alt="{{ $blog->title }}">
                                            </a>
                                            <div class="blog_details">
                                                <a href="{{ route('blogs.show', ['blog' => $blog]) }}">
                                                    <h2>{{ $blog->title }}</h2>
                                                </a>
                                                <p>{{ $blog->description }}</p>
                                                <a href="{{ route('blogs.show', ['blog' => $blog]) }}" class="white_bg_btn">View More</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                            <div class="mb-3">

                                {{$blogs->links()}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Blog Area =================-->
@endsection