@extends('layouts.admin.main')
@section('title','گزارش کاربران براساس موقعیت مکانی')
@section('page_title','گزارش کاربران براساس موقعیت مکانی')

@section('content')
    <form method="POST">
        <div class="form-group">
            <label for="user">انتخاب کاربر</label>
            <select class="form-control col-12 col-sm-3" name="province">
                @foreach ($provinces as $item)
                    @if (is_null($item) || $item === "")
                        <option value="">بدون شهر</option>
                    @else
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <button class="btn btn-sm btn-primary">ارسال</button>
    </form>
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

    @if(isset($items))
        <hr>

        <p class="small text-muted">نتایج پیدا شده: {{ $items->count() }} عدد </p>
        <table class="table table-bordered small">
            <thead>
            <tr>
                <th>شناسه</th>
                <th>نام</th>
                <th>فامیل</th>
                <th>تاریخ تولد</th>
                <th>امتیاز</th>
                <th>کسب درآمد</th>
                <th>کیف پول</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $item)
                <tr>
                    <td scope="row">{{ $item->id }}</td>
                    <td>{{ $item->first_name }}</td>
                    <td>{{ $item->last_name }}</td>
                    <td>{{ $item->jalali_birthdate }}</td>
                    <td>{{ $item->score }}</td>
                    <td>{{ $item->share }}</td>
                    <td>{{ $item->wallet }}</td>
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
