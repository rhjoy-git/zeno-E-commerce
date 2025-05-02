<div id="preloader" class="preloader">
    <div class="flex flex-col items-center space-y-4">
        <!-- Your logo -->
        <div class="w-24 h-24">
            <x-application-logo alt="Logo" class="w-full h-full object-contain animate-pulse" />
        </div>

        <!-- Animated spinner -->
        <div class="relative w-12 h-12">
            <div class="absolute inset-0 border-4 border-blue-200 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-transparent border-t-blue-500 rounded-full animate-spin"></div>
        </div>

        <!-- Progress bar -->
        <div class="w-64 bg-gray-200 rounded-full h-2.5">
            <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
        </div>

        <!-- Loading text -->
        <p class="text-gray-600 font-medium">Loading...</p>
    </div>
</div>