@props(['title', 'subtitle' => null])

<div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)"
    class="min-h-screen bg-gradient-to-r from-indigo-50 via-white to-indigo-50 flex items-center justify-center py-12 px-6">
    <div x-show="show" x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
        class="w-full mx-auto max-w-md bg-white -2xl shadow-lg p-8 space-y-6 ">

        {{-- Brand Icon --}}
        <a href="https://zeno.endbrackets.com/" title="Back to Home Page" class="flex justify-center mb-6 p-3">
            <img class="h-6 w-auto" src="{{ asset('images/Zeno.png') }}" alt="Brand Logo">
        </a>

        {{-- Title and Subtitle --}}
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">
                {{ $title }}
            </h2>
            @isset($subtitle)
            <p class="mt-2 text-sm text-gray-500">
                {{ $subtitle }}
            </p>
            @endisset
        </div>

        <div>
            {{ $slot }}
        </div>
    </div>

</div>