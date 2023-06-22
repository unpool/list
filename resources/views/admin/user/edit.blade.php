@extends('layouts.admin.main')
@section('title','ویرایش اطلاعات کاربر')
@section('page_title','ویرایش اطلاعات کاربر')
@section('links_top_on_content')
<div class="col-12 text-left">
    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm">لیست کاربران</a>
    <!-- <a href="{{ route('admin.user.show', ['id' => $user->id]) }}" class="btn btn-info btn-sm">نمایش
        اطلاعات</a> -->
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
<form action="{{ route('admin.user.update', ['user' => $user->id]) }}" method="POST">
    @csrf
    @method("PUT")
    <fieldset class="border p-2 px-4 mt-4 border-info rounded">
        <legend class="w-auto h6 px-2">مشخصات فردی</legend>
        <div class="form-row mb-2">
            <div class="form-group col-sm-4">
                <div class="form-group">
                    <label for="first_name">نام</label>
                    <input type="text" name="first_name" id="first_name" class="form-control"
                        value="{{ $user->first_name }}">
                </div>
            </div>
            <div class="form-group col-sm-4">
                <div class="form-group">
                    <label for="last_name">نام‌خانوادگی</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{ $user->last_name }}">
                </div>
            </div>
            <div class="form-group col-sm-4">
                <div class="form-group">
                    <label for="email">پست الکترونیکی</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                </div>
            </div>
            <div class="form-group col-sm-4">
                <div class="form-group">
                    <label for="birth_date">تاریخ تولد</label>
                    <input type="text" name="birth_date" id="birth_date"
                        class="form-control persian-date-picker--just-date" value="{{ $user->birth_date }}">
                </div>
            </div>
            <div class="form-group col-sm-4">
                <div class="form-group">
                    <label for="mobile">موبایل
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="mobile" id="mobile" class="form-control" value="{{ $user->mobile }}">
                </div>
            </div>
            <div class="form-group col-sm-4">
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
        <div class="form-row mb-2">
            <div class="form-group col-sm-4">
                <label>تاریخ عضویت</label>
                <input class="form-control" value="{{ $user->jalaliCreatedAt }}" readonly disabled>
            </div>
            <div class="form-group col-sm-4">
                <label>کد معرف</label>
                <input class="form-control" value="{{ $user->invite_code }}" readonly disabled>
            </div>

            @if($user->invitedFromUser())
            <div class="form-group col-sm-4">
                <label for="score">معرفی شده توسط</label>
                <input type="text" class="form-control" value="{{ $user->invitedFromUser()->full_name }}" readonly disabled>
            </div>
            @else
            @endif

            <div class="form-group col-sm-4">
                <label for="score">امتیاز
                    <span class="text-danger">*</span>
                </label>
                <input type="number" name="score" id="score" class="form-control" value="{{ $user->score }}">
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="share">سهم معرف</label>
                    <input type="number" name="share" id="share" class="form-control" readonly disabled
                        value="{{ $user->share }}">
                </div>

            </div>
            @if($user->share)
            <div class="col-sm-4">
                <label for="score">سهم معرف را </label>
                <select name="shareAction" id="shareAction" class="form-control">
                    <option value="">--انتخاب کنید--</option>
                    <option value="moveShareToWallet">به کیف پول انتقال بده</option>
                    <option value="moveShareToCart">به کارت انتقال بده </option>
                </select>
            </div>
            @endif

            @if(\App\User::find($user->id)->invitedBy->count() <= 0)
            <div class="col-sm-4">
                <label for="invite">معرف </label>
                <select name="inviteBy" id="invite" class="form-control">
                    <option value="">--انتخاب کنید--</option>
                    @foreach ($users as $item)
                    <option value="{{ $item->id }}">{{ $item->first_name . ' ' . $item->last_name }}</option>
                    @endforeach
                </select>
            </div>
            @else
                <div class="form-group col-sm-4">
                    <label> معرف</label>
                    <input class="form-control" value="{{ \App\User::find($user->id)->invitedBy->first()->id }}" readonly disabled>
                </div>

                <div class="col-sm-4">
                    <label for="invite">تغیر معرف </label>
                    <select name="inviteBy" id="invite" class="form-control">
                        <option value="">--انتخاب کنید--</option>
                        @foreach ($users as $item)
                            <option value="{{ $item->id }}">{{ $item->first_name . ' ' . $item->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
    </fieldset>

    <fieldset class="border p-2 px-4 mt-4 border-info rounded">
        <legend class="w-auto h6 px-2">اطلاعات مکانی</legend>
        <div class="form-row mb-2">
            <div class="form-group col-sm-6">
                <label for="province">استان</label>
                <input class="form-control" name="province" value="{{ $user->province }}">
            </div>
            <div class="form-group col-sm-6">
                <label for="city">شهر</label>
                <input class="form-control" name="city" value="{{ $user->city }}">
            </div>
            <div class="form-group col-sm-12">
                <label for="address">آدرس</label>
                <textarea name="address" class="form-control" id="address" cols="30"
                    rows="5">{{  $user->address }}</textarea>
            </div>
        </div>
    </fieldset>

    <fieldset class="border p-2 px-4 mt-4 border-info rounded">
        <legend class="w-auto h6 px-2">اطلاعات کیف پول</legend>
        <div class="form-row mb-2">
            <div class="col-sm-4">
                <label>موجودی کیف پول
                    <span class="text-danger">*</span>
                </label>
                <input type="number" name="wallet" class="form-control" value="{{ $user->wallet }}"
                    aria-describedby="walletHelp">
                <small id="walletHelp" class="text-muted">مبلغ به تومان است.</small>
            </div>
        </div>
    </fieldset>

    <div class="mt-4">
        <button class="btn btn-primary btn-sm">ویرایش</button>
    </div>
</form>

<table class="table table-bordered small mt-4">
    <caption>کدهای IMIE ثبت شده برای کاربر</caption>
    <thead>
        <tr>
            <th>شناسه</th>
            <th>کد IMIE</th>
            <th>تاریخ ثبت</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userIMIEs as $imie)
        <tr>
            <td scope="row">{{ $imie->id }}</td>
            <td>{{ $imie->imie }}</td>
            <td>{{ $imie->jalali_created_at }}</td>
            <td>
                <form action="{{ route('admin.userIMIE.delete', ['id' => $imie->id]) }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<form action="{{ route('admin.user.bankAccount.store', ['user' => $user ]) }}" method="POST"
    class="my-5 border-top pt-3">
    @csrf
    <div class="row form-group">
        <div class="col-12 col-sm-4">
            <label for="bank_account">ثبت شماره کارت</label>
            <input class="form-control" id="bank_account" name="bank_account" placeholder="شماره کارت را وارد نمایید">
        </div>
        <div class="col-12 col-sm-4">
            <label for="first_name">نام</label>
            <input class="form-control" id="first_name" name="first_name" placeholder="نام صاحب حساب">
        </div>
        <div class="col-12 col-sm-4">
            <label for="last_name">نام خانوادگی</label>
            <input class="form-control" id="last_name" name="last_name" placeholder="نام خانوادگی صاحب حساب">
        </div>
    </div>
    <button class="btn btn-primary btn-sm">ارسال</button>
</form>

@if($user->accountsBanks->count())
<!-- Bank Account -->
<table class="table table-bordered text-center small">
    <caption>حساب‌های بانکی کاربر</caption>
    <thead>
        <tr>
            <th>#</th>
            <th>نام نام خانوادگی</th>
            <th>شماره بانک</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($user->accountsBanks as $account)
        <tr>
            <td style="width: 5%;">{{ $account->id }}#</td>
            <td>{{ $account->fullName() }}</td>
            <td>{{ bankAccountFormat($account->account_number) }}</td>
            <td class="text-center">
                <form class="text-center" method="POST"
                    action="{{ route('admin.user.bankAccount.destroy', [ 'user' => $user->id, 'id' => $account->id ]) }}">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-sm btn-danger fa fa-trash"></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
