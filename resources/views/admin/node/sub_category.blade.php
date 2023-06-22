<li>{{ $childNode->title }}</li>
@if ($childNode->nodes)
    <ul>
        @foreach ($childNode->nodes as $childCategory)
            @include('admin.node.sub_category', ['childNode' => $childCategory])
        @endforeach
    </ul>
@endif