<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>403</title>
    <link rel="stylesheet" href="{{ asset('assets/errors/403/style.css') }}">
</head>
<body>
    <div class="text-wrapper">
        <div class="title" data-content="404">
            403 - ACCESS DENIED
        </div>

        <div class="subtitle">
            Oops, You don't have permission to access this page.
        </div>
        <div class="isi">
            Please Contact The Admin.
        </div>

        <div class="buttons">
{{--            <a class="button" href="https://www.brodroid.com">Go to homepage</a>--}}
        <form action="{{ route('admin.logout') }}" method="post" id="logout_form">
            @csrf
            <a class="button" href="javascript:void(0);" onclick="document.getElementById('logout_form').submit();">Logout</a>
        </form>
        </div>

    </div>
    <script src="{{ asset('assets/errors/403/script.js') }}"></script>
</body>
</html>
