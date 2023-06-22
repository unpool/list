@extends('layouts.admin.main')
@section('title','ثبت محصول')
@section('page_title','ثبت محصول')
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
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    <strong><i class="fa fa-exclamation-triangle"></i></strong> با انتخاب یک والد، محصول در تمام زیر دسته‌ها نیز به
    نمایش گذاشته
    می‌شود.
</div>
<form action="{{ route("admin.product.store") }}" method="POST">
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
                    @include('admin.product.partial.select_node', ['childNode' => $childNode])
                    @endforeach
                </ul>
                @endforeach
            </ul>
        </div>

        <div class="col-12 col-sm-4">
            <div class="form-group">
                <label for="price">قیمت به تومان</label>
                <input type="text" name="price" id="price" class="form-control" placeholder="قیمت محصول"
                    aria-describedby="helpId" value="{{ old('price') }}">
                <small id="helpId" class="text-muted">قیمت را به تومان وارد نمایید.</small>
            </div>

            <!-- Coin Price -->
            <div class="form-group">
                <label for="price_coin">سهم معرف</label>
                <input type="text" name="price_coin" id="price_coin" class="form-control"
                    placeholder="میزان سهم معرف را وارد نمایید." value="{{ old('price_coin') }}">
            </div>

            <!-- flash Price -->
            <div class="form-group">
                <label for="flash_price">قیمت فلش</label>
                <input type="text" name="flash_price" id="flash_price" class="form-control"
                    placeholder="قیمت محصول برای ارسال به صورت فلش" value="{{ old('flash_price') }}">
            </div>

            <!-- dvd Price -->
            <div class="form-group">
                <label for="dvd_price">قیمت دی‌وی‌دی</label>
                <input type="text" name="dvd_price" id="dvd_price" class="form-control"
                    placeholder="قیمت محصول برای ارسال به صورت دی‌وی‌دی" value="{{ old('dvd_price') }}">
            </div>

            <!-- Score -->
            <div class="form-group">
                <label for="score">امتیاز</label>
                <input type="number" name="score" id="score" class="form-control" placeholder="امتیاز را وارد کنید."
                    value="{{ old('score') }}">
            </div>

            <div class="form-group">
                <label for="title">نام محصول</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
            </div>

            <div class="form-group">
                <label for="group">ثبت برای گروه مربیان</label>
                <select name="group" id="group" class="form-control" aria-describedby="groupId">
                    @foreach ($groups as $item)
                    <option @if( old('group')==$item->id) selected @endif value="{{ $item->id }}">گروه
                        {{ $item->teacher->first_name }}
                        {{ $item->teacher->last_name }}
                    </option>
                    @endforeach
                </select>
                <small id="teacherId" class="text-muted">مربی که میخواهید این محصول برای او ثبت شود را انتخاب
                    کنید.</small>
            </div>
        </div>

        <div class="col-12 col-sm-4">
            <div class="form-group">
                <label for="status">وضعیت</label>
                <select name="status" readonly id="status" class="form-control" aria-describedby="statusHelpInput">
                    {{-- <option value="publish">منتشر شده</option> --}}
                    <option value="disable">غیرفعال</option>
                </select>
                <small id="statusHelpInput" class="text-muted">در قسمت ویرایش، و پس از بارگذاری فایل
                    میتوانید محصول
                    را فعال کنید</small>
            </div>
            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea name="description" id="description" class="form-control" rows="10" placeholder="توضیحات محصول"
                    aria-describedby="descriptionHelpInput">{{ old('description') }}</textarea>
                <small id="descriptionHelpInput" class="text-muted">توضیحات مربوط به محصول که می‌تواند برای بازدید
                    کنندگان
                    جذاب باشد را تایپ کنید</small>
            </div>
        </div>

        <button class="btn btn-primary">ارسال</button>
    </div>
</form>
@endsection