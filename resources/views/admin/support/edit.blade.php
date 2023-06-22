@extends('layouts.admin.main')
@section('title','مشاهده پشتیبانی :: '.$items->title)
@section('page_title','مشاهده پشتیبانی :: '.$items->title)
@section('links_top_on_content')
    <div class="col-12 text-left">
        <a href="{{ route('admin.support.index') }}" class="btn btn-secondary btn-sm">لیست پشتیبانی</a>
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

    <form action="{{ url('admin/support/'. $items->id) }}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PUT" />
        <input type="hidden" name="user_id" value="{{ Auth::id() }}"/>
        <fieldset class="border p-2 px-4 mt-4 border-info rounded">
            <legend class="w-auto h6 px-2">پاسخ جدید</legend>
            <div class="form-row mb-2">
                <div class="form-group col-sm-12">
                    <div class="form-group" style="margin-bottom: 0;">
                        <textarea name="message" placeholder="پاسخ خود را بنویسید ..." class="form-control" required></textarea>
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="mt-4">
            <button class="btn btn-primary btn-sm">ارسال پاسخ</button>
        </div>
    </form>

    <fieldset class="border p-2 px-4 mt-4 border-info rounded">
        <legend class="w-auto h6 px-2">گفتگو ها</legend>
        <table class="table table-bordered small mt-4">
            <thead>
            <tr>
                <th>فرستنده</th>
                <th width="70%">پیام</th>
                <th>تاریخ</th>
            </tr>
            </thead>
            <tbody>
                @foreach($chat_list as $chat)
                    <tr>
                        @if($chat->user_id == 0)
                            <td>پاسخ مدیر</td>
                        @else
                            <td>{{ $chat->j_fullname }}</td>
                        @endif
                        <td>{{ $chat->message }}</td>
                        <td>{{ jdate($chat->created_at) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>{{ $items->j_fullname }}</td>
                    <td>{{ $items->message }}</td>
                    <td>{{ jdate($items->created_at) }}</td>
                </tr>
            </tbody>
        </table>
    </fieldset>




@endsection
