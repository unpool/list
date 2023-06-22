@extends('layouts.admin.main')
@section('title','لیست پکیج‌ها')
@section('page_title','لیست پکیج‌ها')
@section('links_top_on_content')
<div class="col-12">
    <div class="mb-2 float-left">
        <a href="{{ route('admin.package.create') }}" class="btn btn-primary btn-sm">ثبت پکیج جدید</a>
    </div>
</div>
@endsection
@section('content')
@if(isset($items) and $items->count())
<table class="table table-bordered small text-center">
    <thead>
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>قیمت</th>
            <th>سهم معرف</th>
            <th>امتیاز</th>
            <th>تعداد محصولات </th>
            <th>دسته</th>
            <th>گروه مربیان</th>
            <th>وضعیت</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            <td scope="row">{{ $item->id }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->prices['cash'] }}</td>
            <td>{{ $item->prices['coin'] }}</td>
            <td>{{ $item->score }}</td>
            <td> {{ $item->packageItems->count() }} </td>
            <td>{{ join(' / ',$item->fromRootToNode) }}</td>
            <td>{{ $item->ownerable->id }}# - {{ $item->ownerable->teacher->first_name ?? '' }}
                {{ $item->ownerable->teacher->last_name ?? '' }}
            </td>
            <td>
                {{ translateStatusColumn($item->status) }}
            </td>
            <td>
                <a href="{{ route('admin.package.edit',['id' => $item->id]) }}" class="btn btn-primary btn-sm">
                    <span class="fa fa-pencil"></span>
                </a>
                <form method="POST" action="{{ route('admin.package.destroy', ['package' => $item]) }}"
                    class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true" title="حذف"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $items->links() }}
@else
<div class="mb-0">
    <span class="fa fa-exclamation-triangle"></span>
    متاسفانه هیچ داده‌ای پیدا نشد.
</div>
@endif

@endsection