@extends('layouts.admin.main')
@section('title','ثبت جزییات برای دسته')
@section('page_title','ثبت جزییات برای دسته')
@section('links_top_on_content')

@endsection

@section('content')
<p>
    ثبت اطلاعات برای دسته‌ی: {!! join('<span class="fa fa-angle-left mx-2 text-success"></span>',$node_breadcrumbs) !!}
</p>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="m-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ route('admin.node.update', ['node' => $node->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <fieldset class="border p-2 px-4 mt-4 border-info rounded">
        <legend class="w-auto h6 px-2">جزییات دسته</legend>
        <div class="form-row">
            <div class="form-group col-4">
                <label for="title">نام</label>
                <input type="text" name="title" id="title" value="{{ $node->title }}" class="form-control">
            </div>
            <div class="form-group col-4">
                <label for="price_holder">قیمت(تومان)</label>
                <input type="text" name="price" id="price_holder" value="{{ $prices['cash'] ?? '' }}"
                    class="form-control">
            </div>

            <div class="form-group col-4">
                <label for="price_coin">سهم معرف (تومان)</label>
                <input type="text" name="price_coin" id="price_coin" value="{{ $prices['coin'] ?? '' }}"
                    class="form-control" placeholder="میزان سهم معرف را وارد نمایید.">
            </div>

            <!-- flash Price -->
            <div class="form-group col-4">
                <label for="flash_price">قیمت فلش</label>
                <input type="text" name="flash_price" id="flash_price" class="form-control"
                    value="{{ $prices['flash'] ?? '' }}" placeholder="قیمت برای ارسال به صورت فلش">
            </div>

            <!-- dvd Price -->
            <div class="form-group col-4">
                <label for="dvd_price">قیمت دی‌وی‌دی</label>
                <input type="text" name="dvd_price" id="dvd_price" value="{{ $prices['dvd'] ?? '' }}"
                    class="form-control" placeholder="قیمت برای ارسال به صورت دی‌وی‌دی">
            </div>

            <!-- Score -->
            <div class="form-group col-4">
                <label for="score">امتیاز</label>
                <input type="number" name="score" id="score" class="form-control" value="{{ $node->score }}"
                    placeholder="امتیاز را وارد کنید.">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea class="form-control" name="description" id="description"
                    rows="5">{{ $node->description }}</textarea>
            </div>
        </div>
    </fieldset>
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

@if( count($media) )
<table class="mt-3 table table-bordered small">
    <thead>
        <tr>
            <th>تصویر</th>
            <th>نوع</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($media['index']))
        <tr>
            <td>
                <img src="{{ asset($media['index']) }}" style="width:100px;">
            </td>
            <td>شاخص</td>
        </tr>
        @endif
        @if(isset($media['icon']))
        <tr>
            <td>
                <img src="{{ asset($media['icon']) }}" style="width:100px;">
            </td>
            <td>ایکون</td>
        </tr>
        @endif
        @if(isset($media['background']))
        <tr>
            <td>
                <img src="{{ asset($media['background']) }}" style="width:100px;">
            </td>
            <td>بک گراند</td>
        </tr>
        @endif
    </tbody>
</table>
@endif
@endsection