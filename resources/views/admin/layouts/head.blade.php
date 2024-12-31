<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/admin') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('assets/admin') }}/img/favicon.png">
    <title>
        {{ __('keywords.dashboard') }} | @yield('title')
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/admin') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets/admin') }}/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/font-awesome.min.css">

    <link href="{{ asset('assets/admin') }}/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/admin') }}/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">


    @vite('resources/js/app.js')
</head>
