@extends('layouts.admin.main')
@section('title','لیست رادیو ها')
@section('page_title','لیست رادیو ها')
@section('links_top_on_content')
<div class="col-12">
    <div class="mb-2 float-left">
        <a href="{{ route('admin.user_comment.create') }}" class="btn btn-primary btn-sm">ثبت پکیج جدید</a>
    </div>
</div>
@endsection
@section('content')
@if(isset($comments) and $comments->count())
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
        @foreach ($comments as $comment)
        <tr>
            <td scope="row">{{ $comment->id }}</td>
            <td>{{ $comment->title }}</td>
            <td>{{ $comment->body}}</td>
            <td>{{ $comment->file_type}}</td>
            <td>
                <a src="/storage/{{$comment->file}}" class="btn btn-info">دانلود فایل</a>
            </td>
            <td>
                <a href="{{ route('admin.user_comment.edit',['id' => $comment->id]) }}" class="btn btn-primary btn-sm">
                    <span class="fa fa-pencil"></span>
                </a>
                <form method="POST" action="{{ route('admin.user_comment.delete', ['id' => $comment->id]) }}"
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

@else
<div class="mb-0">
    <span class="fa fa-exclamation-triangle"></span>
    متاسفانه هیچ داده‌ای پیدا نشد.
</div>
@endif

@endsection
