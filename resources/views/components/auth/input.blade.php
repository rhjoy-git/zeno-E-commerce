@props([
'name',
'type' => 'text',
'label' => null,
'placeholder' => null,
'value' => '',
'required' => false,
'id' => null,
'class' => '',
'autocomplete' => false,
'disabled' => false,
'readonly' => false,
'autofocus' => false
])

@php
$id = $id ?? $name;
@endphp

<div class="mb-5">
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
        @if($required) <span class="text-red-500">*</span> @endif
    </label>
    @endif

    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }} {{ $autocomplete ? 'autocomplete' : '' }} {{
        $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} {{ $autofocus ? 'autofocus' : '' }}
        @class([ 'block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150'
        , 'border-red-300 text-red-900 placeholder-red-300'=> $errors->has($name),
    $class
    ])
    >

    @error($name)
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>