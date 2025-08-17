@extends('layouts.admin')
@section('title', 'Manage Variants - ' . $product->title)

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Manage Variants - {{ $product->title }}</h2>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.products.index') }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Back to Products
                    </a>
                    <a href="{{ route('admin.products.variants.create', $product) }}"
                        class="px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700">
                        Add New Variant
                    </a>
                </div>
            </div>

            @if ($variants->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">No variants found for this product.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Color</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Size</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SKU</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($variants as $variant)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($variant->color)
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full"
                                                    style="background-color: {{ $variant->color->hex_code }}"></div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $variant->color->name }}</div>
                                                </div>
                                            @else
                                                <span class="text-gray-500">N/A</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($variant->size)
                                            <span class="text-sm text-gray-900">{{ $variant->size->name }}</span>
                                        @else
                                            <span class="text-gray-500">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($variant->price, 2) }}৳
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $variant->stock_quantity <= $variant->stock_alert ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $variant->stock_quantity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $variant->sku ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.products.variants.edit', [$product, $variant]) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form
                                                action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}"
                                                method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
