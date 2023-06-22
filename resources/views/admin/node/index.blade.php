@extends('layouts.admin.main')
@section('title','نمایش دسته‌ها')
@section('page_title','نمایش دسته‌ها')
@section('links_top_on_content')
<div class="col-12">
    تعداد دسته‌های ثبت شده :
    <span>{{ $nodes_count }}</span>
</div>
<div class="container mt-2">
    <ul class="list-group">
        <li class="list-group-item list-group-item-warning">
            <span class="fa fa-exclamation-triangle"></span>
            با حذف یک دسته، تمام زیر دسته‌های آن نیز حذف خواهند شد.
        </li>
        <li class="list-group-item list-group-item-warning">
            <span class="fa fa-exclamation-triangle"></span>
            برای تغییر والد یک دسته می‌توانید دسته‌ها را با Drag And Drop (کشیدن و رها کردن) جا‌به‌جا کنید.
        </li>
    </ul>
    <ul id="jstree_action_alert" class="my-2 list-group d-none"></ul>
</div>

@endsection
@section('content')
<table class="table table-bordered small">
    <thead>
        <tr>
            <th>دسته‌ی انتخاب شده</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td id="selected_node_holder"></td>
            <td>
                <a href="" class="btn btn-sm btn-primary" id="editNodeButton">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
                <form action="" class="form-inline d-inline" id="deleteNodeForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </form>
            </td>
        </tr>
    </tbody>
</table>

<div id="jstree">
    {!! $html_nodes !!}
</div>
@endsection