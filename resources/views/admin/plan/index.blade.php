@extends('layouts.admin.main')
@section('title','نمایش پلن ها')
@section('page_title','نمایش پلن ها')
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
            <th scope="col">امتیاز</th>
            <th scope="col">مدت زمان</th>
            <th scope="col">قیمت</th>
            <th scope="col">سهم معرف</th>
            <th scope="col">ویژه</th>
            <th scope="col">عملیات</th>
        </tr>
        </thead>
        <tbody>
        @forelse($plans as $plan)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{$plan->name}}</td>
                <td>{{$plan->score}}</td>
                <td>{{$plan->period}}</td>
                <td>{{$plan->price}}</td>
                <td>{{$plan->share_invited}}</td>
                <td><span class="fa fa-{{$plan->special}}"></span></td>
                <td>
                    <a href="{{ route('admin.plan.edit',['id' => $plan->id]) }}" class="btn btn-primary btn-sm">
                        <span class="fa fa-pencil"></span>
                    </a>
                    <form action="{{ route('admin.plan.destroy', ['plan' => $plan->id]) }}" class="d-inline" method="POST">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-sm btn-danger">
                            <i class="fa fa-trash" aria-hidden="true"></i>
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
    {{$plans->links()}}
@endsection
