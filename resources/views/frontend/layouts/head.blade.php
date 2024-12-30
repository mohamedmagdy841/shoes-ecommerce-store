<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('assets/frontend') }}/img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" >


    <!--
        CSS
        ============================================= -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/linearicons.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/nice-select.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/nouislider.min.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('g-recaptcha', {
                'sitekey': '{{ config("services.recaptcha.site_key") }}'
            });
        };
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
    </script>
</head>
