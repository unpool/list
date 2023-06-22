@extends('layouts.admin.main')
@section('title','لیست کانال ها')
@section('page_title','لیست کانال ها')
@section('content')
@if(isset($channels) and $channels->count())


<table class="table table-bordered text-center small">
    <thead>
        <tr>
            <th>#</th>
            <th>عکس</th>
            <th>عنوان</th>
            <th>توضیحات</th>
            <th>کاربر ادمین</th>
            <th>نوع</th>
            <th>بیشتر</th>
        </tr>
    </thead>
    <tbody>
        @foreach($channels as $key => $channel)
        <tr>
            <td>{{ ++$key }}</td>
            <td>
                @if($channel->address_photo != null)
                    <img class="img-thumbnail img-size-64" src="{{ url('storage/'.$channel->address_photo) }}" alt="{{ $channel->title }}"></td>
                @else
                    <p>عکس ندارد</p>
                @endif

            <td>{{ $channel->title }}</td>
            <td>{{ $channel->description }}</td>
            <td>{{ $channel->admin->first_name . ' ' . $channel->admin->last_name }}</td>
            <td>{{ $channel->type }}</td>
            <td><a href="{{ route('admin.channel.show', $channel->id) }}" class="btn btn-info">نمایش کانال</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="mb-0">متاسفانه هیچ داده‌ای پیدا نشد.</div>
@endif
@endsection
