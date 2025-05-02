@extends('layouts.admin')
@section('title', 'Brands Management')
@section('content')

@include('admin.partials.bashboard-header')

<div class="container mx-auto px-4 py-6" x-data="brandManagement()">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white flex justify-between items-center">
            <h2 class="text-xl font-bold">Brands Management</h2>
            <button @click="showCreateModal = true"
                class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition-all duration-200 flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Add Brand</span>
            </button>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Logo</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Products</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($brands as $brand)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('storage/' . $brand->brandImg) }}"
                                    class="h-12 w-12 rounded-full object-cover border border-gray-200"
                                    alt="{{ $brand->brandName }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $brand->brandName }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button
                                        @click="openEditModal({{ $brand->id }}, '{{ $brand->brandName }}', '{{ asset('storage/' . $brand->brandImg) }}')"
                                        class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-md hover:bg-yellow-200 transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors duration-200"
                                            onclick="return confirm('Are you sure you want to delete this brand?')">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.brands.show', $brand->id) }}"
                                    class="inline-flex items-center px-3 py-1.5 border border-blue-300 rounded-md text-blue-600 bg-white hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>
                                    View Products
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($brands->hasPages())
            <div id="pagination" class="mt-4 px-6 py-3 bg-gray-50 border-t border-gray-200">
                {{ $brands->links() }}
            </div>
            @endif
        </div>
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
                    id: id,
                    name: name,
                    currentLogo: logo,
                    newLogo: null
                };
                this.showEditModal = true;
            },

            async submitBrandForm() {
                this.isSubmitting = true;
                try {
                    const formData = new FormData();
                    formData.append('brandName', this.brandForm.name);
                    formData.append('brandImg', this.brandForm.logo);

                    const response = await axios.post('{{ route("admin.brands.store") }}', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });

                    window.location.reload();
                } catch (error) {
                    this.handleError(error, 'Error creating brand');
                } finally {
                    this.isSubmitting = false;
                }
            },

            async submitEditForm() {
                this.isSubmitting = true;
                try {
                    const formData = new FormData();
                    formData.append('_method', 'PUT');
                    formData.append('brandName', this.editForm.name);
                    
                    if (this.editForm.newLogo) {
                        formData.append('brandImg', this.editForm.newLogo);
                    }

                    const response = await axios.post(`/admin/brands/${this.editForm.id}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });

                    window.location.reload();
                } catch (error) {
                    this.handleError(error, 'Error updating brand');
                } finally {
                    this.isSubmitting = false;
                }
            },

            handleError(error, defaultMessage) {
                // alert('Error:', error);
                let errorMessage = defaultMessage;
                
                if (error.response) {
                    // The request was made and the server responded with a status code
                    if (error.response.data && error.response.data.message) {
                        errorMessage = error.response.data.message;
                    } else if (error.response.status === 422) {
                        errorMessage = 'Validation error: ' + 
                            Object.values(error.response.data.errors).flat().join(', ');
                    }
                } else if (error.request) {
                    errorMessage = 'No response received from server';
                }
                
                alert(errorMessage);
            }
        }));
    });
</script>
@endsection