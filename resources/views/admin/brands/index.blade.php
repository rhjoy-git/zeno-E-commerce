@extends('layouts.admin')
@section('title', 'Brands Management')
@section('content')

    <div class="container mx-auto px-4 py-6">

        <div class="bg-white overflow-hidden">
            <div class="px-6 py-4 text-white flex justify-between items-center border-b border-gray-300">
                <h2 class="text-xl font-semibold text-gray-800">Brands Management</h2>
                <button @click="showCreateModal = true"
                    class="inline-flex items-center px-4 py-2 bg-black text-white hover:bg-gray-800 transition-colors text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Brand
                </button>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Logo
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Products
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($brands as $brand)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ asset('storage/' . $brand->brandImg) }}"
                                            class="h-12 w-12 rounded-full object-cover border border-gray-200"
                                            alt="{{ $brand->brand_name }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium">{{ $brand->brand_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button
                                                @click="openEditModal({{ $brand->id }}, '{{ $brand->brand_name }}', '{{ asset('storage/' . $brand->brandImg) }}')"
                                                class="px-3 py-1 text-white bg-green-600 rounded-md hover:bg-green-800"><i
                                                    class="fas fa-edit mr-1"></i>
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1 text-white bg-red-500 rounded-md hover:bg-red-700"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.brands.show', $brand->id) }}"
                                            class="px-3 py-1.5 border border-gray-300 rounded-md hover:bg-gray-100">
                                            View Products
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($brands->hasPages())
                    <div class="mt-4 px-6 py-3 border-t border-gray-200">
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
