@php use Mcamara\LaravelLocalization\Facades\LaravelLocalization; @endphp
<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <h6 class="font-weight-bolder mt-2">@yield('subtitle')</h6>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 @if (LaravelLocalization::getCurrentLocale() == 'ar') px-0 @else me-md-0 me-sm-4 @endif " id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">

            <!-- Topbar Search -->
                <form action="{{ route('admin.search') }}" method="get" class="mt-3 p-1">
                    <div class="input-group" >
                        <input style="height: 40px;" name="keyword" type="text" class="form-control" placeholder="{{ __('keywords.search') }}">
                        <select style="height: 40px; padding-left: 1rem; border: 2px"  name="option" class="form-control bg-light" >
                            <option selected disabled>{{ __('keywords.choose') }}</option>
                            @if(auth('admin')->user()->can('manage_orders'))
                                <option value="order">{{ __('keywords.orders') }}</option>
                            @endif
                            @if(auth('admin')->user()->can('manage_users'))
                                <option value="user">{{ __('keywords.users') }}</option>
                            @endif
                            @if(auth('admin')->user()->can('add_category'))
                                <option value="category">{{ __('keywords.categories') }}</option>
                            @endif
                            @if(auth('admin')->user()->can('add_product'))
                                <option value="product">{{ __('keywords.products') }}</option>
                            @endif
                        </select>
                        <div class="input-group-append" style="padding-left: 0.1rem;">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            <!-- Example single danger button -->

            <div class="btn-group">
                    <button type="button" style="margin-bottom: 0;" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth('admin')->user()->name }}
                    </button>
                <ul class="dropdown-menu border">
                    <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}">{{ __('keywords.profile') }}</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="post" id="logout_form">
                            @csrf
                            <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="document.getElementById('logout_form').submit();">{{ __('keywords.logout') }}</a>
                        </form>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 notificationsIcon" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                        <span class="dot dot-md text-danger" id="notificationsIconCounter">{{ count(Auth::guard('admin')->user()->unreadnotifications) }}</span>
                    </a>
                    <ul  class="dropdown-menu dropdown-menu-end  px-2 py-3 me-sm-n4" id="notificationsModal" aria-labelledby="dropdownMenuButton">
                        @forelse(Auth::guard('admin')->user()->notifications->take(5) as $notification)
                            <li  style="background-color: @if($notification->unread()) #E8E8E8 @else white @endif"   class="mb-2">
                                <a class="dropdown-item border-radius-md " href="javascript:;">
                                    <div class="d-flex py-1 " >
                                        <div class="d-flex flex-column justify-content-center" >
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">New User Registered</span>
                                            </h6>
                                            <p class="text-xs mb-3">
                                                {{ $notification->data['name'] }}
                                            </p>
                                            <p class="text-xs text-secondary mb-0">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">No Notifications</span>
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforelse
                        <div class="text-center">
                            <button class="btn btn-primary btn-sm" id="clearNotifications">Clear All</button>
                        </div>
                    </ul>
                </li>
                <li class="nav-item dropdown pe-2 px-3 d-flex align-items-center">
                    @php
                        $locale = LaravelLocalization::getCurrentLocale() == 'ar' ? 'en' : 'ar';
                    @endphp
                    <a class="nav-link text-muted my-2" href="{{ LaravelLocalization::getLocalizedURL($locale) }}" id="langSwitcher">
                        {{ $locale == 'ar' ? 'عربي':'English' }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
    </div>
</nav>
<!-- End Navbar -->

@push('js')
     <script>
    $("document").ready(function() {
        // ======================================= MARK ALL NOTIFICATION TO READ
        $(document).on('click', ".notificationsIcon", function() {
            $.ajax({
                url: {{ Illuminate\Support\Js::from(route('admin.notifications.read')) }},
                method: 'get',
                success: function(data) {
                    $("#notificationsIconCounter").load(" #notificationsIconCounter > *");
                    $("#notificationsModal").load(" #notificationsModal > *");
                },
                error: function() {
                    alert('Please try again ...');
                },
            });
        });

        // ======================================= CLEAR ALL NOTIFICATION
        $(document).on('click', "#clearNotifications", function() {
            $.ajax({
                url: {{ Illuminate\Support\Js::from(route('admin.notifications.clear')) }},
                method: 'get',
                success: function(data) {
                    $("#notificationsIconCounter").load(" #notificationsIconCounter > *");
                    $("#notificationsModal").load(" #notificationsModal > *");
                },
                erorr: function() {
                    alert('Please try again ...');
                },
            });
        });

    });

</script>
@endpush
