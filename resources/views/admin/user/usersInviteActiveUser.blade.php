@extends('layouts.admin.main')
@section('title','نمایش کاربران')
@section('page_title','نمایش کاربران')
@section('content')
    <table class="table table-bordered text-center small">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">نام و نام‌خانوادگی</th>
            <th scope="col">تعداد کاربران معرفی شده</th>
            <th scope="col">کاربران معرفی شده</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $item)
            <tr>
                <th>{{ $item->id }}</th>
                <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                <td>{{ $item->invites->count() }}</td>
                <td>
                    @foreach( $item->invites as $item )
                         {{ $item->user->first_name }} {{ $item->user->last_name }} #{{ $item->user->id }}
                        <br>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection