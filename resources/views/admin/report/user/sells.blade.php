@extends('layouts.admin.main')
@section('title','میزان فروش')
@section('page_title','میزان فروش')
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

<form class="form-inline" method="POST">
    @csrf
    <label for="start">از تاریخ</label>
    <input type="text" name="start" @if(isset($start_unix_time)) default-value="{{ $start_unix_time }}" @endif
        class="form-control persian-date-picker--just-date mb-2 mx-2 mr-sm-2" id="start">

    <label for="end">تا تاریخ</label>
    <div class="input-group mb-2 mr-sm-2">
        <input type="text" name="end" @if(isset($end_unix_time)) default-value="{{ $end_unix_time }}" @endif
            class="form-control persian-date-picker--just-date" id="end">
    </div>
    <button type="submit" class="btn btn-primary mb-2 mx-2">
        <span class="fa fa-filter"></span>
        فیلتر
    </button>
</form>
@if(isset($orders))
<hr>

<p class="small text-muted">نتایج پیدا شده: {{ $orders->count() }} عدد </p>
<table class="table table-bordered small">
    <thead>
        <tr>
            <th>شناسه</th>
            <th>نام</th>
            <th>فامیل</th>
            <th>مبلغ</th>
            <th>نوع</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $item)
        <tr>
            <td scope="row">{{ $item->id }}</td>
            <td>{{ $item->user->first_name }}</td>
            <td>{{ $item->user->last_name }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->send_type }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@else
<div class="my-3">
    هیچ نتیجه‌ای یافت نشد.
</div>
@endif
@endsection