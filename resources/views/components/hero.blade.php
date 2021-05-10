@props(['footer' => ''])

<section>
    <div class="bg-gradient-to-br pb-10 from-indigo-900 to-green-900 overflow-auto">
        <div class="container max-w-5xl mx-auto px-4">
            <h1 class="mt-10 text-white text-5xl font-bold">
                {{ $headline }}
            </h1>
            <div class="my-5 ml-6">
                <h3 class="text-gray-300">
                    {{ $tagline }}
                </h3>
            </div>
            <div class="text-white relative">
                {{ $footer }}
            </div>
        </div>
    </div>
</section>
