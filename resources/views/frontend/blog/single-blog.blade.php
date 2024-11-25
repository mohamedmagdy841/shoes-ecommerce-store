@extends('frontend.master')

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
                <div class="col-lg-8 posts-list">
                    <div class="single-post row">
                        <div class="col-lg-12">
                            <div class="feature-img">
                                <img style="max-width: 100%;" src="{{ asset('storage/blog/' . $mainBlog->image) }}" alt="{{ $mainBlog->title }}">
                            </div>
                        </div>
                        <div class="col-lg-3  col-md-3">
                            <div class="blog_info text-right">
                                <div class="post_tag">
                                    <a href="#">Food,</a>
                                    <a class="active" href="#">Technology,</a>
                                    <a href="#">Politics,</a>
                                    <a href="#">Lifestyle</a>
                                </div>
                                <ul class="blog_meta list">
                                    <li><a href="#">{{ $mainBlog->user->name }}<i class="lnr lnr-user"></i></a></li>
                                    <li><a href="#">{{ $mainBlog->created_at->format("d M Y") }}<i class="lnr lnr-calendar-full"></i></a></li>
                                    <li><a href="#">{{ $mainBlog->number_of_views }} Views<i class="lnr lnr-eye"></i></a></li>
                                    <li><a href="#">@if (count($mainBlog->blog_comments) > 0) {{ count($mainBlog->blog_comments) }} @else 0 @endif Comments<i class="lnr lnr-bubble"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 blog_details">
                            <h2>{{ $mainBlog->title }}</h2>
                            <p class="excert">
                                {{ $mainBlog->description }}
                            </p>
                        </div>
                    </div>
                    @php
                         $num_of_comments = \App\Models\BlogPost::whereSlug($mainBlog->slug)->first()->blog_comments
                    @endphp
                    <div class="comments-area">
                        <h4>@if (count($num_of_comments) > 0) {{ count($num_of_comments) }} @else 0 @endif Comments</h4>
                        @if (count($num_of_comments) > 0)
                            <div class="comments">
                                @foreach($mainBlog->blog_comments as $comment)
                                    <div class="comment-list">
                                        <div class="single-comment justify-content-between d-flex">
                                            <div class="user justify-content-between d-flex">
                                                <div class="desc">
                                                    <h5><a href="#">{{ $comment->name }}</a></h5>
                                                    <p class="date">{{ $comment->created_at->format("M d, Y h:i A") }}</p>
                                                    <p class="comment">
                                                        {{ $comment->comment }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="width:100%; border-top: 1px solid #ffba00;">
                                @endforeach
                            </div>
                            @if(count($num_of_comments) > 3)
                                <div class="text-center">
                                    <button id="showMore" class="primary-btn submit_btn">View More</button>
                                </div>
                            @endif
                        @endif

                    </div>
                    <div class="comment-form">
                        <h4>Leave a Reply</h4>
                        <form method="post" action="{{ route("blogs.comments.store") }}">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $mainBlog->id }}">
                            <div class="form-group form-inline">
                                <div class="form-group col-lg-6 col-md-6 name">
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old("name") }}" placeholder="Enter Name" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = 'Enter Name'">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="form-group col-lg-6 col-md-6 email">
                                    <input type="text" class="form-control" name="subject" id="subject" value="{{ old("subject") }}" placeholder="Subject" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = 'Subject'">
                                    <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control mb-10" rows="5" name="comment" placeholder="Message"
                                          onfocus="this.placeholder = ''" onblur="this.placeholder = 'Message'" required="">{{ old("name") }}</textarea>
                                <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                            </div>
                            <button type="submit" class="primary-btn submit_btn">Post Comment</button>
                        </form>
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

@push('js')
    <script>
        const { format } = window.dateFns;

        $(document).on('click', '#showMore', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('blogs.comments', ['slug' => $mainBlog->slug]) }}",
                type: 'GET',
                success: function (data) {
                    $('.comments').empty();
                    $.each(data, function (key, comment) {

                        const createdAt = new Date(comment.created_at);
                        const formattedDate = format(createdAt, 'MMM dd, yyyy hh:mm a');

                        $('.comments').append(`
                            <div class="comment-list">
                            <div class="single-comment justify-content-between d-flex">
                                <div class="user justify-content-between d-flex">
                                    <div class="desc">
                                        <h5><a href="#">${ comment.name }</a></h5>
                                        <p class="date">${ formattedDate  }</p>
                                        <p class="comment">
                                            ${ comment.comment }
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="width:100%; border-top: 1px solid #ffba00;">`
                        );
                        $('#showMore').hide();
                    });
                },
                error: function(data) {
                    console.error("An error occurred:", data);
                },
            });
        })
    </script>
@endpush
