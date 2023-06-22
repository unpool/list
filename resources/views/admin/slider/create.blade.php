@extends('layouts.admin.main')
@section('title','ایجاد اسلایدر')
@section('page_title','ایجاد اسلایدر')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <div class="col-12">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
<form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12 col-sm-4">
            <label>انتخاب دسته</label>
            <ul class="p-3 border rounded">
                @foreach ($root_nodes as $node)
                <li class="list-unstyled">
                    <input type="radio" value="{{ $node->id }}" name="category" />
                    <label>{{ $node->title }}</label>
                </li>
                <ul class="d-block">
                    @foreach ($node->childrenNodes as $childNode)
                    @include('admin.node.partial.subNodeRadioButton', ['childNode' => $childNode])
                    @endforeach
                </ul>
                @endforeach
            </ul>
        </div>
        <div class="col-12 col-sm-4">
            <div class="form-group">
                <label for="title">عنوان
                    <span class="text-danger">*</span>
                </label>
                <input type="text" id="title" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="file">فایل را انتخاب کنید <span class="text-danger">*</span></label>
                <input type="file" id="file" name="file" class="form-control">
            </div>
            <div class="form-group">
                <label for="file">عکس را انتخاب کنید <span class="text-danger">*</span></label>
                <input type="file" id="image" name="image" class="form-control">
            </div>

            <div class="form-group">
                <label for="url">لینک <span class="text-danger">*</span> </label>
                <input type="url" id="url" name="url" class="form-control">
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <label for="description">توضیحات <span class="text-danger">*</span> </label>
            <textarea name="description" id="description" cols="30" rows="9" class="form-control"></textarea>
        </div>
    </div>
    <button class="btn btn-primary">ارسال</button>
</form>
@endsection
