<!DOCTYPE html>
<html lang="zxx" class="no-js">

@include('frontend.layouts.head')

<body>

@include('frontend.layouts.header')

@yield('banner')

@yield('content')

@include('frontend.layouts.footer')

@include('frontend.layouts.scripts')
</body>

</html>
