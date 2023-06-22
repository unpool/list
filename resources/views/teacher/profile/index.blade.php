@extends('layouts.teacher.main')
@section('title','نمایش پروفایل')
@section('page_title','نمایش پروفایل')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12">
                    <section class="text-bold float-right">نمایش اطلاعات پروفایل</section>
                    <a href="{{ route('teacher.profile.edit') }}" class="float-left">
                        <button class="btn btn-primary fa fa-edit"></button>
                    </a>
                    <div class="clearfix"></div>
                    <section class="text-muted small">اطلاعاتی که در سایت توسط کاربران مشاهده خواهد شد.</section>
                </div>
            </div>
        </div>

        <div class="col-12 my-2">
            <div class="col-12">
                <div class="row">
                    <div class="col-6 col-sm-1">
                        <div class="col-12 border py-2 rounded">
                            <small class="text-muted">شناسه</small>
                            <section>{{ login_teacher()->id }}#</section>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3 my-1">
                        <div class="col-12 border py-2 rounded">
                            <small class="text-muted">نام</small>
                            <section>{{ login_teacher()->first_name }}</section>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 my-1">
                        <div class="col-12 border py-2 rounded">
                            <small class="text-muted">نام خانوادگی</small>
                            <section>{{ login_teacher()->last_name }}</section>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 my-1">
                        <div class="col-12 border py-2 rounded">
                            <small class="text-muted">پست الکترونیکی</small>
                            <section>{{ login_teacher()->email }}</section>
                        </div>
                    </div>
                    <div class="col-12 my-1">
                        <div class="col-12 border float-left py-2 rounded position-relative cv">
                            <small class="text-muted">رزومه</small>
                            @if(login_teacher() and isset(login_teacher()->cv) and isset(login_teacher()->cv->cv))
{!! login_teacher()->cv->cv !!}
                            @else
                                <span class="fa fa-window-close text-danger position-absolute left"
                                      style="left: -5px;top: -5px;"></span>
                                <section>
                                    هیچ رزومه‌ای ثبت نشده است.
                                </section>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
