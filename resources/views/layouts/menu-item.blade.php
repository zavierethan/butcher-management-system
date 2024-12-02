@foreach ($menuTree as $menu)
    <li>
        <a href="{{ $menu->url }}">
            @if ($menu->icon)
                <i class="{{ $menu->icon }}"></i>
            @endif
            {{ $menu->name }}
        </a>

        @if (!empty($menu->children))
            <ul class="submenu">
                @include('layouts.menu-item', ['menuTree' => $menu->children])
            </ul>
        @endif
    </li>
@endforeach
