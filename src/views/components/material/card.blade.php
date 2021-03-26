<div class="card">
    <div class="card-header card-header-{{ $variant }}">
    <h4 class="card-title ">{{ $title }}</h4>
        <p class="card-category"> {{ $description }}</p>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
