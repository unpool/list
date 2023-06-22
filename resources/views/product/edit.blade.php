@extends('layouts.admin.main')
@section('title','ویرایش محصول')
@section('page_title','ویرایش محصول')
@section('links_top_on_content')
<div class="col-12">
    @if($product->jalaliCreatedAt)
    <small>
        <i class="fa fa-plus-circle" aria-hidden="true"></i>
        ایجاد شده در
        {{ $product->jalaliCreatedAt }}
    </small>
    @endif
    @if($product->jalaliUpdatedAt)
    <small class="float-left">
        <i class="fa fa-pencil" aria-hidden="true"></i>
        آخرین زمان ویرایش
        {{ $product->jalaliUpdatedAt }}
    </small>
    @endif
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
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    <strong><i class="fa fa-exclamation-triangle"></i></strong> با انتخاب یک والد، محصول در تمام زیر دسته‌ها نیز به
    نمایش گذاشته
    می‌شود.
</div>
<form enctype="multipart/form-data" action="{{ route("admin.product.update",['id' => $product->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12 col-sm-4">
            <label>انتخاب دسته</label>
            <ul class="p-3 border rounded">
                @foreach ($root_nodes as $node)
                <li class="list-unstyled">
                    <input type="radio" @if($node->id == $product->parent_id) checked @endif value="{{ $node->id }}"
                    name="category" />
                    <label>{{ $node->title }}</label>
                </li>
                <ul class="d-block">
                    @foreach ($node->childrenNodes as $childNode)
                    @include('admin.product.partial.select_node', ['childNode' => $childNode, 'product' =>
                    $product])
                    @endforeach
                </ul>
                @endforeach
            </ul>
        </div>

        <div class="col-12 col-sm-4">
            <div class="form-group">
                <label for="price">قیمت به تومان</label>
                <input type="text" name="price" id="price" class="form-control" placeholder="قیمت محصول"
                    value="{{ $product->prices->where('type',\App\Enums\PriceType::CASH)->first()->amount ?? '' }}"
                    aria-describedby="cashPriceHelp">
                <small id="cashPriceHelp" class="text-muted">قیمت را به تومان وارد نمایید.</small>
            </div>

            <!-- Coin Price -->
            <div class="form-group">
                <label for="price_coin">سهم معرف</label>
                <input type="text" name="price_coin" id="price_coin" class="form-control"
                    placeholder="سهم معرف را وارد نمایید."
                    value="{{ $product->prices->where('type',\App\Enums\PriceType::COIN)->first()->amount ?? '' }}"
                    aria-describedby="coinPriceHelp">
            </div>

            <!-- Score -->
            <div class="form-group">
                <label for="score">امتیاز</label>
                <input type="number" name="score" id="score" class="form-control" placeholder="امتیاز را وارد کنید."
                    value="{{ $product->score }}">
            </div>

            <div class="form-group">
                <label for="title">نام محصول</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $product->title }}">
            </div>

            <div class="form-group">
                <label for="group">ثبت برای گروه مربیان</label>
                <select name="group" id="group" class="form-control" aria-describedby="groupId">
                    @foreach ($groups as $item)
                    <option @if($item->id === $package_owner->id) selected @endif value="{{ $item->id }}">گروه
                        {{ $item->teacher->first_name }}
                        {{ $item->teacher->last_name }}
                    </option>
                    @endforeach
                </select>
                <small id="groupId" class="text-muted">مربی که میخواهید این محصول برای او ثبت شود را انتخاب
                    کنید.</small>
            </div>
        </div>

        <div class="col-12 col-sm-4">
            <div class="form-group">
                <label for="status">وضعیت</label>
                <select name="status" id="status" class="form-control">
                    <option value="publish" @if($product->status == 'publish') selected @endif>منتشر شده</option>
                    <option value="disable" @if($product->status == 'disable') selected @endif>غیرفعال</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea name="description" id="description" class="form-control" rows="10" placeholder="توضیحات محصول"
                    aria-describedby="descriptionHelpInput">{{ $product->description }}</textarea>
                <small id="descriptionHelpInput" class="text-muted">توضیحات مربوط به محصول که می‌تواند برای بازدید
                    کنندگان
                    جذاب باشد را تایپ کنید</small>
            </div>
        </div>
        <div class="col-12">
            <fieldset class="border p-2 px-4 mt-4 border-info rounded">
                <legend class="w-auto h6 px-2">تصویر ایکون و بک‌گراند</legend>
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="icon">تصویر ایکون</label>
                        <input type="file" name="icon" id="icon" class="form-control">
                    </div>
                    <div class="form-group col-4">
                        <label for="background">تصویر پس زمینه</label>
                        <input type="file" name="background" id="background" class="form-control">
                    </div>
                </div>
            </fieldset>
        </div>
        <button class="btn btn-primary mt-3">ارسال</button>
    </div>
