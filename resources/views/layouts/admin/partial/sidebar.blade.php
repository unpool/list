<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <small class="brand-text font-weight-light">نام مدیر سایت</small>
    </a>
    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    @foreach($sidebar as $item)

                        @if( isset($item['child']) && count($item['child']) )
                            <li class="nav-item has-treeview @if($item['is_active'])menu-open @endif">
                                <a href="#" class="nav-link @if($item['is_active'])active @endif">
                                    {!! $item['icon'] ?? '' !!}
                                    <p>
                                        {{ $item['name'] ?? '' }}
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview mx-2">
                                    @foreach($item['child'] as $child)
                                        <li class="nav-item">
                                            <a href="{{ $child['link'] ?? '' }}"
                                               class="nav-link @if($child['is_active'])active @endif">
                                                {!! $child['icon'] ?? ''  !!}
                                                <p>{{ $child['name'] ?? '' }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ $item['link'] ?? ''}}"
                                   class="nav-link @if($item['is_active'])active @endif">
                                    {!! $item['icon'] ?? '' !!}
                                    <p>
                                        {{ $item['name'] ?? '' }}
                                    </p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</aside>