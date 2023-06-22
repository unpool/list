@extends('layouts.admin.main')
@section('title','ویرایش تخفیف')
@section('page_title','ویرایش تخفیف')
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

<form action="{{ route('admin.discounts.update', ['discount' => $discount->id])  }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-row">
        <div class="col-12 col-sm-4 form-group">
            <label for="title">عنوان تخفیف</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $discount->title  }}">
        </div>
        <div class="col-12 col-sm-4 form-group">
            <label for="code">کد تخفیف</label>
            <input type="text" name="code" id="code" class="form-control" value="{{ $discount->code }}">
        </div>
        <div class="col-12 col-sm-4">
            <label for="type">نوع کد تخفیف</label>
            <select name="type" id="type" class="form-control">
                @foreach ($discountTypes as $key => $item)
                <option @if($key==$discount->type) selected @endif value="{{ $key }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-12">
            <label for="description">توضیحات</label>
            <textarea class="form-control" name="description" id="description"
                rows="5">{{ $discount->description  }}</textarea>
        </div>

        <div class="form-row col-12 mt-3">
            <button class="btn btn-sm btn-primary">
                ثبت و مرحله بعد
            </button>
        </div>
    </div>
</form>
@endsection