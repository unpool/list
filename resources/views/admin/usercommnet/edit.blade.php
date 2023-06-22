@extends('layouts.admin.main')
@section('title','ثبت رادیو')
@section('page_title','ثبت رادیو')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route("admin.user_comment.update" , ['id' => $comment->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">


        <div class="col-12 col-sm-4">
            <div class="form-group">
                <label for="title" >عنوان</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="عنوان "
                    aria-describedby="helpId" value="{{ $comment->title}}">
            </div>

            <!-- Coin Price -->
            <div class="form-group">
                <label for="body">توضیحات</label>
                <input type="text" name="body" id="body" class="form-control"
                    placeholder="توضیحات را وارد کنید" value="{{ $comment->body}}">
            </div>

            <!-- flash Price -->
            <div class="form-group">
                <label for="file">فایل</label>
                <input type="file" name="file" class="form-control">
            </div>



        <button class="btn btn-primary">ارسال</button>
    </div>
</form>
@endsection
