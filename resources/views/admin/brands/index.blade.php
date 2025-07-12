@extends('layouts.admin')
@section('title', 'Brands Management')
@section('content')


@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
    class="fixed top-4 right-4 bg-black text-white px-4 py-2 rounded shadow">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
    class="fixed top-4 right-4 bg-red-700 text-white px-4 py-2 rounded shadow">
    {{ session('error') }}
</div>
@endif

<div class="container mx-auto px-4 py-6" x-data="brandManagement()">
    <!-- Error message container -->
    <div x-show="errorMessage" x-text="errorMessage"
        class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded shadow"
        x-init="setTimeout(() => errorMessage = '', 3000)"></div>
    <div class="bg-white overflow-hidden">
        <div class="px-6 py-4 bg-black text-white flex justify-between items-center">
            <h2 class="text-xl font-bold">Brands Management</h2>
            <button @click="showCreateModal = true"
                class="px-4 py-2 bg-white text-black hover:bg-gray-100 transition-all duration-200">
                Add Brand
            </button>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Logo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Products</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($brands as $brand)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('storage/' . $brand->brandImg) }}"
                                    class="h-12 w-12 rounded-full object-cover border border-gray-200"
                                    alt="{{ $brand->brandName }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium">{{ $brand->brandName }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button
                                        @click="openEditModal({{ $brand->id }}, '{{ $brand->brandName }}', '{{ asset('storage/' . $brand->brandImg) }}')"
                                        class="px-3 py-1 text-white bg-green-600 rounded-md hover:bg-green-800"><i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 text-white bg-red-500 rounded-md hover:bg-red-700"
                                            onclick="return confirm('Are you sure?')">
                                          <i class="fas fa-trash-alt mr-1"></i>  Delete 
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

            @if($brands->hasPages())
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
            brandForm: { name: '', logo: null },
            editForm: { id: null, name: '', currentLogo: '', newLogo: null },

            openEditModal(id, name, logo) {
                this.editForm = { id, name, currentLogo: logo, newLogo: null };
                this.showEditModal = true;
            },

            async submitBrandForm() {
                this.isSubmitting = true;
                this.errorMessage = '';
                
                try {
                    const formData = new FormData();
                    formData.append('brandName', this.brandForm.name);
                    formData.append('brandImg', this.brandForm.logo);

                    await axios.post('{{ route("admin.brands.store") }}', formData);
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
                    formData.append('brandName', this.editForm.name);
                    if (this.editForm.newLogo) formData.append('brandImg', this.editForm.newLogo);

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