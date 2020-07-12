<div class="sidebar-wrapper">
    <ul class="nav">
        @foreach($items as $item)
            @empty($item->children)
                <li class="nav-item @isset($item->route) {{ route($item->route) === url()->current() ? 'active' : ''   }} @endisset">
                    <a class="nav-link" href=" @isset($item->route) {{ route($item->route)  }} @endisset @empty($item->route) {{ $item->url }} @endempty">
                        <i class="material-icons">{{ $item->icon ??  '' }}</i>
                        <p>{{ $item->label }}</p>
                    </a>
                </li>
            @endempty
        @endforeach    
    </ul>
</div>
