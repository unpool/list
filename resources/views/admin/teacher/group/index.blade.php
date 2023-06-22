@extends('layouts.admin.main')
@section('title','لیست گروه‌های مربیان')
@section('page_title','لیست گروه‌های مربیان')
@section('links_top_on_content')
<div class="col-12">
    <div class="pull-left">
        <a href="{{ route('admin.teachers.group.create') }}" class="btn btn-info btn-sm">ثبت گروه</a>
    </div>
</div>
@endsection
@section('content')

@if(isset($items) and $items->count())
<table class="table table-bordered text-center small">
    <caption>لیست گروه‌های ثبت شده</caption>
    <thead>
        <tr>
            <th>شناسه گروه</th>
            <th>نام سرگروه</th>
            <th>تعداد اعضای گروه</th>
            <th>علمیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->group->id }}</td>
            <td>{{ $item->fullName() }}</td>
            <td>{{ $item->group->members->count() }}</td>
            <td>
                <a href="{{ route('admin.teachers.group.edit', ['id' =>  $item->group->id ]) }}"
                    class="btn btn-sm btn-primary">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
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