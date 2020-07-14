<div class="collapse navbar-collapse justify-content-end">
    <ul class="navbar-nav">
        @foreach($items as $item)
            @isset($item->children)
                <li class="nav-item dropdown">
                    <a
                        class="nav-link"
                        href="{{ $item->url ?? route($item->route) }}"
                        id="{{ $item->url ?? route($item->route) }}"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <i class="material-icons">{{ $item->icon }}</i>
                        @isset($item->notification)
                            <span class="notification">{{ $item->notification->count }}</span>
                        @endisset
                        <p class="d-lg-none d-md-block">
                            {{ $item->label }}
                        </p>
                        <div class="ripple-container"></div>
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-right"
                        aria-labelledby="{{ $item->url ?? route($child->route) }}"
                    >
                        @foreach($item->children as $child)
                            @isset($child->action)
                                <a
                                    class="dropdown-item {{ $isActive($child) ? 'active' : '' }}"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('{{ $child->route }}-form').submit();">
                                    {{ __($child->label) }}
                                </a>
                                <form id="{{ $child->route }}-form" action="{{ route($child->route) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endisset
                            @empty($child->action)
                                <a
                                    class="dropdown-item {{ $isActive($child) ? 'active' : '' }}"
                                    href="{{ $child->url ?? route($child->route)}}">{{ $child->label }}
                                </a>
                            @endempty
                        @endforeach
                    </div>
                </li>
            @endisset
            @empty($item->children)
                <li class="nav-item">
                    <a class="nav-link" href="javascript:;">
                        <i class="material-icons">{{ $item->icon }}</i>
                        <p class="d-lg-none d-md-block">
                            {{ $item->label }}
                        </p>
                    </a>
                </li>
            @endempty
        @endforeach
    </ul>
</div>
