<!DOCTYPE html>
<html dir="rtl" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="_token" content="{{csrf_token()}}"/>
    <title>@yield('page_title','پنل اساتید')</title>
    <link rel="stylesheet" href="{{ asset('css/bundle/admin.css') }}">
    @yield('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="fa fa-power-off"></span> </a>
                <form action="{{ route('auth.teacher.logout') }}" method="POST" id="logout-form">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
@include('layouts.teacher.partial.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container">
            @include('layouts.admin.partial.alert')
        </div>

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h5 class="m-0 text-dark">
                            @yield('title', '')
                        </h5>
                    </div><!-- /.col -->
                    <!-- breadcrumbs -->
                @include('layouts.teacher.partial.breadcrumbs')
                <!-- /.breadcrumbs -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="container-fluid my-2">
            <div class="row">
                @yield('links_top_on_content')
            </div>
        </div>
        <div class="container-fluid">
            <div class="bg-white rounded shadow-sm p-3">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        {{ config('app.name') }}
    </footer>
</div>
<!-- ./wrapper -->

<div id="mask_loading" class="d-none">
    <span>
        لطفا منتظر بمانید ...
    </span>
</div>

<!-- todo remove jquery , adminLTE have problem -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/bundle/admin.js') }}"></script>
@yield('js')
</body>
</html>
