@unless($childNode->is_product)
<li style="<?php echo 'margin-right:'. ($childNode->depth * 15) .'px' ?>">
    @unless($childNode->is_product)
    @if(isset($product))
    <input type="radio" value="{{ $childNode->id }}" @if($product->parent_id
    == $childNode->id)
    checked
    @endif
    name="category" />
    @else
    <input type="radio" value="{{ $childNode->id }}" name="category" />
    @endif

    <label>{{ $childNode->title }}</label>
    @else
    <span class="mr-2 mb-1 badge badge-success">{{ $childNode->title }}</span>
    @endunless
</li>
@endunless
@if ($childNode->nodes)
<ul>
    @foreach ($childNode->nodes as $childCategory)
    @if(isset($product))
    @include('admin.product.partial.select_node', ['childNode' => $childCategory, 'product' => $product])
    @else
    @include('admin.product.partial.select_node', ['childNode' => $childCategory])
    @endif
    @endforeach
</ul>
@endif