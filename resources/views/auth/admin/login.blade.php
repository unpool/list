@extends('layouts.auth.main')
@section('page_title','فرم ورود مدیریت')
@section('content')
    <div class="container mt-3 text-center">
        <h4 class="mb-3">فرم ورود مدیریت</h4>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container bg-white px-5 py-4 shadow rounded">
        <form class="form-signin text-right" action="{{ route('auth.admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="inputEmail">پست الکترونیکی</label>
                <input type="email" id="inputEmail" class="form-control" name="email" value="{{ old('email') }}" placeholder="پست الکترونیکی"
                       required
                       autofocus>
            </div>
            <div class="form-group">
                <label for="inputPassword">گذرواژه</label>
                <input type="password" id="inputPassword" class="form-control" name="password" placeholder="گذرواژه"
                       required>
            </div>
            <div class="form-group checkbox mb-3">
                <label>
                    <input type="checkbox" name="remember" value="remember-me">مرا به خاطر بسپار
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">ارسال</button>
        </form>
    </div>
    <div class="container text-center">
        <p class="my-2 text-muted">&copy; {{ join('-', array_unique([2019,(int)date('Y')])) }}</p>
    </div>
@endsection
