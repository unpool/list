@extends('layouts.admin.main')
@section('title','لیست محصولات')
@section('page_title','لیست محصولات')
@section('links_top_on_content')
<div class="col-12">
    <div class="mb-2 float-left">
        <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm">ثبت محصول جدید</a>
    </div>
</div>
@endsection
@section('content')
@if(isset($products) and $products->count())
<table class="table table-bordered small text-center">
    <thead>
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>قیمت</th>
            <th>سهم معرف</th>
            <th>امتیاز</th>
            <th>تعداد فایل‌ها</th>
            <th>دسته</th>
            <th>گروه مربیان</th>
            <th>تعداد استفاده شده در پکیج</th>
            <th>وضعیت</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $item)
        <tr>
            <td scope="row">{{ $item->id }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ !empty($item->prices['cash']) ?? $item->prices['cash'] }}</td>
            <td>{{ !empty($item->prices['coin']) ?? $item->prices['coin'] }}</td>
            <td>{{ $item->score }}</td>
            <td>{{ $item->medias->count() }} </td>
            <td>{{ join(' / ',$item->fromRootToNode) }}</td>
            <td>{{ $item->ownerable->id }}# - {{ $item->ownerable->teacher->first_name ?? '' }}
                {{ $item->ownerable->teacher->last_name ?? '' }}
            <td>
                {{ $item->countOfUseInPackages }}
            </td>
            <td>
                {{ translateStatusColumn($item->status) }}
            </td>
            <td>
                <a href="{{ route('admin.product.edit',['id' => $item->id]) }}" class="btn btn-primary btn-sm">
                    <span class="fa fa-pencil"></span>
                </a>
                @if( $item->countOfUseInPackages === 0)
                <form method="POST" action="{{ route('admin.product.destroy', ['product' => $item]) }}"
                    class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true" title="حذف محصول"></i>
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $products->links() }}
@else
<div class="mb-0">
    <span class="fa fa-exclamation-triangle"></span>
    متاسفانه هیچ داده‌ای پیدا نشد.
</div>
@endif
@endsection