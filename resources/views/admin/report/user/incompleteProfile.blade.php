@extends('layouts.admin.main')
@section('title','کاربران با پروفایل غیر فعال')
@section('page_title','کاربران با پروفایل غیر فعال')
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

@if( $items->count() )
<p class="small text-muted">نتایج پیدا شده: {{ $items->count() }} عدد </p>
<table class="table table-bordered small">
    <thead>
        <tr>
            <th>شناسه</th>
            <th>نام</th>
            <th>فامیل</th>
            <th>شماره همراه</th>
            <th>پست الکترونیکی</th>
            <th>تاریخ عضویت</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            <td scope="row">{{ $item->id }}</td>
            <td>{{ $item->first_name }}</td>
            <td>{{ $item->last_name }}</td>
            <td>{{ $item->mobile }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->jalali_created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
هیچ داده‌ای پیدا نشد.
@endif
@endsection