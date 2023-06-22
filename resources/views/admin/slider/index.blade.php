@extends('layouts.admin.main')
@section('title','نمایش اسلایدر‌ها')
@section('page_title','نمایش اسلایدر‌ها')
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
@if(isset($items) and $items->count())
<table class="table table-bordered text-center small">
    <thead>
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>لینک</th>
            <th>ثبت شده برای دسته‌ی</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->link }}</td>
            <td>{{ $item->fromRootToCategory }}</td>
            <td>
                <a href="{{ route('admin.slider.edit', ['slider' => $item->id]) }}" class="btn btn-primary btn-sm">
                    <span class="fa fa-pencil"></span>
                </a>
                <form action="{{ route('admin.slider.destroy', ['slider' => $item->id]) }}" method="POST"
                    class="d-inline form-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                        <span class="fa fa-trash"></span>
                    </button>
                </form>
                @if($item->medias()->first())
                <a href="{{ route('admin.slider.download',['slider' => $item->id,'file_name' => $item->medias()->first()->path]) }}"
                    class="btn btn-sm btn-success">
                    <span class="fa fa-download"></span>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $items->render() }}
@else
<div class="mb-0">متاسفانه هیچ داده‌ای پیدا نشد.</div>
@endif
@endsection