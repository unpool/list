@extends('layouts.admin.main')
@section('title','ویرایش استاد')
@section('page_title','ویرایش استاد')
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
@section('links_top_on_content')
<div class="col-12">
    <div class="mb-2 float-left">
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary btn-sm">ثبت استاد جدید</a>
        <a href="{{ route('admin.teachers.cv.edit', ['id' => $teacher->id]) }}" class="btn btn-info btn-sm">ویرایش
            رزومه</a>
    </div>
</div>
@endsection
<form action="{{ route('admin.teachers.update', ['id' => $teacher->id]) }}" method="post">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12 col-sm-6 form-group">
            <label for="first_name">نام</label>
            <input type="text" class="form-control" name="first_name" value="{{ $teacher->first_name }}">
        </div>
        <div class="col-12 col-sm-6 form-group">
            <label for="last_name">نام خانوادگی</label>
            <input type="text" class="form-control" name="last_name" value="{{ $teacher->last_name }}">
        </div>
        <div class="col-12 col-sm-6 form-group">
            <label for="email">پست الکترونیکی</label>
            <input type="text" class="form-control" name="email" value="{{ $teacher->email }}">
        </div>
        <div class="col-12 col-sm-6 form-group">
            <label for="password">گذرواژه</label>
            <input type="password" class="form-control" name="password">
        </div>

        <div class="col-12 form-group">
            <p class="text-bold">انتخاب سطح دسترسی برای مربی
                <small class="text-muted">در صورتی که تمام سطوح دسترسی انتخاب شود، این مربی به عنوان مدیریت شناخته
                    خواهد شد.</small>
            </p>
            <div class="col-12 col-sm-4">
                <label>مدیریت محصولات در دسته</label>
                <ul class="p-3 border rounded">
                    @foreach ($root_nodes as $node)
                    <li class="list-unstyled">
                        <input type="checkbox" @if(in_array($node->id,$teacherCategoryPermissions)) checked @endif
                        value="{{ $node->id }}" name="category[]" />
                        <label>{{ $node->title }}</label>
                    </li>
                    <ul class="d-block">
                        @foreach ($node->childrenNodes as $childNode)
                        @include('admin.node.partial.subNodeCheckBoxButton', ['childNode' => $childNode, 'mustBeCheck'
                        => $teacherCategoryPermissions])
                        @endforeach
                    </ul>
                    @endforeach
                </ul>
            </div>
            <div class="form-check form-check-inline mr-0 pr-0">
                <label class="form-check-label">
                    <input type="checkbox" name="commentPermission" @if($teacherHaveCommentManagePermission) checked
                        @endif>
                    مدیریت نظرات
                </label>
            </div>
        </div>
        <button class="btn btn-primary">ارسال</button>
    </div>
</form>
@endsection