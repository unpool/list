@extends('layouts.admin.main')
@section('title','کاربران با کسب درآمد')
@section('page_title','کاربران با کسب درآمد')
@section('content')
@if(isset($items))
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
