@props(['type' => 'submit'])

<button 
    type="{{ $type }}" 
    @class([
        'w-full flex justify-center py-2 px-4 border border-transparent -md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
        $attributes->get('class')
    ])
>
    {{ $slot }}
</button>