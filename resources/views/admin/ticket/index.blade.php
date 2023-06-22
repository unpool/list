@extends('layouts.admin.main')
@section('title','لیست تیکت ها')
@section('page_title','لیست تیکت ها')
@section('content')
@if(isset($tickets) and $tickets->count())
<table class="table table-bordered text-center small">
    <thead>
        <tr>
            <th>#</th>
            <th>کاربر</th>
            <th>محصول/پکیج</th>
            <th>عنوان سوال</th>
            <th>سوال</th>
            <th>پاسخ</th>
            <th>پاسخ دهنده</th>
            <th>بیشتر</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $key => $item)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $item->user->first_name . ' ' . $item->user->last_name }}</td>
            <td>{{ $item->node->title }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->question }}</td>
            <td>{{ $item->answer ?? 'هیچ پاسخ ندارد!' }}</td>
            @if (!is_null($item->admin ))
                <td>{{ $item->admin->first_name . ' ' . $item->admin->last_name }}</td>
            @else
                <td>هیچ پاسخ دهنده ای ندارد!</td>
            @endif
            <td><a href="{{ route('admin.tickets.answer', ['ticket'=>$item->id]) }}">پاسخ</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="mb-0">متاسفانه هیچ داده‌ای پیدا نشد.</div>
@endif
@endsection