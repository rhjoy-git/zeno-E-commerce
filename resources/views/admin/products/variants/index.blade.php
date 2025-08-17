@extends('layouts.admin')
@section('title', 'Manage Variants - ' . $product->title)
@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Manage Variants</h1>
                    <p class="text-gray-600">Product: {{ $product->title }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.products.index') }}"
                        class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors text-base">
                        Back to Products
                    </a>
                    <a href="{{ route('admin.products.variants.create', $product) }}"
                        class="px-4 py-2 bg-black text-white hover:bg-gray-800 transition-colors text-base">
                        Add New Variant
                    </a>
                </div>
            </div>

            @if ($variants->isEmpty())
                <div class="bg-white border border-gray-200 p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No variants found</h3>
                    <p class="mt-1 text-gray-500">This product doesn't have any variants yet.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.products.variants.create', $product) }}"
                            class="inline-flex items-center px-4 py-2 bg-black text-white hover:bg-gray-800 transition-colors text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add New Variant
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Color</th>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Size</th>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Stock</th>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        SKU</th>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($variants as $variant)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($variant->color)
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-6 w-6 rounded-full border border-gray-300"
                                                        style="background-color: {{ $variant->color->hex_code }}"></div>
                                                    <div class="ml-2 text-base text-gray-900">{{ $variant->color->name }}
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-base text-gray-500">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                            {{ $variant->size->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                            {{ number_format($variant->price, 2) }}৳
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap" x-data="stockModal({{ $variant->id }}, {{ $variant->stock_quantity }})">
                                            <button type="button" class="w-full text-left focus:outline-none"
                                                @click="open = true">
                                                <div class="text-base">
                                                    <span
                                                        class="px-2 py-1 inline-flex text-sm font-medium rounded-full {{ $variant->stock_quantity <= ($variant->stock_alert ?? 5) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                        {{ $variant->stock_quantity }}
                                                    </span>
                                                </div>
                                            </button>

                                            <!-- Modal -->
                                            <div x-show="open" style="display: none;"
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                                x-transition>
                                                <div class="bg-white p-6 w-80" @click.away="open = false">
                                                    <h2 class="text-lg font-semibold mb-4">Update Stock Quantity</h2>
                                                    <form @submit.prevent="submit">
                                                        <input type="number" x-model="newQty"
                                                            class="w-full px-3 py-2 text-base font-medium border border-gray-300 focus:outline-none focus:ring focus:border-black"
                                                            min="0" required>
                                                        <div class="mt-4 flex justify-end space-x-2">
                                                            <button type="button" @click="open = false"
                                                                class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="px-6 py-2 bg-black text-white"
                                                                :disabled="isSubmitting"
                                                                :class="isSubmitting ? 'opacity-50 cursor-not-allowed' : ''">
                                                                <span x-show="isSubmitting"
                                                                    class="animate-spin mr-1 inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
                                                                <span x-show="!isSubmitting">Save</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                            {{ $variant->sku ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 inline-flex text-sm font-medium rounded-full {{ $variant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($variant->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('admin.products.variants.edit', [$product, $variant]) }}"
                                                    class="text-blue-600 hover:text-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form
                                                    action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Are you sure you want to delete this variant?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function stockModal(variantId, initialQty) {
            return {
                open: false,
                newQty: initialQty,
                isSubmitting: false,
                submit() {
                    this.isSubmitting = true;
                    fetch(`/admin/products/variants/${variantId}/update-stock`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                stock_quantity: this.newQty
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Update failed.');
                                this.isSubmitting = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Something went wrong.');
                            this.isSubmitting = false;
                        });
                }
            }
        }
    </script>
@endsection
