<!-- Edit Modal -->
<div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
    <div class="bg-white w-full max-w-md mx-4">
        <form @submit.prevent="submitEditForm" enctype="multipart/form-data" class="p-6">
            <div class="flex justify-between items-center border-b pb-4">
                <h3 class="text-lg font-semibold">Edit Category</h3>
                <button class="text-2xl" @click="showEditModal = false" type="button">×</button>
            </div>

            <div class="mt-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Category Name</label>
                    <input x-model="editForm.name" type="text" required class="w-full px-3 py-2 border ">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Parent Category</label>
                    <select x-model="editForm.parent_id" class="w-full px-3 py-2 border ">
                        <option value="">None</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select x-model="editForm.status" class="w-full px-3 py-2 border ">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Current Logo</label>
                    <img x-bind:src="editForm.currentLogo" class="h-24 w-24  border border-gray-200 mb-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Update Logo (Optional)</label>
                    <input type="file" @change="editForm.newLogo = $event.target.files[0]" class="w-full"
                        accept="image/*">
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button @click="showEditModal = false" type="button" class="px-4 py-2 border "
                    :disabled="isSubmitting">
                    Close
                </button>
                <button type="submit" :disabled="isSubmitting"
                    class="px-4 py-2 bg-black text-white  disabled:opacity-50">
                    <span x-show="!isSubmitting">Update Category</span>
                    <span x-show="isSubmitting">Processing...</span>
                </button>
            </div>
        </form>
    </div>
</div>