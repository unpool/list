@extends('layouts.admin.main')
@section('title','کاربرانی که پروفایل ناقص دارن')
@section('page_title','کاربرانی که پروفایل ناقص دارن')
@section('content')
@if( $items )
<p class="small text-muted">نتایج پیدا شده: {{ $items->count() }} عدد </p>
<table class="table table-bordered small custom_datatable">
    <thead>
        <tr>
            <th>شناسه</th>
            <th>نام</th>
            <th>فامیل</th>
            <th>شماره همراه</th>
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
            <td>{{ $item->jalali_created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
هیچ داده‌ای پیدا نشد.
@endif
@endsection

@section('js')
    @if(isset($items))
        @include('layouts.admin.partial.sendnotification', ['usersReceiverID' => $items->pluck('id')->toArray()])
    @endif
    @include('layouts.admin.partial.datatable')
@endsection
