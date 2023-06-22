@extends('layouts.admin.main')
@section('title','لیست بهترین‌ها')
@section('page_title','لیست بهترین‌ها')

@section('content')
<div class="row">
    @if(isset($items) and $items->count())
    <table class="table table-bordered text-center small">
        <thead>
            <tr>
                <th>#</th>
                <th>شناسه دسته</th>
                <th>نام دسته</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}#</td>
                <td>{{ $item->node_id }}#</td>
                <td>{{ $item->node->title ?? '' }}</td>
                <td>
                    <form action="{{ route('admin.node.best.destroy', ['id' => $item->id ]) }}" method="POST"
                        class="text-center">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-danger btn-sm">
                            <span class="fa fa-trash"></span>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="mb-0 px-2">
        <span class="fa fa-exclamation-triangle text-warning"></span>
        متاسفانه هیچ داده‌ای پیدا نشد.</div>
    @endif
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#set_best_node">
    افزودن
</button>

<!-- Modal -->
<div class="modal fade" id="set_best_node" tabindex="-1" role="dialog" aria-labelledby="setNewBestNode"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">انتخاب دسته به عنوان بهترین‌ها</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.node.best.store') }}" method="POST">
                    @csrf
                    <label>انتخاب دسته</label>
                    <ul class="p-3 border rounded">
                        @foreach ($root_nodes as $node)
                        <li class="list-unstyled">
                            <input type="radio" value="{{ $node->id }}" name="category" />
                            <label>{{ $node->title }}</label>
                        </li>
                        <ul class="d-block">
                            @foreach ($node->childrenNodes as $childNode)
                            @include('admin.product.partial.select_node', ['childNode' => $childNode])
                            @endforeach
                        </ul>
                        @endforeach
                    </ul>
                    <button class="btn btn-primary btn-sm">ارسال</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>
@endsection