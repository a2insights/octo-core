<section>
    <div class="bg-gradient-to-br pb-20 from-indigo-900 to-green-900 min-h-screen overflow-auto">
        <div class="container max-w-5xl mx-auto px-4">
            <div class="w-4/5">
                <h1 class="mt-20 text-white text-6xl font-bold">
                    {{ $headline }}
                </h1>
            </div>
            <div class="w-5/6 my-10 ml-6">
                <h3 class="text-gray-300">
                    {{ $description }}
                </h3>
            </div>
            <div class="hidden sm:block opacity-50 z-0">
                <div class="shadow-2xl w-96 h-96 rounded-full -mt-72"></div>
                <div class="shadow-2xl w-96 h-96 rounded-full -mt-96"></div>
                <div class="shadow-xl w-80 h-80 rounded-full ml-8 -mt-96"></div>
            </div>
            <div class="text-white relative">
                {{ $footer }}
            </div>
        </div>
    </div>
</section>
