@extends('layouts.admin.main')
@section('title','تاریخ تولد کاربران')
@section('page_title','تاریخ تولد کاربران')
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
@if(isset($items))
<hr>

<p class="small text-muted">نتایج پیدا شده: {{ $items->count() }} عدد </p>
<table class="table table-bordered small custom_datatable">
    <thead>
        <tr>
            <th>شناسه</th>
            <th>نام</th>
            <th>فامیل</th>
            <th>تاریخ تولد</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            <td scope="row">{{ $item->id }}</td>
            <td>{{ $item->first_name }}</td>
            <td>{{ $item->last_name }}</td>
            <td>{{ $item->jalali_birthdate }}</td>
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

@section('js')
    @if(isset($items))
        @include('layouts.admin.partial.sendnotification', ['usersReceiverID' => $items->pluck('id')->toArray()])
    @endif
    @include('layouts.admin.partial.datatable')
@endsection
