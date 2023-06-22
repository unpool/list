@extends('layouts.admin.main')
@section('title','لیست تخفیف‌ها')
@section('page_title','لیست تخفیف‌ها')
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
    <thead>
        <tr>
            <th>شناسه</th>
            <th>عنوان</th>
            <th>نوع</th>
            <th>کد</th>
            <th>تاریخ ایجاد</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            <td scope="row">{{ $item->id }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->translate_type }}</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->jalali_created_at }}</td>
            <td>
                <a href="{{ route('admin.discounts.edit', ['discount' => $item->id]) }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
                {{-- <a href="{{ route('admin.discounts.show', ['discount' => $item->id]) }}" class="btn btn-sm
                btn-warning">
                <i class="fa fa-eye" aria-hidden="true"></i>
                </a> --}}
                <form class="d-inline" action="{{ route('admin.discounts.destroy', ['discount' => $item->id]) }}"
                    method="POST">
                    @method("DELETe")
                    @csrf
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $items->render() }}
@endsection