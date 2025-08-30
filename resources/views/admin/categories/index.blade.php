@extends('layouts.admin')
@section('title', 'Category Management')
@section('content')

<div class="container mx-auto px-4 py-8" x-data="categoryManagement()">

    <div class="bg-white border border-gray-200">
        <!-- Header Section -->
        <div class="bg-white p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Category Management</h1>
                    <p class="text-gray-600 mt-1">Manage your product categories</p>
                </div>
                <button @click="showCreateModal = true"
                    class="px-5 py-2.5 bg-gray-900 text-white hover:bg-gray-800 transition-colors text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Category
                </button>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="border-b border-gray-200">
                        <th class="w-1/4 px-6 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Logo
                        </th>
                        <th class="w-1/4 px-6 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Name
                        </th>
                        <th class="w-1/4 px-6 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Parent</th>
                        <th class="w-1/4 px-6 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Status</th>
                        <th class="w-1/4 px-6 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/' . $category->category_image) }}"
                                class="h-12 w-12 object-cover border border-gray-200"
                                alt="{{ $category->category_name }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-base font-medium text-gray-900">{{ $category->category_name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-base text-gray-700">
                                {{ $category->parent ? $category->parent->category_name : '—' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select
                                class="px-5 py-1.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-gray-300 border border-gray-300
                                            {{ $category->status == 'active' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-700' }}"
                                onchange="updateStatus(this.value, {{ $category->id }})">
                                <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button
                                    @click="openEditModal({{ $category->id }}, '{{ addslashes($category->category_name) }}', '{{ asset('storage/' . $category->category_image) }}', {{ $category->parent_id ?? 'null' }}, '{{ $category->status }}')"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition-colors"
                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $categories->links() }}
        </div>
        @endif
    </div>

    @include('admin.categories.modals.create')
    @include('admin.categories.modals.edit')
</div>

<script>
    const categoryStoreURL = @json(route('admin.categories.store'));
        document.addEventListener('alpine:init', () => {
            Alpine.data('categoryManagement', () => ({
                showCreateModal: false,
                showEditModal: false,
                isSubmitting: false,
                errorMessage: '',
                categoryForm: {
                    name: '',
                    logo: null,
                    parent_id: '',
                    status: 'active'
                },
                editForm: {
                    id: null,
                    name: '',
                    currentLogo: '',
                    newLogo: null,
                    parent_id: null,
                    status: 'active'
                },

                openEditModal(id, name, logo, parentId, status) {
                    console.log('Opening edit modal for ID:', id, name, logo, parentId, status);
                    this.editForm = {
                        id,
                        name,
                        currentLogo: logo,
                        newLogo: null,
                        parent_id: parentId,
                        status
                    };
                    this.showEditModal = true;
                },

                async submitCategoryForm() {
                    this.isSubmitting = true;
                    this.errorMessage = '';

                    try {
                        const formData = new FormData();
                        formData.append('category_name', this.categoryForm.name);
                        formData.append('category_image', this.categoryForm.logo);
                        formData.append('parent_id', this.categoryForm.parent_id || '');
                        formData.append('status', this.categoryForm.status);

                        await axios.post(categoryStoreURL, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                        window.location.reload();
                    } catch (error) {
                        this.handleError(error, 'Error creating category');
                    } finally {
                        this.isSubmitting = false;
                    }
                },
                async submitEditForm() {
                    this.isSubmitting = true;
                    this.errorMessage = '';

                    try {
                        const formData = new FormData();
                        formData.append('_method', 'PUT');
                        formData.append('category_name', this.editForm.name);
                        formData.append('parent_id', this.editForm.parent_id || '');
                        formData.append('status', this.editForm.status);
                        if (this.editForm.newLogo) formData.append('category_image', this.editForm
                            .newLogo);

                        await axios.post(`/admin/categories/${this.editForm.id}`, formData);
                        window.location.reload();
                    } catch (error) {
                        this.handleError(error, 'Error updating category');
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                handleError(error, defaultMessage) {
                    let errorMessage = defaultMessage;

                    if (error.response) {
                        if (error.response.data && error.response.data.message) {
                            errorMessage = error.response.data.message;
                        } else if (error.response.status === 422) {
                            errorMessage = 'Validation error: ' +
                                Object.values(error.response.data.errors).flat().join(', ');
                        }
                    } else if (error.request) {
                        errorMessage = 'No response received from server';
                    }

                    this.errorMessage = errorMessage;
                }
            }));
        });

        function updateStatus(newStatus, categoryId) {
            fetch(`/admin/categories/${categoryId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        alert('Failed to update status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong.');
                });
        }
</script>
@endsection