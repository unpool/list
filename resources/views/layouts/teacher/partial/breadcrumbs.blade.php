<div class="col-sm-8">
    <ol class="breadcrumb float-sm-left">
        @if(isset($breadcrumbs))
            @foreach($breadcrumbs as $item)
                @if(end($breadcrumbs) === $item)
                    <li class="breadcrumb-item active"> {{ $item['name'] }} </li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $item['link'] }}">{{ $item['name'] }}</a>
                    </li>
                @endif
            @endforeach
        @endif
    </ol>
</div>