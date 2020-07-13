<div class="card card-stats">
    <div class="card-header card-header-{{ $variant }} card-header-icon">
        <div class="card-icon">
            <i class="material-icons">{{ $icon }}</i>
        </div>
        <p class="card-category">{{ $title }}</p>
        <h3 class="card-title">{{ $count }}
        </h3>
    </div>
    <div class="card-footer">
        @isset($stats->route)
            <div class="stats">
                <i class="material-icons text-danger">warning</i>
                <a href="{{ $isStats() ? '#' : route($stats->route) }}">{{ $stats->description }}</a>
            </div>
        @endisset
        @empty($stats->route)
            <div class="stats">
                {{ $stats->description }}
            </div>
        @endempty
    </div>
</div>
