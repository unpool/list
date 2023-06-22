@extends('layouts.admin.main')
@section('title','لیست پکیج ها')
@section('page_title','لیست پکیج ها')
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

<form method="POST" action="{{ route('admin.report.user.package-sells') }}">
    @csrf
    <div class="form-group">
        <label for="package">انتخاب پکیج</label>
        <select class="form-control col-12 col-sm-3" name="package">
            @foreach ($packages as $item)
            <option value="{{ $item->id }}">{{ $item->id }}# - {{ $item->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="type">انتخاب نوع</label>
        <select class="form-control col-12 col-sm-3" name="type">
            <option value="flash">flash</option>
            <option value="dvd">dvd</option>
        </select>
    </div>

    <button class="btn btn-sm btn-primary">ارسال</button>
</form>

@if(isset($orders))
@if($orders->count())
<table class="table table-bordered small custom_datatable ">
    <caption>لیست سفارشات
    </caption>
    <thead>
        <tr>
            <th>شناسه</th>
            <th>نام</th>
            <th>نام خانوادگی</th>
            <th>مبلغ</th>
            <th>وضعیت پرداخت</th>
            <th>تاریخ ایجاد</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $item)
        <tr>
            <td scope="row">{{ $item->id }}</td>
            <td>{{ $item->order->user->first_name }}</td>
            <td>{{ $item->order->user->last_name }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ (bool) $item->order->is_paid ? 'پرداخت شده' : 'پرداخت نشده' }}</td>
            <td>{{ $item->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
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
