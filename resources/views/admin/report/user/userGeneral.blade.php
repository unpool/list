@extends('layouts.admin.main')
@section('title','گزارش کلی')
@section('page_title','گزارش کلی')
@section('content')
<p>
    تعداد کاربران سیستم‌:
    {{ $countOfUsers }}
</p>
<p>
    تعداد کاربرانی که افراد دیگری را معرفی کرده‌اند:
    {{ $countOfUsersThatInviteOthers }}
</p>

<p>
    تعداد کاربرانی که با کد معرف وارد شده اند:
    {{ $countOfUsersWithIdentifierCode }}
</p>

<p>
    تعداد کاربرانی که بدون کد معرف وارد شده اند:
    {{ $notCountOfUsersWithIdentifierCode }}
</p>

<p>
    تعداد کاربرانی که با کد معرف خرید کرده اند:
    {{ $countOfUsersWithIdentifierCodeOrder }}
</p>

<p>
    تعداد کاربرانی که بدون کد معرف خرید کرده اند:
    {{ $notCountOfUsersWithIdentifierCodeOrder }}
</p>
@endsection
