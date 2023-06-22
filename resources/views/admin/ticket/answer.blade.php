@extends('layouts.admin.main')
@section('title','لیست تیکت ها')
@section('page_title','لیست تیکت ها')
@section('content')
    <form action="{{ route('admin.tickets.answer.question', compact('ticket')) }}" method="post">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">پاسخ</label>
            <textarea name="answer" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $ticket->answer ?? '' }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">ارسال</button>
    </form>
@endsection