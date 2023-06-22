@extends('layouts.admin.main')
@section('title','ویرایش اسلایدر')
@section('page_title','ویرایش اسلایدر')
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
<form action="{{ route('admin.slider.update',['slider' => $slider->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
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
                    @include('admin.node.partial.subNodeRadioButton', ['childNode' => $childNode, 'mustBeCheck' =>
                    $category->id])
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
                <input type="text" id="title" name="title" class="form-control" value="{{ $slider->title }}">
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
                <input type="url" id="url" name="url" class="form-control" value="{{ $slider->link }}">
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <label for="description">توضیحات <span class="text-danger">*</span> </label>
            <textarea name="description" id="description" cols="30" rows="9"
                class="form-control">{{ $slider->description }}</textarea>
        </div>
    </div>
    <button class="btn btn-primary">ارسال</button>
</form>
@endsection
