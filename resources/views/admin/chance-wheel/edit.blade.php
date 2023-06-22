@extends('layouts.admin.main')
@section('title','گردونه شانس')
@section('page_title','گردونه ها')
@section('content')
    <form action="{{ route('admin.chance.wheel.update', compact('wheel')) }}" method="post">
        @csrf
        <div class="form-row">
            <div class="col-12 col-sm-6 form-group">
                <label for="title">عنوان</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $wheel->name }}">
            </div>
            <div class="col-12 col-sm-6 form-group">
                <label for="code">امتیاز</label>
                <input type="number" name="score" id="score" class="form-control" value="{{ $wheel->score }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">ارسال</button>
    </form>
@endsection
