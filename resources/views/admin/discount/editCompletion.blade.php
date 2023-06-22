@extends('layouts.admin.main')
@section('title','تکمیل اطلاعات تخفیف')
@section('page_title','تکمیل اطلاعات تخفیف')
@section('links_top_on_content')
<div class="col-12">
    <a href="{{ route('admin.discounts.edit', ['discount' => $discount->id])  }}"
        class="float-left btn btn-sm btn-info">
        <i class="fa fa-forward" aria-hidden="true"></i>
        بازگشت به مرحله قبل
    </a>
</div>
@endsection
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

<table class="table table-bordered small">
    <caption>اطلاعات ثبت شده برای تخفیف</caption>
    <thead>
        <tr>
            <th>شناسه</th>
            <th>عنوان</th>
            <th>نوع</th>
            <th>کد</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td scope="row">{{ $discount->id  }}</td>
            <td>{{ $discount->title }}</td>
            <td>{{ $discount->translate_type }}</td>
            <td>{{ $discount->code }}</td>
        </tr>
    </tbody>
</table>

<form action="{{ route('admin.discounts.update.completion', ['discount' => $discount->id])  }}" method="POST">
    @csrf
    @method('PATCH')

    @if($discount->type === 'time')
    <div class="form-row">
        <div class="form-group col-sm-4">
            <label for="start">تاریخ شروع</label>
            <input type="text" name="start" default-value="{{ $discount->start_unix_time }}"
                class="persian-date-picker--just-date form-control">
        </div>
        <div class="form-group col-sm-4">
            <label for="end">تاریخ انتها</label>
            <input type="text" name="end" default-value="{{ $discount->end_unix_time }}"
                class="persian-date-picker--just-date form-control">
        </div>
    </div>
    @endif

    @if($discount->type === 'count')
    <div class="form-group col-sm-4">
        <label for="count">تعداد استفاده</label>
        <input type="number" class="form-control" name="count" id="count" min="1" aria-describedby="countHelpId"
            value="{{ $discount->allowed_count ?? 1 }}">
        <small id="countHelpId" class="form-text text-muted">تعداد بار مجاز برای استفاده از این کد تخفیف</small>
    </div>
    @endif
    @if($discount->type === 'user')
    <div class="form-group col-12 col-sm-4">
        <label for="users">کاربران</label>
        <select name="users[]" id="users" class="form-control" multiple>
            @foreach ($users as $user)
            <option value="{{ $user->id  }}">{{ $user->full_name }} </option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="form-row col-12 mt-3">
        <button class="btn btn-sm btn-primary">تایید و ثبت</button>
    </div>
    </div>
</form>
@endsection