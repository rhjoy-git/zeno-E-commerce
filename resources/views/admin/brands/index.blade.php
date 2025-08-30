@extends('layouts.admin')
@section('title', 'Brands Management')
@section('content')

<div class="container mx-auto px-4 py-8" x-data="brandManagement()">
    <div class="bg-white border border-gray-200">
        <!-- Header Section -->
        <div class="bg-white p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Brands Management</h1>
                    <p class="text-gray-600 mt-1">Manage your product brands</p>
                </div>
                <button @click="showCreateModal = true"
                    class="px-5 py-2.5 bg-gray-900 text-white hover:bg-gray-800 transition-colors text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Brand
                </button>
            </div>
        </div>

        <!-- Brands Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="border-b border-gray-200">
                        <th class="w-1/4 px-6 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Logo</th>
                        <th class="w-1/4 px-6 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Name</th>                        
                        <th class="w-1/4 px-6 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($brands as $brand)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/' . $brand->brand_image) }}"
                                class="h-12 w-12 object-cover border border-gray-200" alt="{{ $brand->brand_name }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-base font-medium text-gray-900">{{ $brand->brand_name }}</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button
                                    @click="openEditModal({{ $brand->id }}, '{{ $brand->brand_name }}', '{{ asset('storage/' . $brand->brand_image) }}')"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </button>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition-colors"
                                        onclick="return confirm('Are you sure you want to delete this brand?')">
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

        @if ($brands->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $brands->links() }}
        </div>
        @endif

    </div>

    @include('admin.brands.modals.create')
    @include('admin.brands.modals.edit')
</div>

<script>
    document.addEventListener('alpine:init', () => {
            Alpine.data('brandManagement', () => ({
                showCreateModal: false,
                showEditModal: false,
                isSubmitting: false,
                errorMessage: '',
                brandForm: {
                    name: '',
                    logo: null
                },
                editForm: {
                    id: null,
                    name: '',
                    currentLogo: '',
                    newLogo: null
                },

                openEditModal(id, name, logo) {
                    this.editForm = {
                        id,
                        name,
                        currentLogo: logo,
                        newLogo: null
                    };
                    this.showEditModal = true;
                },

                async submitBrandForm() {
                    this.isSubmitting = true;
                    this.errorMessage = '';

                    try {
                        const formData = new FormData();
                        formData.append('brand_name', this.brandForm.name);
                        formData.append('brandImg', this.brandForm.logo);

                        await axios.post('{{ route('admin.brands.store') }}', formData);
                        window.location.reload();
                    } catch (error) {
                        this.handleError(error, 'Error creating brand');
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
                        formData.append('brand_name', this.editForm.name);
                        if (this.editForm.newLogo) formData.append('brandImg', this.editForm
                            .newLogo);

                        await axios.post(`/admin/brands/${this.editForm.id}`, formData);
                        window.location.reload();
                    } catch (error) {
                        this.handleError(error, 'Error updating brand');
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
</script>
@endsection