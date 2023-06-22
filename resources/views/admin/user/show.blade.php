@extends('layouts.admin.main')
@section('title','نمایش اطلاعات کاربر')
@section('page_title','نمایش اطلاعات کاربر')
@section('links_top_on_content')
    <div class="col-12 text-left">
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm">لیست کاربران</a>
        <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-primary btn-sm">ویرایش
            اطلاعات</a>
    </div>
@endsection
@section('content')
    <table class="table table-bordered text-center small">
        <caption>مشخصات فردی</caption>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">نام</th>
                <th scope="col">نام خانوادگی</th>
                <th scope="col">پست الکترونیکی</th>
                <th scope="col">همراه</th>
                <th scope="col">وضعیت</th>
                <th scope="col">عضویت در</th>
                <th scope="col">تاریخ تولد</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>{{ $user->id }}</th>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td>
                    @if(!empty($user->first_name) and !empty($user->last_name) and !empty($user->email))
                        <span class="text-success">فعال</span>
                    @else
                        <span class="text-danger">غیرفعال</span>
                    @endif
                </td>
                <td>{{ $user->jalali_created_at }}</td>
                <td>{{ $user->jalali_birth_date }}</td>
            </tr>
        </tbody>
    </table>
    <form action="{{ route('admin.user.admin_notes', $user) }}" method="post">
        @csrf
        <label for="exampleFormControlTextarea1">یادداشت</label>
        <textarea name="note" class="form-control mb-3" rows="3"  id="exampleFormControlTextarea1">{{ $user['admin_notes'] }}</textarea>
        <button type="submit" class="btn btn-info">ارسال</button>
    </form>

    @if($invitedUsers->count())
        <br>
        <hr>
        <br>

        <table class="table table-bordered text-center small">
        <caption>کاربرانی که با کد معرف این کاربر امده اند</caption>
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">نام و نام خانوادگی</th>
            <th scope="col">پست الکترونیکی</th>
            <th scope="col">همراه</th>
            <th scope="col">وضعیت</th>
            <th scope="col">عضویت در</th>
            <th scope="col">تاریخ تولد</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invitedUsers as $invitedUser)
            @if($invitedUser['user'] != null)
                <tr>
            <th>{{ $invitedUser['user']->id }}</th>
            <td>
                <a href="{{ route('admin.user.show_info', $invitedUser['user']) }}">
                    {{ $invitedUser['user']->first_name }} {{ $invitedUser['user']->last_name }}
                </a>
            </td>
            <td>{{ $invitedUser['user']->email }}</td>
            <td>{{ $invitedUser['user']->mobile }}</td>
            <td>
                @if(!empty($invitedUser['user']->first_name) and !empty($invitedUser['user']->last_name) and !empty($invitedUser['user']->email))
                    <span class="text-success">فعال</span>
                @else
                    <span class="text-danger">غیرفعال</span>
                @endif
            </td>
            <td>{{ $invitedUser['user']->jalali_created_at }}</td>
            <td>{{ $invitedUser['user']->jalali_birth_date }}</td>
        </tr>
            @endif
        @endforeach
        </tbody>
    </table>

    @else
    <p>
        <span class="text-danger">
        <span class="mt-3 fa fa-exclamation-triangle"></span>
    هیچ کاربر با کد معرف این کاربر وارد نشده اند</span>
    </p>

    @endif



    @if($orders->count())
        <h6>حساب‌های بانکی کاربر</h6>
        <table class="table table-bordered text-center small">
            <thead>
            <tr>
                <th>#</th>
                <th>عنوان محصول</th>
                <th>قیمت خریداری شده</th>
                <th>وضعیت</th>
                <th>تاریخ</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td style="width: 5%;">{{ $order->id }}#</td>

                    @if(count($order['nodes']) != 0)
                        <td>{{ $order['nodes'][0]['title'] }}</td>
                    @else
                        <td>کالا پاک شده است</td>
                    @endif

                    <td>{{ $order['price'] }}</td>
                    <td>{{ $order->showPaid }}</td>
                    <td>{{ convertEnTimeToPersianTime($order['created_at']) }}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <span class="text-danger">
        <span class="mt-3 fa fa-exclamation-triangle"></span>
    هیچ خریدی انجام نشده است</span>
    @endif

    <!-- Bank Account -->
    @if($user->accountsBanks->count())
    <table class="table table-bordered text-center small">
        <caption>حساب‌های بانکی کاربر</caption>
        <thead>
            <tr>
                <th>#</th>
                <th>نما و نام خانوادگی</th>
                <th>شماره بانک</th>
                <th>ایجاد</th>
            </tr>
        </thead>
        <tbody>
             @foreach($user->accountsBanks as $account)
            <tr>
                <td style="width: 5%;">{{ $account->id }}#</td>
                <td>{{ $account->first_name }} {{ $account->last_name }}</td>
                <td>{{ bankAccountFormat($account->account_number) }}</td>
                <td>{{ $account->jalali_created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <span class="text-danger">
        <span class="mt-3 fa fa-exclamation-triangle"></span>
    هیچ حساب بانکی ثبت نشده است</span>
    @endif
@endsection
