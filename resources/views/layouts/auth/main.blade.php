<!doctype html>
<html lang="fa-IR" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Hesam Jafarzadeh">
    <title>@yield('page_title','پنل ادمین')</title>

    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-12 col-sm-4">
            @if( session()->has('alert') )
                <div class="mt-3 alert alert-{{ session('alert')['type'] }}">
                    {{ session('alert')['message'] }}
                </div>
            @endif
            @yield('content')
        </div>
        <div class="col-sm-4"></div>
    </div>
</div>
</body>
</html>
