@extends('layouts.admin')
@section('title', 'Create New Product')
@section('content')

    <div class="container mx-auto px-4 py-6">
        <div class="bg-white  shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Add New Product</h2>
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Products
                </a>
            </div>

            {{-- Flash Message --}}
            @php
                $flashType = session('success') ? 'success' : (session('error') ? 'error' : null);
                $flashMessage = session('success') ?? session('error');
            @endphp

            @if ($flashType && $flashMessage)
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                    class="px-4 py-3 mb-4 transition duration-500
           {{ $flashType === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200' }}">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $flashMessage }}
                    </div>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="px-4 py-3 mb-4 bg-red-50 text-red-800 border border-red-200">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                                clip-rule="evenodd" />
                        </svg>
                        <h3 class="font-medium">Please fix the following errors:</h3>
                    </div>
                    <ul class="mt-2 pl-5 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="productForm" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
                class="space-y-8 divide-y divide-gray-200">
                @csrf

                <!-- Basic Information Section -->
                <div class="pt-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold leading-6 text-gray-900">Basic Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Essential details about your product.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-12">
                        <!-- Category -->
                        <div class="sm:col-span-2">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <div class="mt-1">
                                <select id="category_id" name="category_id"
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Brand -->
                        <div class="sm:col-span-2">
                            <label for="brand_id" class="block text-sm font-medium text-gray-700">Brand</label>
                            <div class="mt-1">
                                <select id="brand_id" name="brand_id"
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="sm:col-span-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Product Title <span
                                    class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" id="title" value="{{ old('title') }}" name="title"
                                    placeholder="Enter product title" required
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <p id="title-error" class="mt-1 text-sm text-red-600 hidden"></p>
                        </div>

                        <!-- SKU -->
                        <div class="sm:col-span-4">
                            <label for="sku" class="block text-sm font-medium text-gray-700">SKU <span
                                    class="text-red-500">*</span></label>
                            <div class="mt-1 flex ">
                                <input type="text" id="sku" name="sku" value="{{ old('sku') }}" required
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                <button type="button" id="generateSKU"
                                    class="inline-flex items-center border border-l-0 border-gray-300 bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                    Generate
                                </button>
                            </div>
                            <p id="sku-error" class="mt-1 text-sm text-red-600 hidden"></p>
                        </div>

                        <!-- Price -->
                        <div class="sm:col-span-2">
                            <label for="price" class="block text-sm font-medium text-gray-700">Base Price <span
                                    class="text-red-500">*</span></label>
                            <div class="mt-1 relative ">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">৳</span>
                                </div>
                                <input type="text" step="0.01" min="0" id="price" name="price"
                                    value="{{ old('price') }}" required
                                    class="block w-full pl-7 pr-12 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">BDT</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Quantity -->
                        <div class="sm:col-span-2">
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock
                                Quantity</label>
                            <div class="mt-1 relative ">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">PCS</span>
                                </div>
                                <input type="text" min="0" id="stock_quantity" name="stock_quantity"
                                    value="{{ old('stock_quantity') }}"
                                    class="block w-full pl-10 pr-4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Stock Alert -->
                        <div class="sm:col-span-2">
                            <label for="stock_alert" class="block text-sm font-medium text-gray-700">Low Stock
                                Alert</label>
                            <div class="mt-1 relative ">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">PCS</span>
                                </div>
                                <input type="text" min="0" id="stock_alert" name="stock_alert"
                                    value="{{ old('stock_alert') }}" placeholder="Ex: 50"
                                    class="block w-full pl-10 pr-4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Product Tags -->
                        <!-- Product Tags with Alpine.js -->
                        <div class="sm:col-span-4" x-data="tagSelect()" x-init="init()">
                            <label class="block text-sm font-medium text-gray-700">Product Tags</label>
                            <div class="mt-1 relative">
                                <div @click.away="closeSuggestions()" @keydown.escape="closeSuggestions()"
                                    class="flex flex-wrap items-center gap-2 p-2 min-h-10 border border-gray-300"
                                    :class="{ 'border-indigo-500 ring-1 ring-indigo-500': showSuggestions }">
                                    <!-- Selected Tags -->
                                    <template x-for="(tag, index) in selectedTags" :key="tag.id">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <span x-text="tag.name"></span>
                                            <input type="hidden" name="tags[]" :value="tag.id">
                                            <button type="button" @click="removeTag(index)"
                                                class="ml-1.5 inline-flex text-indigo-600 hover:text-indigo-900">
                                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <!-- Tag Input -->
                                    <input x-model="searchTerm" @input="filterTags()" @focus="showSuggestions = true"
                                        type="text" class="flex-1 min-w-0 border-0 focus:ring-0 p-0 text-sm"
                                        placeholder="Type to filter tags" autocomplete="off">
                                </div>

                                <!-- Tag Suggestions -->
                                <div x-show="showSuggestions" x-transition
                                    class="absolute z-10 mt-1 w-full bg-white border border-gray-300 py-1 overflow-auto max-h-60">
                                    <template x-for="tag in filteredTags" :key="tag.id">
                                        <div @click="addTag(tag)"
                                            class="cursor-default select-none py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white">
                                            <div class="flex items-center">
                                                <span class="ml-3 block font-normal truncate" x-text="tag.name"></span>
                                            </div>
                                        </div>
                                    </template>
                                    <div x-show="filteredTags.length === 0" class="py-2 pl-3 pr-9 text-gray-500">
                                        No matching tags
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product Tags -->
                        <div class="sm:col-span-4">
                            <label class="block text-sm font-medium text-gray-700">Product Tags</label>
                            <div class="mt-1 relative">
                                <div id="tag-container"
                                    class="flex flex-wrap items-center gap-2 p-2 min-h-10 border border-gray-300">
                                    <!-- Selected tags will appear here -->
                                    @foreach (old('tags', []) as $selectedTagId)
                                        @php $selectedTag = $tags->firstWhere('id', $selectedTagId); @endphp
                                        @if ($selectedTag)
                                            <span
                                                class="tag-chip inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $selectedTag->name }}
                                                <input type="hidden" name="tags[]" value="{{ $selectedTag->id }}">
                                                <button type="button"
                                                    class="ml-1.5 inline-flex text-indigo-600 hover:text-indigo-900">
                                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        @endif
                                    @endforeach
                                    <input id="tag-input" type="text"
                                        class="flex-1 min-w-0 border-0 focus:ring-0 p-0 text-sm"
                                        placeholder="Type to filter tags" autocomplete="off">
                                </div>
                                <div id="tag-suggestions"
                                    class="absolute z-10 mt-1 w-full bg-white border border-gray-300 py-1 overflow-auto max-h-60 hidden">
                                    <!-- All tags will appear here dynamically -->
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="sm:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <div class="mt-1">
                                <select id="status" name="status"
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Has Variants -->
                        <div class="sm:col-span-12">
                            <div class="flex items-center">
                                <label for="has_variants" class="mr-2 block text-sm font-medium text-gray-700">This
                                    product has variants</label>
                                <input type="checkbox" id="has_variants" name="has_variants"
                                    class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Short Description -->
                        <div class="sm:col-span-6">
                            <label for="short_des" class="block text-sm font-medium text-gray-700">Short
                                Description</label>
                            <div class="mt-1">
                                <textarea id="short_des" name="short_des" rows="9" maxlength="500"
                                    placeholder="Enter a brief description (max 500 characters)"
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('short_des') }}</textarea>
                            </div>
                        </div>

                        <!-- Image Upload Box -->
                        <div class="sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>

                            <!-- Clickable Upload Area -->
                            <div id="image-upload-container" class="relative group cursor-pointer">
                                <!-- Upload Box (shown when no image) -->
                                <div id="upload-box"
                                    class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 transition-colors {{ old('primary_image') ? 'hidden' : '' }}">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="mt-2 text-sm text-center">
                                        <p class="font-medium text-indigo-600 group-hover:text-indigo-500">Click to upload
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 1MB</p>
                                    </div>
                                    <input id="primary_image" name="primary_image" type="file"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                </div>

                                <!-- Image Preview (shown when image exists) -->
                                <div id="image-preview-container"
                                    class="relative h-48 overflow-hidden bg-gray-100 {{ old('primary_image') ? '' : 'hidden' }}">
                                    <img id="image-preview"
                                        src="{{ old('primary_image') ? URL::temporaryUrl(Storage::path(old('primary_image')), now()->addMinutes(5)) : '' }}"
                                        alt="Preview" class="w-full h-full object-contain">

                                    <!-- Remove Button -->
                                    <div
                                        class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                        <button type="button" id="remove-image-btn"
                                            class="w-full py-1.5 px-3 bg-white/90 text-sm font-medium text-gray-800 hover:bg-white transition-colors flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Remove Image
                                        </button>
                                    </div>
                                </div>

                                <!-- Error Message -->
                                <p id="image-error" class="mt-1 text-sm text-red-600 hidden"></p>
                            </div>
                        </div>

                    </div>

                    <!-- Form Actions -->
                    <div class="pt-8">
                        <div class="flex justify-end space-x-3">
                            <button type="button" id="cancelBtn"
                                class="border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Cancel
                            </button>
                            <button type="submit" id="submitBtn"
                                class="inline-flex justify-center border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save Product
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Generate SKU
            const generateSKUBtn = document.getElementById('generateSKU');
            if (generateSKUBtn) {
                generateSKUBtn.addEventListener('click', function() {
                    // Your SKU generation logic here
                    const randomSKU = 'PROD-' + Math.floor(1000 + Math.random() * 9000);
                    document.getElementById('sku').value = randomSKU;
                });
            }

            // Cancel button
            const cancelBtn = document.getElementById('cancelBtn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    window.location.href = "{{ route('admin.products.index') }}";
                });
            }
        });
    </script>

    {{-- Product Tags --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagContainer = document.getElementById('tag-container');
            const tagInput = document.getElementById('tag-input');
            const tagSuggestions = document.getElementById('tag-suggestions');
            const allTags = {!! json_encode($tags->map(fn($tag) => ['id' => $tag->id, 'name' => $tag->name])) !!};
            let selectedTagIds = new Set(@json(old('tags', [])));

            // Initialize the component
            function init() {
                renderSelectedTags();
                renderSuggestions('');
                setupEventListeners();
            }

            // Set up event listeners
            function setupEventListeners() {
                tagInput.addEventListener('input', handleInput);
                tagInput.addEventListener('focus', showSuggestions);
                document.addEventListener('click', handleClickOutside);
                tagInput.addEventListener('keydown', handleKeyDown);
            }

            // Handle input changes
            function handleInput(e) {
                renderSuggestions(e.target.value);
            }

            // Show suggestions dropdown
            function showSuggestions() {
                tagSuggestions.classList.remove('hidden');
            }

            // Hide suggestions dropdown
            function hideSuggestions() {
                tagSuggestions.classList.add('hidden');
            }

            // Handle clicks outside the component
            function handleClickOutside(e) {
                if (!tagContainer.contains(e.target)) {
                    hideSuggestions();
                }
            }

            // Handle keyboard events
            function handleKeyDown(e) {
                if (e.key === 'Escape') {
                    hideSuggestions();
                }
            }

            // Render selected tags
            function renderSelectedTags() {
                // Clear existing tags (except the input)
                const existingTags = tagContainer.querySelectorAll('.tag-chip');
                existingTags.forEach(tag => {
                    if (!tag.contains(tagInput)) {
                        tagContainer.removeChild(tag);
                    }
                });

                // Add selected tags
                selectedTagIds.forEach(tagId => {
                    const tag = allTags.find(t => t.id == tagId);
                    if (tag) {
                        addTagToContainer(tag);
                    }
                });
            }

            // Add a tag to the container
            function addTagToContainer(tag) {
                const tagElement = document.createElement('span');
                tagElement.className =
                    'tag-chip inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-800';
                tagElement.innerHTML = `
            ${tag.name}
            <input type="hidden" name="tags[]" value="${tag.id}">
            <button type="button" class="ml-1.5 inline-flex text-indigo-600 hover:text-indigo-900">
                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        `;

                // Add remove event
                const removeBtn = tagElement.querySelector('button');
                removeBtn.addEventListener('click', () => removeTag(tag.id));

                // Insert before the input
                tagContainer.insertBefore(tagElement, tagInput);
            }

            // Render suggestions
            function renderSuggestions(searchTerm = '') {
                const term = searchTerm.toLowerCase();
                const suggestions = allTags.filter(tag =>
                    !selectedTagIds.has(tag.id) &&
                    tag.name.toLowerCase().includes(term)
                );

                tagSuggestions.innerHTML = '';

                if (suggestions.length === 0) {
                    const noResults = document.createElement('div');
                    noResults.className = 'py-2 pl-3 pr-9 text-gray-500';
                    noResults.textContent = 'No matching tags';
                    tagSuggestions.appendChild(noResults);
                } else {
                    suggestions.forEach(tag => {
                        const suggestion = document.createElement('div');
                        suggestion.className =
                            'cursor-default select-none py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white';
                        suggestion.innerHTML = `
                    <div class="flex items-center">
                        <span class="ml-3 block font-normal truncate">${tag.name}</span>
                    </div>
                `;
                        suggestion.addEventListener('click', () => selectTag(tag));
                        tagSuggestions.appendChild(suggestion);
                    });
                }
            }

            // Select a tag
            function selectTag(tag) {
                selectedTagIds.add(tag.id);
                renderSelectedTags();
                tagInput.value = '';
                renderSuggestions('');
                tagInput.focus();
            }

            // Remove a tag
            function removeTag(tagId) {
                selectedTagIds.delete(tagId);
                renderSelectedTags();
                renderSuggestions(tagInput.value);
            }

            // Initialize the component
            init();
        });
    </script>



    {{-- Product Image --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('primary_image');
            const imagePreview = document.getElementById('image-preview');
            const imagePreviewContainer = document.getElementById('image-preview-container');
            const uploadBox = document.getElementById('upload-box');
            const removeImageBtn = document.getElementById('remove-image-btn');
            const imageError = document.getElementById('image-error');
            const MAX_FILE_SIZE = 1 * 1024 * 1024; // 1MB in bytes

            // Handle image selection
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (!file) return;

                // Validate file size
                if (file.size > MAX_FILE_SIZE) {
                    imageError.textContent = 'Image size must be less than 1MB';
                    imageError.classList.remove('hidden');
                    imageInput.value = ''; // Clear the input
                    return;
                } else {
                    imageError.classList.add('hidden');
                }

                // Validate file type
                if (!file.type.match('image.*')) {
                    imageError.textContent = 'Please select an image file (JPEG, PNG, GIF)';
                    imageError.classList.remove('hidden');
                    imageInput.value = ''; // Clear the input
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.classList.remove('hidden');
                    uploadBox.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            });

            // Handle image removal
            removeImageBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent triggering the container click
                resetImageUpload();
            });

            // Clicking anywhere on preview container opens file dialog
            imagePreviewContainer.addEventListener('click', function() {
                imageInput.click();
            });

            // Reset image upload state
            function resetImageUpload() {
                imagePreview.src = '';
                imageInput.value = '';
                imagePreviewContainer.classList.add('hidden');
                uploadBox.classList.remove('hidden');
                imageError.classList.add('hidden');
            }

            // Handle drag and drop
            uploadBox.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-indigo-500', 'bg-gray-100');
                this.classList.remove('border-gray-300');
            });

            uploadBox.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('border-indigo-500', 'bg-gray-100');
                this.classList.add('border-gray-300');
            });

            uploadBox.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-indigo-500', 'bg-gray-100');
                this.classList.add('border-gray-300');

                if (e.dataTransfer.files.length) {
                    imageInput.files = e.dataTransfer.files;
                    const event = new Event('change');
                    imageInput.dispatchEvent(event);
                }
            });
        });
    </script>
@endsection
