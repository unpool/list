@extends('layouts.admin.main')
@section('title','نمایش کاربران')
@section('page_title','نمایش کاربران')
@section('content')
    @if( $users->count() )
        <span class="small text-muted">افرادی که تعداد
            {{ $count_of_introduced }}
            کاربر را
            از تاریخ
            {{ $from_date }}
            تا تاریخ
            {{ $to_date }}
            معرفی کرده اند.
        </span>
        <table class="table table-bordered text-center small">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">نام</th>
                <th scope="col">نام‌خانوادگی</th>
                <th scope="col">تاریخ عضویت</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $item)
                <tr>
                    <th>{{ $item->id }}</th>
                    <td>{{ $item->first_name }}</td>
                    <td>{{ $item->last_name }}</td>
                    <td>{{ GtoJ($item->created_at) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>
            هیچ داده‌ای پیدا نشد.
        </p>
    @endif
@endsection