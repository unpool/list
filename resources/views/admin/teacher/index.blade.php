@extends('layouts.admin.main')
@section('title','لیست مربیان')
@section('page_title','لیست مربیان')
@section('links_top_on_content')
<div class="col-12">
    <div class="pull-left">
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary btn-sm">ثبت استاد جدید</a>
        <a href="{{ route('admin.teachers.group.index') }}" class="btn btn-info btn-sm">گروه بندی اساتید</a>
    </div>
</div>
@endsection
@section('content')
@if(isset($items) and $items->count())
<section class="mb-3 small text-muted">
    <span class="fa fa-exclamation-triangle text-danger"></span>
    نشان دهنده اساتیدی است که رزومه ثبت نکرده اند.
</section>
<table class="table table-bordered text-center small">
    <thead>
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>نام خانوادگی</th>
            <th>پست الکترونیکی</th>
            <th>سطوح دسترسی</th>
            <th>بیشتر</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>
                @if( !$item->cv )
                <span class="fa fa-exclamation-triangle text-danger"></span>
                @endif
                {{ $item->id }}
            </td>
            <td>{{ $item->first_name }}</td>
            <td>{{ $item->last_name }}</td>
            <td>{{ $item->email }}</td>
            <td>
                @if($item->permissions->count())
                {!! join(' - ',$item->permissions->pluck('name')->toArray()) !!}
                @else
                <span class="text-danger">بدون دسترسی</span>
                @endif
            </td>
            <td>
                <a class="btn btn-warning btn-sm" href="{{ route('admin.teachers.edit', ['id' => $item->id]) }}">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
                <a href="{{ route('admin.teachers.cv.edit', [ 'id' => $item->id ]) }}" class="btn btn-sm btn-info">
                    رزومه </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $items->render() }}
@else
<div class="mb-0">متاسفانه هیچ داده‌ای پیدا نشد.</div>
@endif
@endsection