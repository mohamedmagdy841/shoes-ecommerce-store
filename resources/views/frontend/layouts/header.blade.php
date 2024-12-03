<!-- Start Header Area -->
<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="{{ route('frontend.index') }}"><img src="{{ asset('assets/frontend') }}/img/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item @yield('home-active')"><a class="nav-link" href="{{ route('frontend.index') }}">Home</a></li>
                        <li class="nav-item submenu dropdown @yield('shop-active')">
                            <a href="{{ route('frontend.shop') }}" class="nav-link" >Shop</a>
                        </li>
                        <li class="nav-item submenu dropdown @yield('blog-active')">
                            <a href="{{ route('blogs.index') }}" class="nav-link">Blog</a>
                        </li>
                        @guest
                            <li class="nav-item @yield('login-active')"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @endguest
                        @auth
                            <li class="nav-item submenu dropdown ">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                   aria-expanded="false">{{ Auth::user()->name }}</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{ route("frontend.profile.edit") }}">My Profile</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route("blogs.myBlogs") }}">My Blogs</a></li>
                                    <li class="nav-item">
                                        <form action="{{ route('logout') }}" method="post" id="logout_form">
                                            @csrf
                                            <a class="nav-link text-danger"
                                               href="javascript:$('form#logout_form').submit();">Logout</a>
                                        </form>
                                    </li>

                                </ul>
                            </li>
                        @endauth

                        <li class="nav-item @yield('contact-active')"><a class="nav-link" href="{{ route('frontend.contact') }}">Contact</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item">
                            <a href="{{ route('frontend.wishlist.get') }}" class="cart">
                                <span class="lnr lnr-heart"></span>
                                <span class="wishlist-counter text-danger">0</span>
                            </a>
                        </li>
                        <li class="nav-item"><a href="#" class="cart"><span class="ti-bag"></span></a></li>
                        <li class="nav-item">
                            <button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="search_input" id="search_input_box">
        <div class="container">
            <form class="d-flex justify-content-between" method="post" action="{{ route('frontend.search') }}">
                @csrf
                <input type="text" name="search" class="form-control" id="search_input" placeholder="Search Here">
                <button type="submit" class="btn"></button>
                <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
            </form>
        </div>
    </div>
</header>
<!-- End Header Area -->
@push('js')
    <script>
        $(document).ready(function () {
            function updateWishlistCounter() {
                $.ajax({
                    url: '{{ route("frontend.wishlist.get") }}',
                    method: 'GET',
                    success: function (data) {
                        let wishlistCount = data.wishlistCount || 0;
                        let counterElement = $('.wishlist-counter');

                        if (wishlistCount > 0) {
                            counterElement.text(wishlistCount).show();
                        } else {
                            counterElement.hide();
                        }
                    },
                    error: function () {
                        console.error('Failed to fetch wishlist count.');
                    }
                });
            }

            updateWishlistCounter();

            $('.addToWishlist').on('click', function () {
                updateWishlistCounter();
            });
        });

    </script>
@endpush
