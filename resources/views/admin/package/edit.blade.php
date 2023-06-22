@extends('layouts.admin.main')
@section('title','ویرایش پکیج')
@section('page_title','ویرایش پکیج')
@section('links_top_on_content')
@if($package->jalaliCreatedAt)
<div class="col-12">
    @if($package->jalaliCreatedAt)
    <small>
        <i class="fa fa-plus-circle" aria-hidden="true"></i>
        ایجاد شده در
        {{ $package->jalaliCreatedAt }}
    </small>
    @endif
    @if($package->jalaliUpdatedAt)
    <small class="float-left">
        <i class="fa fa-pencil" aria-hidden="true"></i>
        آخرین زمان ویرایش
        {{ $package->jalaliUpdatedAt }}
    </small>
    @endif
</div>
@endif
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

<form enctype="multipart/form-data" action="{{ route("admin.package.update", ['id' => $package->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-12 col-sm-4">
            <label>انتخاب دسته</label>
            <ul class="p-3 border rounded">
                @foreach ($root_nodes as $node)
                <li class="list-unstyled">
                    <input type="radio" @if($node->id === $package->parent_id) checked @endif value="{{ $node->id }}"
                    name="category" />
                    <label>{{ $node->title }}</label>
                </li>
                <ul class="d-block">
                    @foreach ($node->childrenNodes as $childNode)
                    @include('admin.node.partial.subNodeRadioButton', ['childNode' => $childNode, 'mustBeCheck' =>
                    $package->parent_id])
                    @endforeach
                </ul>
                @endforeach
            </ul>
        </div>

        <div class="col-12 col-sm-4">
            <div class="form-group">
                <label for="price">قیمت به تومان</label>
                <input type="text" name="price" id="price" class="form-control" placeholder="قیمت پکیج"
                    aria-describedby="cashPriceHelp" value="{{ $prices['cash'] ?? '' }}">
                <small id="cashPriceHelp" class="text-muted">قیمت را به تومان وارد نمایید.</small>
            </div>

            <!-- Coin Price -->
            <div class="form-group">
                <label for="price_coin">سهم معرف</label>
                <input type="text" name="price_coin" id="price_coin" class="form-control"
                    placeholder="سهم معرف را وارد نمایید." value="{{ $prices['coin'] ?? '' }}">
            </div>

            <!-- flash Price -->
            <div class="form-group">
                <label for="flash_price">قیمت فلش</label>
                <input type="text" name="flash_price" id="flash_price" class="form-control"
                    value="{{ $prices['flash'] ?? '' }}" placeholder="قیمت برای ارسال به صورت فلش">
            </div>

            <!-- dvd Price -->
            <div class="form-group">
                <label for="dvd_price">قیمت دی‌وی‌دی</label>
                <input type="text" name="dvd_price" id="dvd_price" class="form-control"
                    value="{{ $prices['dvd'] ?? '' }}" placeholder="قیمت برای ارسال به صورت دی‌وی‌دی">
            </div>

            <!-- Score -->
            <div class="form-group">
                <label for="score">امتیاز</label>
                <input type="number" name="score" id="score" class="form-control" placeholder="امتیاز را وارد کنید."
                    value="{{ $package->score }}">
            </div>

            <div class="form-group">
                <label for="title">نام پکیج</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $package->title }}">
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
                <small id="groupId" class="text-muted">مربی که میخواهید این پکیج برای او ثبت شود را انتخاب
                    کنید.</small>
            </div>
        </div>

        <div class="col-12 col-sm-4">
            <div class="form-group">
                <label for="status">وضعیت</label>
                <select name="status" id="status" class="form-control">
                    <option value="publish" @if($package->status == 'publish') selected @endif>منتشر شده</option>
                    <option value="disable" @if($package->status == 'disable') selected @endif>غیرفعال</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea name="description" id="description" class="form-control" rows="10" placeholder="توضیحات پکیج"
                    aria-describedby="descriptionHelpInput">{{ $package->description }}</textarea>
                <small id="descriptionHelpInput" class="text-muted">توضیحات مربوط به پکیج که می‌تواند برای بازدید
                    کنندگان
                    جذاب باشد را تایپ کنید</small>
            </div>
        </div>


        <div class="col-12">
            <fieldset class="border p-2 px-4 mt-4 border-info rounded">
                <legend class="w-auto h6 px-2">شناسه‌ی محصولات مورد نظر را در اینجا وارد نمایید.</legend>
                <div class="col-12 mb-4">
                    <small class="text-muted">برای حذف یک آیتم کافی است تا باکس آنرا خالی رها کنید</small>
                    <div class="form-inline mb-2" id="productBoxHolder">
                        @foreach ($productsInPackage as $productId)
                        <div class="form-group m-1">
                            <input type="number" name="products[]" value="{{ $productId }}" class="form-control">
                        </div>
                        @endforeach
                    </div>
                    <span class="btn btn-primary btn-sm" id="addProductToPackage">افزودن محصول</span>
                </div>
            </fieldset>
        </div>

        <div class="col-12 mb-3">
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

        <button class="btn btn-primary">ارسال</button>
    </div>
</form>
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
                    action="{{ route('admin.package.fileDelete', ['id' => $package->id,'mediaId' => $iconImage['mediaId']]) }}"
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
                    action="{{ route('admin.package.fileDelete', ['id' => $package->id,'mediaId' => $backgroundImage['mediaId']]) }}"
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
@endsection