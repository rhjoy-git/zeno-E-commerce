@extends('layouts.admin')
@section('title', 'Category Management')
@section('content')


@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
    class="fixed top-4 right-4 bg-black text-white px-4 py-2 rounded shadow">
    {{ session('success') }}
</div>
@endif

<div class="container mx-auto px-4 py-6" x-data="categoryManagement()">
    <!-- Error message container -->
    <div x-show="errorMessage" x-text="errorMessage"
        class="fixed top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded shadow"
        x-init="setTimeout(() => errorMessage = '', 3000)"></div>

    <div class="bg-white overflow-hidden">
        <div class="px-6 py-4 bg-black text-white flex justify-between items-center">
            <h2 class="text-xl font-bold">Category Management</h2>
            <button @click="showCreateModal = true" class="px-4 py-2 bg-white text-black hover:bg-gray-100">
                Add Category
            </button>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-base font-medium uppercase tracking-wider">Logo</th>
                            <th class="px-6 py-3 text-left text-base font-medium uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-base font-medium uppercase tracking-wider">Parent</th>
                            <th class="px-6 py-3 text-left text-base font-medium uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-base font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('storage/' . $category->categoryImg) }}"
                                    class="h-12 w-12 rounded-full object-cover border border-gray-200"
                                    alt="{{ $category->categoryName }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-lg font-medium">{{ $category->categoryName }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-lg">
                                    {{ $category->parent ? $category->parent->categoryName : 'None' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <select class="px-4 py-1 text-sm font-semibold rounded-full focus:outline-none focus:ring 
        {{ $category->status == 'active' ? 'bg-gray-200 text-black' : 'bg-gray-100 text-black' }}"
                                    onchange="updateStatus(this.value, {{ $category->id }})">
                                    <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : ''
                                        }}>Inactive</option>
                                </select>
                            </td>


                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button
                                        @click="openEditModal({{ $category->id }}, '{{ addslashes($category->categoryName) }}', '{{ asset('storage/' . $category->categoryImg) }}', {{ $category->parent_id ?? 'null' }}, '{{ $category->status }}')"
                                        class="px-3 py-1 text-white bg-green-600 rounded-md hover:bg-green-800">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 text-white bg-red-500 rounded-md hover:bg-red-700"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
            <div class="mt-4 px-6 py-3 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
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
        formData.append('categoryName', this.categoryForm.name);
        formData.append('categoryImg', this.categoryForm.logo);
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
                    formData.append('categoryName', this.editForm.name);
                    formData.append('parent_id', this.editForm.parent_id || '');
                    formData.append('status', this.editForm.status);
                    if (this.editForm.newLogo) formData.append('categoryImg', this.editForm.newLogo);

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
            body: JSON.stringify({ status: newStatus })
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