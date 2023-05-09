@if($logo)
    <a
        href="/"
        rel="noopener noreferrer"
        class="text-gray-300 hover:text-primary-500 transition"
    >
        <img src={{Storage::url($logo)}} alt="Logo"   class="fill-current w-24">
    </a>
@endif
