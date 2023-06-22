@extends('layouts.admin.main')
@section('title','پشتیبانی')
@section('page_title','پشتبانی')
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


    @if($items != '')
        <hr>

        <table class="table table-bordered small">
            <thead>
            <tr>
                <th style="width: 35%;">عنوان</th>
                <th>کاربر</th>
                <th>تاریخ ارسال</th>
                <th>تاریخ آخرین بروز رسانی</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $item)
                <?php $num = App\Models\Support::where('parent_id', $item->id)->where('type', 'user')->where('seen', 1)->count(); ?>
                <tr @if($num > 0 or $item->seen == 1) style="background-color: bisque; @endif">
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->j_fullname }}</td>
                    <td>{{ jdate($item->created_at) }}</td>
                    <td>{{ jdate($item->updated_at) }}</td>
                    <td>
                        <a href="{{ url('admin/support/'. $item->id .'/edit') }}" class="btn btn-primary btn-sm" title="مشاهده"><i class="fa fa-eye"></i></a>
                        <form action="{{ url('admin/support/'. $item->id) }}" class="d-inline" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-sm btn-danger" title="حذف این پشتیبانی">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @else
        <div class="my-3">
            هیچ نتیجه‌ای یافت نشد.
        </div>
    @endif
@endsection