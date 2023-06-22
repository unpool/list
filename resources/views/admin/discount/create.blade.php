@extends('layouts.admin.main')
@section('title','ایجاد تخفیف')
@section('page_title','ایجاد تخفیف')
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
‌<form action="{{ route('admin.discounts.store')  }}" method="POST">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-4 form-group">
            <label for="title">عنوان تخفیف</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="col-12 col-sm-4 form-group">
            <label for="code">کد تخفیف</label>
            <input type="text" name="code" id="code" class="form-control">
        </div>
        <div class="col-12 col-sm-4">
            <label for="type">نوع کد تخفیف</label>
            <select name="type" id="type" class="form-control">
                @foreach ($discountTypes as $key => $item)
                <option value="{{ $key }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-12">
            <label for="description">توضیحات</label>
            <textarea class="form-control" name="description" id="description" rows="5"></textarea>
        </div>

        <div class="form-row col-12">
            <button class="btn btn-sm btn-primary">مرحله بعد</button>
        </div>
    </div>
</form>
@endsection