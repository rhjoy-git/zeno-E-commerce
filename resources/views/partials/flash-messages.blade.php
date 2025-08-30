<div class="fixed top-20 right-4 z-[9999] space-y-3 w-80 max-w-[90vw]">

    @if (session('status'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 shadow-lg rounded-lg animate-slide-in">
        <p class="text-green-700">{{ session('status') }}</p>
    </div>
    @endif

    @if (session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 shadow-lg rounded-lg animate-slide-in">
        <p class="text-green-700">{{ session('success') }}</p>
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 shadow-lg rounded-lg animate-slide-in">
        <p class="text-red-700">{{ session('error') }}</p>
    </div>
    @endif

    @if (session('warning'))
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 shadow-lg rounded-lg animate-slide-in">
        <p class="text-yellow-700">{{ session('warning') }}</p>
    </div>
    @endif

    @if (session('info'))
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 shadow-lg rounded-lg animate-slide-in">
        <p class="text-blue-700">{{ session('info') }}</p>
    </div>
    @endif
    
</div>

<style>
    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .animate-slide-in {
        animation: slide-in 0.4s ease-out;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            document.querySelectorAll('.animate-slide-in').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 4000); 
    });
</script>