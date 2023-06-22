@extends('layouts.admin.main')
@section('title')
    رزومه استاد،
    {{ $teacher->first_name }}
    {{ $teacher->last_name }}
@endsection
@section('page_title','رزومه استاد')
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
    <form action="{{ route('admin.teachers.cv.update', ['id' => $teacher->id]) }}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-12 form-group">
                <label for="cv">رزومه</label>
                        <textarea name="cv" class="form-control tinymce_holder" id="" cols="30"
                                  rows="20">{{ $teacher->cv->cv ??  '' }}</textarea>
            </div>
            <button class="btn btn-primary">ارسال</button>
        </div>
    </form>
@endsection
@section('js')
    <script>
        let images_upload_url = '{{ route('admin.teachers.cv.tinyMCEImageUpload', ['id' => $teacher->id  ]) }}';

        tinymce.init({
            convert_urls: false,
            selector: '.tinymce_holder',
            plugins: 'image code table lists media',
            toolbar: 'undo redo | image code',
            images_upload_url: images_upload_url,
        });
    </script>
@endsection