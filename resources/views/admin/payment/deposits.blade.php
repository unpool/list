@extends('layouts.admin.main')
@section('title','پرداخت ها')
@section('page_title','درخواست های پرداخت')
@section('content')
@if(isset($deposit_requests) and $deposit_requests->count())
<table class="table table-bordered text-center small">
    <thead>
        <tr>
            <th>#</th>
            <th>تایید کننده</th>
            <th>درخواست دهنده</th>
            <th>پرداخت</th>
            <th>شماره کارت</th>
            <th>ایجاد شده در</th>
            <th>وضعیت</th>
            <th>بیشتر</th>
        </tr>
    </thead>
    <tbody>
        @foreach($deposit_requests as $key => $item)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $item->admin->first_name . ' ' . $item->admin->last_name }}</td>
            <td>{{ $item->user->first_name . ' ' . $item->user->last_name }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->card_number }}</td>
            <td>
                @if($item->status == '2')
                    پرداخت نشده
                @elseif($item->status == '1')
                    پرداخت شده
                @else
                    رد شده
                @endif
            </td>
            <td>{{ $item->created_at }}</td>
            <td>
                <form action="{{ route('admin.deposit.payed', ['deposit' => $item->id]) }}" method="POST">
                    @csrf
                    <input type="submit" class="btn btn-primary btn-sm" value="پرداخت شده">
                </form>

                <form action="{{ route('admin.deposit.rejected', ['deposit' => $item->id]) }}" method="POST">
                    @csrf
                    <input type="submit" class="btn btn-danger btn-sm" value="رد درخواست">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="mb-0">متاسفانه هیچ داده‌ای پیدا نشد.</div>
@endif
@endsection
