@extends('layouts.admin.main')
@section('title','تنظیمات')
@section('page_title','راهنما')
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
    <form action="{{route('admin.setting.store',['key' => $key])}}" method="POST">
        @csrf
            <textarea name="value" rows="50" id="editor1">{!! !empty($value) ? $value->value : ''!!}</textarea>
        <button class="btn btn-success">ثبت</button>
    </form>

@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/4.14.0/full-all/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'editor1',{
            language:'fa',
            height:'600px'
        });
    </script>
@endsection
