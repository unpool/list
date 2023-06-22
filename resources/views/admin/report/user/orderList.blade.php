@extends('layouts.admin.main')
@section('title','لیست سفارشات')
@section('page_title','لیست سفارشات')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <div class="col-12">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<form method="POST" action="{{ route('admin.report.user.orderList') }}">
    <div class="form-group">
        <label for="user">انتخاب کاربر</label>
        <select class="form-control col-12 col-sm-3" name="user">
            @foreach ($users as $item)
            <option @if(isset($user) and $user->id == $item->id) selected @endif
                value="{{ $item->id }}">{{ $item->id }}# -
                {{ $item->fullName() }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-sm btn-primary">ارسال</button>
</form>

@if(isset($items))
@if($items->count())
<table class="table table-bordered small custom_datatable ">
    <caption>لیست سفارشات
        <span class="font-weight-bold">{{ $user->fullName() }} </span>
    </caption>
    <thead>
        <tr>
            <th>شناسه</th>
            <th>مبلغ</th>
            <th>وضعیت پرداخت</th>
            <th>شیوه‌ی ارسال</th>
            <th>نوع خرید</th>
            <th>مبلغ تخفیف</th>
            <th>تاریخ ایجاد</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            <td scope="row">{{ $item->id }}</td>
            <td>{{ number_format($item->price) }} تومان</td>
            <td>{{ $item->paid_status }}</td>
            <td>{{ $item->send_type }}</td>
            <td>{{ $item->type }}</td>
            <td>{{ number_format($item->discount_price) }} تومان</td>
            <td>{{ $item->jalali_created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $items->render() }}
@else
<div class="my-3">
    هیچ نتیجه‌ای یافت نشد.
</div>
@endif
@endif
@endsection

@section('js')
    @if(isset($items))
        @include('layouts.admin.partial.sendnotification', ['usersReceiverID' => $items->pluck('id')->toArray()])
    @endif
    @include('layouts.admin.partial.datatable')
@endsection
