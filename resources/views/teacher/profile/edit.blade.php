@extends('layouts.teacher.main')
@section('title','ویرایش اطلاعات پروفایل')
@section('page_title','ویرایش اطلاعات پروفایل')
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
    <div class="row">
        <div class="col-12 my-2">
            <form action="{{ route('teacher.profile.update') }}" method="post">
                <div class="row">
                    <div class="col-12 col-sm-4 form-group">
                        <label for="first_name">نام</label>
                        <input type="text" class="form-control" name="first_name"
                               value="{{ login_teacher()->first_name }}">
                    </div>
                    <div class="col-12 col-sm-4 form-group">
                        <label for="last_name">نام خانوادگی</label>
                        <input type="text" class="form-control" name="last_name"
                               value="{{ login_teacher()->last_name }}">
                    </div>
                    <div class="col-12 col-sm-4 form-group">
                        <label for="email">پست الکترونیکی</label>
                        <input type="text" class="form-control" name="email" value="{{ login_teacher()->email }}">
                    </div>
                    <div class="col-12 form-group">
                        <label for="cv">رزومه</label>
                        <textarea name="cv" class="form-control tinymce_holder" cols="30"
                                  rows="10">{{ login_teacher()->cv->cv ?? '' }}</textarea>
                    </div>
                    <button class="btn btn-primary">ارسال</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        let images_upload_url = '/teacher/profile/tiny-mce-image-upload';

        tinymce.init({
            convert_urls: false,
            selector: '.tinymce_holder',
            plugins: 'image code table lists media',
            toolbar: 'undo redo | image code',
            images_upload_url: images_upload_url,
        });
    </script>
@endsection