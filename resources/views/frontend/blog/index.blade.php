@extends('frontend.master')
@section('title',  config('APP_NAME') . "|" . 'All Blogs')
@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Blog</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('frontend.index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('blogs.index') }}">Blog</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('blog-active', 'active')

@section('content')

    <!--================Blog Area =================-->
    <section class="blog_area m-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
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
                <div class="col-lg-4">
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
                            <div class="br"></div>
                        </aside>

                        <aside class="single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">Popular Posts</h3>
                            @if(count($most_viewed) > 0)
                                @foreach($most_viewed as $blog)
                                    <div class="media post_item">
                                        <img src="{{ $blog->image }}" alt="post" style="width: 80px; height: 80px;">
                                        <div class="media-body">
                                            <a href="blog-details.html">
                                                <h3>{{ $blog->title }}</h3>
                                            </a>
                                            <p>{{ $blog->number_of_views }} Views</p>
                                        </div>
                                    </div>
                                    <div class="br"></div>
                                @endforeach
                            @endif
                        </aside>
                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Categories</h4>
                            <ul class="list cat-list">
                                @if(count($categories) > 0)
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('blogs.category', $category->id) }}" class="d-flex justify-content-between">
                                                <p>{{ $category->name }}</p>
                                                <p>@if (count($category->blog_posts) > 0) {{ count($category->blog_posts) }} @else 0 @endif</p>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <div class="br"></div>
                        </aside>
                        <aside class="single-sidebar-widget newsletter_widget">
                            <h4 class="widget_title">Newsletter</h4>
                            <p>
                                Stay update with our latest blogs.
                            </p>
                            <div class="form-group d-flex flex-row">
                                <form method="post" action="{{ route('blogs.newsletter') }}" class="form-inline">
                                    @csrf
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                        </div>
                                        <input type="email" name="email" class="form-control" id="inlineFormInputGroup" placeholder="Enter email"
                                               onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email'">
                                    </div>
                                    <button style="border: 0" type="submit" class="bbtns click-btn btn btn-default">Subcribe</button>
{{--                                    <a href="#" class="bbtns">Subcribe</a>--}}
                                </form>
                            </div>
                            <p class="text-bottom">You can unsubscribe at any time</p>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            <div class="br"></div>
                        </aside>
                        <aside class="single-sidebar-widget tag_cloud_widget">
                            <h4 class="widget_title">Tag Clouds</h4>
                            <ul class="list">
                                <li><a href="#">Technology</a></li>
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">Architecture</a></li>
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">Food</a></li>
                                <li><a href="#">Technology</a></li>
                                <li><a href="#">Lifestyle</a></li>
                                <li><a href="#">Art</a></li>
                                <li><a href="#">Adventure</a></li>
                                <li><a href="#">Food</a></li>
                                <li><a href="#">Lifestyle</a></li>
                                <li><a href="#">Adventure</a></li>
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Blog Area =================-->
@endsection
