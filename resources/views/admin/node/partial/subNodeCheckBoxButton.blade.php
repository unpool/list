@unless($childNode->is_product)
<li style="<?php echo 'margin-right:'. ($childNode->depth * 15) .'px' ?>">
    @unless($childNode->is_product)
    @if(isset($mustBeCheck))
    <input type="checkbox" value="{{ $childNode->id }}" @if(in_array($childNode->id,$mustBeCheck)) checked @endif
    name="category[]"
    />
    @else
    <input type="checkbox" value="{{ $childNode->id }}" name="category[]" />
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
    @if(isset($mustBeCheck))
    @include('admin.node.partial.subNodeCheckBoxButton', ['childNode' => $childCategory, 'mustBeCheck' => $mustBeCheck])
    @else
    @include('admin.node.partial.subNodeCheckBoxButton', ['childNode' => $childCategory])
    @endif
    @endforeach
</ul>
@endif