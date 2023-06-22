@extends('layouts.admin.main')
@section('title','نمایش تسویه حساب ها')
@section('page_title','نمایش تسویه حساب ها')
@section('content')
    <table class="table table-bordered text-center small">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">نام</th>
            <th scope="col">مقدار</th>
            <th scope="col">نوع درخواست</th>
            <th scope="col">تاریخ ثبت درخواست</th>
            <th scope="col">وضعیت</th>
        </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{$item->user->full_name}}</td>
                <td>{{number_format($item->value)}}</td>
                <td>{{\App\Enums\CheckoutType::READ[$item->type]}}</td>
                <td>{{$item->jalali_created}}</td>
                <td>
                    @if($item->type == \App\Enums\CheckoutType::CASH)
                    <a href="{{ route('admin.checkout.status',['checkout_id' => $item->id]) }}" class="btn btn-primary btn-sm">
                        <span class="fa fa-{{$item->icon_status}}"></span>
                    </a>
                        @endif
                </td>
            </tr>
        @empty
            <tr>
                <th colspan="6">متاسفانه هیچ داده‌ای پیدا نشد.</th>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$items->links()}}
@endsection
