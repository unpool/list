@extends('layouts.admin.main')
@section('title','ثبت کاربر')
@section('page_title','ثبت کاربر')
@section('links_top_on_content')
<div class="col-12 text-left">
    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm">لیست کاربران</a>
</div>
@endsection
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

<span class="text-danger">فیلد‌های اجباری با علامت * مشخص شده‌اند.</span>
<form action="{{ route('admin.user.store') }}" method="POST">
    @csrf
    <fieldset class="border p-2 px-4 border-info rounded">
        <legend class="w-auto h6 px-2">اطلاعات فردی</legend>
        <div class="form-row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="first_name">نام</label>
                    <input type="text" name="first_name" id="first_name" class="form-control"
                        value="{{ old('first_name') }}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="last_name">نام‌خانوادگی</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{ old('last_name') }}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="email">پست الکترونیکی</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="birth_date">تاریخ تولد</label>
                    <input type="text" name="birth_date" id="birth_date"
                        class="form-control persian-date-picker--just-date" value="{{ old('birth_date') }}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="mobile">موبایل
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile') }}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="password">گذرواژه
                        <span class="text-danger">*</span>
                    </label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="border p-2 px-4 mt-4 border-info rounded">
        <legend class="w-auto h6 px-2">اطلاعات تکمیلی</legend>
        <div class="form-row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="score">امتیاز
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="score" id="score" class="form-control" value="{{ old('score') }}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-group">
                        <label for="inviteBy">معرفی شده توسط</label>
                        <select class="form-control" name="inviteBy" id="inviteBy">
                            <option value="">بدون معرف</option>
                            @foreach($usersCanBeInviteAnother as $user)
                            <option value="{{ $user->id }}">{{ $user->fullName() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="share">سهم معرف</label>
                    <input type="number" name="share" id="share" class="form-control">
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="border p-2 px-4 mt-4 border-info rounded">
        <legend class="w-auto h6 px-2">اطلاعات مکانی</legend>
        <div class="form-row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="province">استان</label>
                    <input type="text" name="province" id="province" class="form-control" value="{{ old('province') }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="city">شهر</label>
                    <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="address">آدرس</label>
                    <textarea name="address" id="address" cols="30" rows="5"
                        class="form-control">{{ old('address') }}</textarea>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="form-group">
        <button class="btn btn-primary btn-sm mt-3">ثبت</button>
    </div>
</form>
@endsection