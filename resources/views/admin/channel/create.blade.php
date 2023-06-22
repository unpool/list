@extends('layouts.admin.main')
@section('title','ثبت کانال')
@section('page_title','ثبت کانال')
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
<form action="{{ route("admin.channel.store") }}" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="form-group">
                <label for="price"> عنوان کانال</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="عنوان کانال را وارد کنید . . ."
                    aria-describedby="helpId" value="{{ old('title') }}">
            </div>

            <div class="form-group">
                <label for="price">عکس کانال</label>
                <input type="file" name="photo" id="photo" class="form-control" placeholder="عنوان کانال را وارد کنید . . ."
                       aria-describedby="helpId" value="{{ old('photo') }}">
            </div>

            <div class="form-group">
                <label for="group">نوع</label>
                <select name="type" id="type" class="form-control" aria-describedby="typeId">
                    <option value="public">عمومی</option>
                    <option value="private">خصوصی</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea name="description" id="description" class="form-control" rows="10" placeholder="توضیحات کانال"
                          aria-describedby="descriptionHelpInput">{{ old('description') }}</textarea>
            </div>

        <button class="btn btn-primary">افزودن کانال</button>
        </div>
    </div>
</form>
@endsection
