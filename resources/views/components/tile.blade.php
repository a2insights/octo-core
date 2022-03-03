@props(['title' => '', 'description' => ''])

<div
    class="group flex items-center bg-indigo-900 bg-opacity-40 shadow-xl gap-5 px-6 py-5 rounded-lg ring-2 ring-offset-2 ring-offset-blue-800 ring-cyan-700 mt-5 cursor-pointer hover:bg-blue-900 hover:bg-opacity-100 transition">
    {{ $slot }}
    <div>
        <span>{{ $title }}</span>
        <span class="text-xs text-blue-300 block">{{ $description }}</span>
    </div>
</div>
