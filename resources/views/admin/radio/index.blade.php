@extends('layouts.admin.main')
@section('title','لیست رادیو ها')
@section('page_title','لیست رادیو ها')
@section('links_top_on_content')
<div class="col-12">
    <div class="mb-2 float-left">
        <a href="{{ route('admin.radio.create') }}" class="btn btn-primary btn-sm">ثبت پکیج جدید</a>
    </div>
</div>
@endsection
@section('content')
@if(isset($radioes) and $radioes->count())
<table class="table table-bordered small text-center">
    <thead>
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>توضیحات</th>
            <th>فایل</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($radioes as $radio)
        <tr>
            <td scope="row">{{ $radio->id }}</td>
            <td>{{ $radio->title }}</td>
            <td>{{ $radio->description}}</td>
            <td>
                <audio controls>
                    <source src="/storage{{$radio->file}}">
                </audio>
            </td>
            <td>
                <a href="{{ route('admin.radio.edit',['id' => $radio->id]) }}" class="btn btn-primary btn-sm">
                    <span class="fa fa-pencil"></span>
                </a>
                <form method="POST" action="{{ route('admin.radio.delete', ['id' => $radio->id]) }}"
                    class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true" title="حذف"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $radioes->links() }}
@else
<div class="mb-0">
    <span class="fa fa-exclamation-triangle"></span>
    متاسفانه هیچ داده‌ای پیدا نشد.
</div>
@endif

@endsection
