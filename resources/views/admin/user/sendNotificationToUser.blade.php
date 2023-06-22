@extends('layouts.admin.main')
@section('title','ارسال نوتیفیکیشن')
@section('page_title','ارسال نوتیفیکیشن')
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

    <form action="{{ route('admin.report.user.send-notification') }}" method="post">
        @csrf
        <fieldset class="border p-2 px-4 border-info rounded">
            <legend class="w-auto h6 px-2">ارسال نوتیفیکیشن و SMS</legend>
            <div class="form-row">
                <div class="col-sm-12 mt-2">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">* عنوان</label>
                        <input type="text" class="form-control" name="title" id="exampleFormControlInput1" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label>کاربران</label>
                    <select class="js-example-basic-multiple mb-2" name="users[]" multiple="multiple" style="white:100%;">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->fullname }} / {{ $user->mobile }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="col-sm-12 mt-3  ">
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">نوع</label>
                        <select class="form-control" name="type" id="exampleFormControlSelect2">
                            <option value="sms">sms</option>
                            <option value="pushe">پوشه</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">توضیحات</label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1"
                                  rows="3"></textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm mt-1">جستجو</button>
                </div>
            </div>
        </fieldset>
    </form>

@endsection

@section('js')
    <link href="{{ url('') }}/select2/css/select2.min.css" rel="stylesheet"/>
    <script src="{{ url('') }}/select2/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2({
                width: '100%',
                dir: "rtl"
            });
        });
    </script>
@endsection
