@extends('layouts.admin.main')
@section('title','ایجاد اشتراک')
@section('page_title','ایجاد اشتراک')
@section('links_top_on_content')
    <div class="col-12 text-left">
        <a href="{{ route('admin.plan.index') }}" class="btn btn-secondary btn-sm">لیست اشتراک ها</a>
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
    <form action="{{ route('admin.plan.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-4">
                <label>انتخاب دسته</label>
                <ul class="p-3 border rounded">
                    @foreach ($root_nodes as $node)
                        <li class="list-unstyled">
                            <input type="radio" value="{{ $node->id }}" name="category" />
                            <label>{{ $node->title }}</label>
                        </li>
                        <ul class="d-block">
                            @foreach ($node->childrenNodes as $childNode)
                                @include('admin.product.partial.select_node', ['childNode' => $childNode])
                            @endforeach
                        </ul>
                    @endforeach
                </ul>
            </div>
            <div class="col-12 col-sm-8">
                <div class="form-row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name">نام</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="score">امتیاز</label>
                            <input type="text" name="score" id="score" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="period">مدت زمان(روز)</label>
                            <input type="text" name="period" id="period" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="price">قیمت</label>
                            <input type="text" name="price" id="price" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="share_invited">سهم معرف</label>
                            <input type="text" name="share_invited" id="share_invited" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4" style="margin-top: 40px">
                        <div class="form-check">
                            <input type="checkbox" value="1" name="is_special" id="is_special" class="form-check-input">
                            <label for="is_special">ویژه</label>
                        </div>
                    </div>
                    <button class="btn btn-xs btn-success">ثبت اشتراک</button>
                </div>
            </div>
        </div>
    </form>
@endsection
