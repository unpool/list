@extends('layouts.admin.main')
@section('title','ایجاد صورت حساب')
@section('page_title','ایجاد صورت حساب')
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
    <form action="{{ route('admin.order.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="user_id">کاربر</label>
                    <select type="text" name="user_id" id="user_id" class="form-control">
                        <option value="">-- انتخاب نمایید --</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->fullname}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="send_type">روش ارسال</label>
                    <select type="text" name="send_type" id="send_type" class="form-control">
                        <option value="">-- انتخاب نمایید --</option>
                        <option value="{{\App\Enums\PriceType::DVD}}">{{\App\Enums\SendType::CD}}</option>
                        <option value="{{\App\Enums\PriceType::FLASH}}">{{\App\Enums\SendType::USB}}</option>
                        <option value="{{\App\Enums\PriceType::CASH}}">{{\App\Enums\SendType::DOWNLOAD}}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="node_id">پکیج ها</label>
                    <select multiple="multiple" type="text" name="nodes[]" id="node_id" class="form-control">
                        @foreach($nodes as $node)
                            <option value="{{$node->id}}">{{$node->full_title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button class="btn btn-success">ثبت صورت حساب</button>
        </div>
    </form>
@endsection
