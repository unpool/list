@extends('layouts.admin.main')
@section('title','ویرایش اطلاعات گروه')
@section('page_title','ویرایش اطلاعات گروه')
@section('links_top_on_content')
<div class="col-12">
    <div class="mb-2 float-left">
        <a href="{{ route('admin.teachers.group.create') }}" class="btn btn-primary btn-sm">ثبت گروه جدید</a>
    </div>
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
<form action="{{ route('admin.teachers.group.update', ['id' => $groupId]) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="form-row">
        <div class="col-12 col-sm-6 form-group">
            <label for="groupHead">انتخاب سرگروه</label>
            <select class="form-control" name="groupHead" id="groupHead">
                <!-- TODO : use select2 -->
                <option value="{{ $headOfGroup->id }}">{{ $headOfGroup->fullName() }}</option>
                @foreach ($teachersCanBeMemberOfGroup as $item)
                <option value="{{ $item->id }}">{{ $item->fullName() }}</option>
                @endforeach
            </select>
            <small id="helpGroupHead" class="form-text text-muted">مربی که به عنوان سرگروه انتخاب می‌شود، قابلیت تعیین
                سطح دسترسی برای سایر مربیان خواهد داشت.</small>
        </div>
    </div>

    @if($membersOfGroup->count())
    <div class="form-group">
        <table class="table table-bordered small">
            <caption>انتخاب مربی به عنوان عضوی از تیم</caption>
            <thead>
                <tr>
                    <th>

                    </th>
                    <th>شناسه مربی</th>
                    <th>نام و نام خانوادگی</th>
                    <th>سطح دسترسی</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($membersOfGroup as $item)
                <tr>
                    <td class="text-center" scope="row">
                        <input type="checkbox" checked name="members[]" value="{{ $item->id }}">
                    </td>
                    <td>{{ $item->id }}</td>
                    <td>
                        {{ $item->fullName() }}
                    </td>
                    <td>
                        @forelse ($item->permissions as $item)
                        <li>{{ $item->name }}</li>
                        @empty
                        <span class="text-danger">بدون دسترسی</span>
                        @endforelse
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <div class="form-group">
        <table class="table table-bordered small">
            <caption>انتخاب مربی به عنوان عضوی از تیم</caption>
            <thead>
                <tr>
                    <th>

                    </th>
                    <th>شناسه مربی</th>
                    <th>نام و نام خانوادگی</th>
                    <th>سطح دسترسی</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachersCanBeMemberOfGroup as $item)
                <tr>
                    <td class="text-center" scope="row">
                        <input type="checkbox" name="members[]" value="{{ $item->id }}">
                    </td>
                    <td>{{ $item->id }}</td>
                    <td>
                        {{ $item->fullName() }}
                    </td>
                    <td>
                        @forelse ($item->permissions as $item)
                        <li>{{ $item->name }}</li>
                        @empty
                        <span class="text-danger">بدون دسترسی</span>
                        @endforelse
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <button class=" btn btn-primary">ارسال</button>
</form>
@endsection