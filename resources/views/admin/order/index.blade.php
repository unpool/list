@extends('layouts.admin.main')
@section('title','نمایش صورت حساب ها')
@section('page_title','نمایش صورت حساب ها')
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
    <table class="table table-bordered text-center small">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">نام</th>
            <th scope="col">نام خانوادگی</th>
            <th scope="col">قیمت</th>
            <th scope="col">وضعیت پرداخت</th>
            <th scope="col">روش ارسال</th>
            <th scope="col">عملیات</th>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                <th>{{ $order->id }}</th>
                @if ($order->user)
                <td>{{$order->user->first_name}}</td>
                <td>{{$order->user->last_name}}</td>
                @else
                    <td>{{'بدون کاربر'}}</td>
                    <td>{{'بدون کاربر'}}</td>
                @endif
                <td>{{$order->price}}</td>
                <td>{{$order->show_paid}}</td>
                <td>{{$order->send_type}}</td>
                <td>
                    <a href="{{ route('admin.order.show', ['id' => $order->id]) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>
                <form method="POST" action="{{ route('admin.order.destroy', ['order' => $order]) }}"
                    class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true" title="حذف محصول"></i>
                    </button>
                </form>
                </td>
            </tr>
        @empty
            <tr>
                <th colspan="8">متاسفانه هیچ داده‌ای پیدا نشد.</th>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$orders->links()}}
@endsection
