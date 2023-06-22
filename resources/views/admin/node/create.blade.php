@extends('layouts.admin.main')
@section('title','ایجاد دسته')
@section('page_title','ایجاد دسته')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="m-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ route('admin.node.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-4">
            <label>انتخاب دسته
                <span class="small text-muted"> ( برای ثبت به عنوان دسته‌ی ریشه، هیچ دسته‌ای را انتخاب نکنید. )</span>
            </label>
            <ul class="p-3 border rounded">
                @foreach ($root_nodes as $node)
                <li class="list-unstyled">
                    <input type="radio" value="{{ $node->id }}" name="category" />
                    <label>{{ $node->title }}</label>
                </li>
                <ul class="d-block">
                    @foreach ($node->childrenNodes as $childNode)
                    @include('admin.product.partial.select_node', ['childNode' => $childNode])
                    @endforeach
                </ul>
                @endforeach
            </ul>
        </div>
        <div class=" col-12 col-sm-8">
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="title">نام</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="price">قیمت(تومان)</label>
                    <input type="text" name="price" id="price" value="{{ old('price') }}" class="form-control">
                </div>

                <div class="form-group col-12 col-sm-6">
                    <label for="price_coin">سهم معرف (تومان)</label>
                    <input type="text" name="price_coin" id="price_coin" value="{{ old('price_coin') }}"
                        class="form-control" placeholder="میزان سهم معرف را وارد نمایید.">
                </div>

                <!-- flash Price -->
                <div class="form-group col-12 col-sm-6">
                    <label for="flash_price">قیمت فلش</label>
                    <input type="text" name="flash_price" id="flash_price" class="form-control"
                        value="{{ old('flash_price') }}" placeholder="قیمت برای ارسال به صورت فلش">
                </div>

                <!-- dvd Price -->
                <div class="form-group col-12 col-sm-6">
                    <label for="dvd_price">قیمت دی‌وی‌دی</label>
                    <input type="text" name="dvd_price" id="dvd_price" value="{{ old('dvd_price') }}"
                        class="form-control" placeholder="قیمت برای ارسال به صورت دی‌وی‌دی">
                </div>

                <!-- Score -->
                <div class="form-group col-12 col-sm-6">
                    <label for="score">امتیاز</label>
                    <input type="number" name="score" id="score" class="form-control" value="{{ old('score') }}"
                        placeholder="امتیاز را وارد کنید.">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea class="form-control" name="description" id="description"
                    rows="5">{{ old('description') }}</textarea>
            </div>
        </div>
    </div>
    <fieldset class="border p-2 px-4 mt-4 border-info rounded">
        <legend class="w-auto h6 px-2">تصاویر دسته</legend>
        <div class="form-row">
            <div class="form-group col-4">
                <label for="image">تصویر شاخص</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="form-group col-4">
                <label for="icon">تصویر ایکون</label>
                <input type="file" name="icon" id="icon" class="form-control">
            </div>
            <div class="form-group col-4">
                <label for="background">تصویر پس زمینه</label>
                <input type="file" name="background" id="background" class="form-control">
            </div>
        </div>
    </fieldset>
    <div class="col-12 mt-2">
        <button class="btn btn-primary">ارسال</button>
    </div>
</form>
@endsection