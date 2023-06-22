@unless($childNode->is_product)
<li style="<?php echo 'margin-right:'. ($childNode->depth * 15) .'px' ?>">
    @unless($childNode->is_product)
    <input type="radio" value="{{ $childNode->id }}" name="category" />
    <label>{{ $childNode->title }}</label>
    <span class="mr-2 mb-1 badge badge-success">{{ $childNode->title }}</span>
    @endunless
</li>
@endunless
@if ($childNode->nodes)
<ul>
    @foreach ($childNode->nodes as $childCategory)
    @include('admin.node.best.partial.select_node', ['childNode' => $childCategory])
    @endforeach
</ul>
@endif