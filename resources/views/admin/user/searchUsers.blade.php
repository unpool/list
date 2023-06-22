@extends('layouts.admin.main')
@section('title','نمایش کاربران')
@section('page_title','نمایش کاربران')
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

    <form action="{{ route('admin.user.searchUsers') }}" method="GET">
        <fieldset class="border p-2 px-4 border-info rounded">
            <legend class="w-auto h6 px-2">جستجو کاربر</legend>
            <div class="form-row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control"
                               value="{{ (isset($valueSearch))? $valueSearch['search'] : old('search')}} " placeholder="متن جستجو" >
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="form-group">
                        <div class="form-group">
                            <select class="form-control" name="search-filed" id="search-filed">
                                <option value="mobile">شماره تلفن</option>
                                <option value="invite_code">کد معرف</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm mt-1">جستجو</button>
                </div>
            </div>
        </fieldset>
    </form>

    <br>
    <hr>
    <br>

    <p>
        <small class="text-success">
            <span class="fa fa-check-square-o"></span>
            کاربرانی که پروفایل آنها تکمیل است.
        </small>
        <small class="text-danger mx-4">
            <span class="fa fa-window-close-o"></span>
            کاربرانی که هنوز پروفایل آنها تکمیل نشده است.
        </small>
    </p>


    <table class="table table-bordered text-center small" id="example">
        <thead>
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>پست الکترونیکی / همراه</th>
            <th>معرف</th>
            <th>کیف پول</th>
            <th>امتیاز</th>
            <th>عضویت در</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $item)
            <tr>
                <th>
                    @if(!empty($item->first_name) and !empty($item->last_name) and !empty($item->email))
                        <span class="fa fa-check-square-o text-success"></span>
                    @else
                        <span class="fa fa-window-close-o text-danger"></span>
                    @endif
                    {{ $item->id }}</th>
                <td><a href="{{ route('admin.user.show_info', $item) }}">{{ $item->full_name }}</a></td>
                <td class="px-0">
                    @if($item->email)
                        {{ $item->email }}
                        <span class="fa fa-envelope text-primary"></span>
                        <hr class="my-1">
                    @endif
                    {{ $item->mobile }}
                    <span class="fa fa-phone text-success"></span>
                </td>
                <td>
                    @if($item->invitedFromUser())
                        {{ $item->invitedFromUser()->full_name }}
                    @else
                        ندارد
                    @endif
                </td>
                <td>
                    @if($item->wallet )
                        {{ $item->wallet }} تومان
                    @else
                        بدون موجودی
                    @endif
                </td>
                <td>{{ $item->score }}</td>
                <td>{{ $item->jalali_created_at }}</td>
                <td>
                <!-- <a href="{{ route('admin.user.show', ['id' => $item->id]) }}" class="btn btn-info btn-sm">
                    <i class="fa fa-eye"></i>
                </a> -->
                    <a href="{{ route('admin.user.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.report.user.orderList') }}" class="d-inline">
                        @csrf
                        <input name="user" id="users" type="hidden" value="{{ $item->id }}">
                        <button class="btn btn-sm btn-secondary">
                            <i class="fa fa-paperclip" aria-hidden="true"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.user.destroy', ['user' => $item->id]) }}" class="d-inline" method="POST">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-sm btn-danger">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="col-12 text-left">
        <div class="border p-3">
            <form action="{{ route('admin.user.usersInviteUsersWithActiveProfile') }}">
                لیست کاربرانی که کاربرانی فعال را معرفی کرده اند
                <button class="btn btn-primary pull-left btn-sm">نمایش</button>
            </form>
            <hr>
            <form action="form-inline">
                لیست افرادی که دوستانشان را معرفی کرده‌‌اند و دوستانشان اولین خرید را انجام داده‌اند.
                <button class="btn btn-primary btn-sm pull-left">نمایش</button>
            </form>
            <hr>
            <p>
                لیست کاربرانی که تعدادی خاص از دوستانشان را در یک بازه‌ی زمانی معرفی کرده‌اند.
            </p>
            <form action="{{ route('admin.user.usersInviteOtherUsersByCountAndDate') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-12 col-sm-4">
                        <label for="count">تعداد کاربران معرفی شده</label>
                        <input type="number" id="count" name="count" class="form-control">
                    </div>
                    <div class="form-group col-12 col-sm-4">
                        <label for="from_date">از تاریخ</label>
                        <input type="text" id="from_date" name="from_date"
                               class="form-control persian-date-picker--just-date">
                    </div>
                    <div class="form-group col-12 col-sm-4">
                        <label for="to_date">تا تاریخ</label>
                        <input type="text" id="to_date" name="to_date" class="form-control persian-date-picker--just-date">
                    </div>
                </div>
                <div class="form-row">
                    <button class="btn btn-sm btn-primary pull-left">نمایش</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')

    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                searching: false,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
    </script>
@endsection
