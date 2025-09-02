@extends('layouts.app')
@section('title', 'Page Not Found')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center flex flex-col items-center">
    <!-- GIF with text overlay -->
    <div class="relative w-full max-w-3xl">
        <img src="https://cdn.dribbble.com/userupload/20420676/file/original-aac8f7f838812fa53cd92617fad5f892.gif"
            alt="Confused animation" class="mx-auto rounded-lg w-[500px] h-auto opacity-90" />
        <div class="absolute inset-0 flex items-start justify-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800">Sorry! I am under Construction.</h1>
        </div>
    </div>
    <p class="py-2 text-red-600 text-lg mb-4">{{ $exception->getMessage() }}</p>
    <!-- Button -->
    <a href="{{ url('/') }}"
        class="bg-black text-white px-10 py-3 text-xl transition-colors tracking-[2px] font-semibold uppercase inline-block">
        take me home
    </a>
</div>
@endsection