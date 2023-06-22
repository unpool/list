@extends('layouts.admin.main')
@section('title','گردونه شانس')
@section('page_title','گردونه ها')
@section('content')
@if(isset($wheels) and $wheels->count())
<table class="table table-bordered text-center small">
    <thead>
        <tr>
            <th>#</th>
            <th>سازنده</th>
            <th>نام</th>
            <th>امتیاز</th>
            <th>بیشتر</th>
        </tr>
    </thead>
    <tbody>
        @foreach($wheels as $key => $item)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $item->admin->first_name . ' ' . $item->admin->last_name }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->score }}</td>
            <td>
                <a href="{{ route('admin.chance.wheel.edit', ['wheel' => $item->id]) }}">ویرایش</a>
                <form action="{{ route('admin.chance.wheel.destroy', ['wheel' => $item->id]) }}" method="post">
                    @csrf
                    <button class="btn btn-danger">حذف</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="mb-0">متاسفانه هیچ داده‌ای پیدا نشد.</div>
@endif
@endsection
