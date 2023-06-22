@extends('layouts.admin.main')
@section('title','نمایش اطلاعات صورت حساب')
@section('page_title','نمایش اطلاعات صورت حساب')
@section('links_top_on_content')
    <div class="col-12 text-left">
        <a href="{{ route('admin.order.index') }}" class="btn btn-secondary btn-sm">لیست صورت حساب ها</a>
    </div>
@endsection
@section('content')
    <table class="table table-bordered text-center small">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">نام</th>
            <th scope="col">نام خانوادگی</th>
            <th scope="col">قیمت کل</th>
            <th scope="col">نوع دریافت</th>
            <th scope="col">وضعیت پرداخت</th>
            <th scope="col">نوع صورت حساب</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>{{ $order->id }}</th>
            @if ($order->user)
                <td>{{$order->user->first_name}}</td>
                <td>{{$order->user->last_name}}</td>
            @else
                <td>{{'بدون کاربر'}}</td>
                <td>{{'بدون کاربر'}}</td>
            @endif
            <td>{{ $order->price }}</td>
            <td>{{ $order->send_type }}</td>
            <td>{{ $order->show_paid }}</td>
            <td>{{ $order->type }}</td>
        </tr>
        </tbody>
    </table>
    @if($order->type == \App\Enums\OrderType::BUYNODE)
        <table class="table table-bordered text-center samll">
            <thead>
            @foreach($order->orderables as $item)
                <tr>
                    <th>نام پکیج</th>
                    <td>{{!empty($item->node->title) ? $item->node->title : ''}}</td>
                </tr>
            @endforeach
            </thead>
        </table>
    @endif
@endsection
