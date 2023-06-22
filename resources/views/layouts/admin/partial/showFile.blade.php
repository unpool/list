@php
    $type = explode('/', $file->file_type);

@endphp

@switch($type[0])

    @case('image')
        <img src="{{ url('storage/'.$file->address) }}"/>
    @break

    @default
        <a class="btn" href="{{ url('storage/'.$file->address) }}">دانلود فایل</a>
    @break

@endswitch

