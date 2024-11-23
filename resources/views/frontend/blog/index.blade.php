@extends('frontend.master')

@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Blog Page</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Blog</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('blog-active', 'active')

@section('content')
    <!--================Blog Categorie Area =================-->
    <section class="blog_categorie_area">
        <div class="container">
            <div class="row">
                @if(count($categories) > 0)
                    @foreach($categories as $category)
                        <div class="col-lg-3">
                            <div class="categories_post">
                                <img src="{{ asset('assets/frontend') }}/img/blog/cat-post/cat-post-3.jpg" alt="post">
                                <div class="categories_details">
                                    <div class="categories_text">
                                        <a href="blog-details.html">
                                            <h5>{{ $category->name }}</h5>
                                        </a>
                                        <div class="border_line"></div>
                                        <p>Enjoy your social life together</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>
    <!--================Blog Categorie Area =================-->

    <!--================Blog Area =================-->
    <section class="blog_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog_left_sidebar">
                        @if(count($posts) > 0)
                            @foreach($posts as $post)
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
                                                <li><a href="#">{{ $post->user->name }}<i class="lnr lnr-user"></i></a></li>
                                                <li><a href="#">{{ $post->created_at->format("d M Y") }}<i class="lnr lnr-calendar-full"></i></a></li>
                                                <li><a href="#">{{ $post->number_of_views }} Views<i class="lnr lnr-eye"></i></a></li>
                                                <li><a href="#">@if (count($post->blog_comments) > 0) {{ count($post->blog_comments) }} @else 0 @endif Comments<i class="lnr lnr-bubble"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="blog_post">
                                            <img src="{{ $post->image }}" alt="">
                                            <div class="blog_details">
                                                <a href="single-blog.html">
                                                    <h2>{{ $post->title }}</h2>
                                                </a>
                                                <p>{{ $post->description }}</p>
                                                <a href="single-blog.html" class="white_bg_btn">View More</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                            <div class="mb-3">

                            {{$posts->links()}}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget search_widget">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Posts" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Posts'">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="lnr lnr-magnifier"></i></button>
                                </span>
                            </div><!-- /input-group -->
                            <div class="br"></div>
                        </aside>
                        <aside class="single_sidebar_widget author_widget">
                            <img class="author_img rounded-circle" src="{{ asset('assets/frontend') }}/img/blog/author.png" alt="">
                            <h4>Charlie Barber</h4>
                            <p>Senior blog writer</p>
                            <div class="social_icon">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-github"></i></a>
                                <a href="#"><i class="fa fa-behance"></i></a>
                            </div>
                            <p>Boot camps have its supporters andit sdetractors. Some people do not understand why you
                                should have to spend money on boot camp when you can get. Boot camps have itssuppor
                                ters andits detractors.</p>
                            <div class="br"></div>
                        </aside>
                        <aside class="single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">Popular Posts</h3>
                            @if(count($most_viewed) > 0)
                                @foreach($most_viewed as $post)
                                    <div class="media post_item">
                                        <img src="{{ $post->image }}" alt="post" style="width: 80px; height: 80px;">
                                        <div class="media-body">
                                            <a href="blog-details.html">
                                                <h3>{{ $post->title }}</h3>
                                            </a>
                                            <p>{{ $post->number_of_views }} Views</p>
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
                                            <a href="#" class="d-flex justify-content-between">
                                                <p>{{ $category->name }}</p>
                                                <p>@if (count($categories) > 0) {{ count($categories) }} @else 0 @endif</p>
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
                                Here, I focus on a range of items and features that we use in life without
                                giving them a second thought.
                            </p>
                            <div class="form-group d-flex flex-row">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Enter email"
                                           onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email'">
                                </div>
                                <a href="#" class="bbtns">Subcribe</a>
                            </div>
                            <p class="text-bottom">You can unsubscribe at any time</p>
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
