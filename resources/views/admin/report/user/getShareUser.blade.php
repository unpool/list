@extends('layouts.admin.main')
@section('title','کاربران ثبت نام کرده')
@section('page_title','کاربران ثبت نام کرده')
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

    <form class="form-inline" action="{{ route('admin.report.user.get_share_user') }}" method="POST">
        @csrf

        <label for="exampleFormControlSelect1"> پروژه </label>
        <select class="form-control  mb-2 mx-2 mr-sm-2" name="node_id" id="exampleFormControlSelect1">
            @foreach($nodes as $node)
                <option value="{{ $node['id'] }}">#{{ $node['id'] }} / {{ $node['title'] }}</option>
            @endforeach
        </select>
        @if($date_status)
            <label for="start">از تاریخ</label>
            <input type="text" name="start" @if(isset($start_unix_time)) default-value="{{ $start_unix_time }}" @endif
            class="form-control persian-date-picker--just-date mb-2 mx-2 mr-sm-2" id="start">

            <label for="end">تا تاریخ</label>
            <div class="input-group mb-2 mr-sm-2">
                <input type="text" name="end" @if(isset($end_unix_time)) default-value="{{ $end_unix_time }}" @endif
                class="form-control persian-date-picker--just-date" id="end">
            </div>
        @endif
        <input type="hidden" name="date_status" value="{{ $date_status }}">
        <button type="submit" class="btn btn-primary mb-2 mx-2">
            <span class="fa fa-filter"></span>
            فیلتر
        </button>
    </form>
    @if(isset($items))
        <hr>

        <p class="small text-muted">نتایج پیدا شده: {{ count($items) }} عدد </p>
        <button type="button" class="btn btn-info small float-left mb-5" data-toggle="modal"
                data-target="#exampleModal">
            ارسال نوتیفیکیشن به کاربران
        </button>



        <table class="table table-bordered text-center small custom_datatable">
            <thead>
            <tr>
                <th>#</th>
                <th>نام و نام خانودگی</th>
                <th>تعداد خرید با این کد</th>
                <th>مبلغ سهم معرف</th>
                <th>مجموع</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $key => $item)
                <tr>
                    <td scope="row">{{ $key  }}</td>
                    <td>
                        <a href="{{ route('admin.user.show_info', $item['user']['id']) }}">
                            {{ $item['user']['first_name'] }} {{ $item['user']['last_name'] }}
                        </a>
                    </td>
                    <td>{{ $item['counter'] }}</td>
                    @if(count($nodeData['prices']))
                        <td>{{ $nodeData['prices'][0]['amount'] }}</td>
                        <td>{{ $nodeData['prices'][0]['amount'] * $item['counter'] }}</td>
                    @endif
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

@section('js')
    @if(isset($items))
        @php
            $usersId = array_keys($items);
        @endphp

        @include('layouts.admin.partial.sendnotification', ['usersReceiverID' =>$usersId])
    @endif
    @include('layouts.admin.partial.datatable')
@endsection