</form>

<hr>
@if( isset($iconImage) || isset($backgroundImage))
<table class="mt-3 table table-bordered small">
    <thead>
        <tr>
            <th>تصویر</th>
            <th>نوع</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($iconImage))
        <tr>
            <td>
                <img src="{{ asset($iconImage['path']) }}" style="width:100px;">
            </td>
            <td>ایکون</td>
            <td>
                <form class="form-inlnie d-inline"
                    action="{{ route('admin.product.fileDelete', ['id' => $product->id,'mediaId' => $iconImage['mediaId']]) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endif
        @if(isset($backgroundImage))
        <tr>
            <td>
                <img src="{{ asset($backgroundImage['path']) }}" style="width:100px;">
            </td>
            <td>بک گراند</td>
            <td>
                <form class="form-inlnie d-inline"
                    action="{{ route('admin.product.fileDelete', ['id' => $product->id,'mediaId' => $backgroundImage['mediaId']]) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endif
    </tbody>
</table>
@endif

@if ($product_media_count)
<table class="table table-bordered small">
    <thead>
        <tr>
            <th>شناسه</th>
            <th>نام</th>
            <th>جنس</th>
            <th>ترتیب</th>
            <th>اندازه</th>
            <th>جابه‌جایی‌با</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product_medias as $key => $item)
        <tr>
            <td scope="row">{{ $item->id }}</td>
            <td>{{ $item->path }}</td>
            <td>{{ $item->pivot->type }}</td>
            <td>{{ $item->pivot->order ?? 'بدون ترتیب' }}</td>
            <td>{{ round(($item->size)/1000000,2) }} MB</td>
            <td>
                <form
                    action="{{ route('admin.product.changeFileOrder', ['id' => $product->id,'media_id' => $item->id]) }}"
                    method="POST" class="d-inline-block form-inline">
                    <input type="text" class="text-center p-1" name="order" value="{{ $item->pivot->order }}">
                    <button class="btn btn-info btn-sm ">
                        <span class="fa fa-pencil"></span>
                    </button>
                </form>
            </td>
            <td>
                <form class="form-inlnie d-inline"
                    action="{{ route('admin.product.fileDelete', ['id' => $product->id,'mediaId' => $item->id]) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </form>
                <form class="form-inline d-inline"
                    action="{{ route('admin.product.fileDownload', ['id' => $product->id,'mediaId' => $item->id]) }}"
                    method="POST">
                    @csrf
                    <button class="btn btn-success btn-sm">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


{{-- <div class="row mb-3">
            <div class="col-12">
                <p>فایل‌های بارگذاری شده:</p>
            </div>
            @foreach ($product->medias as $item)
            <div class="col-12 col-sm-3">
                <div class="card">
                    <div class="card-body py-1">
                        <p class="card-text">
                            <p>حجم فایل:‌
                                {{ round(($item->size)/1000000,2) }} مگابایت
</p>

<div class="btn-group btn-block text-center" role="group">
    <form action="{{ route('admin.product.fileDelete', ['id' => $product->id,'mediaId' => $item->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="text-center btn btn-danger btn-sm rounded-0">
            <i class="fa fa-trash" aria-hidden="true"></i>
            حذف
        </button>
    </form>
    <form action="{{ route('admin.product.fileDownload', ['id' => $product->id,'mediaId' => $item->id]) }}"
        method="POST">
        @csrf
        <button class="text-center btn btn-success btn-sm rounded-0">
            <i class="fa fa-download" aria-hidden="true"></i>
            دانلود
        </button>
    </form>
</div>
</p>
</div>
</div>
</div>
@endforeach
</div> --}}
@endif
<div class="row" id="filePart">
    <div class="col-12">
        <p class="text-bold">بارگذاری فایل‌های محصول
            <small class="text-muted">(فایل‌های مورد نظر را بکشید و درچارچوب زیر رها کنید)</small>
        </p>
    </div>
    <input type="hidden" name="id" id="productId" value="{{ $product->id }}">
    <form style="min-height:150px;" class="rounded w-100 dropzone py-0" action="{{route('admin.product.fileUpload')}}"
        method="POST" id='productDropzone'>
        <div class="fallback">
            <div class="form-group">
                <input name="file" type="file" multiple />
            </div>
        </div>
    </form>
</div>
@endsection