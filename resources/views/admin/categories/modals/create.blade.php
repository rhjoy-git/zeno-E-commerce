<!-- Create Modal -->
<div x-show="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    style="display: none;">
    <div class="bg-white w-full max-w-md mx-4">
        <form @submit.prevent="submitCategoryForm" enctype="multipart/form-data" class="p-6">
            <div class="flex justify-between items-center border-b pb-4">
                <h3 class="text-lg font-semibold">Add New Category</h3>
                <button class="text-2xl" @click="showCreateModal = false" type="button">×</button>
            </div>

            <div class="mt-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Category Name</label>
                    <input x-model="categoryForm.name" type="text" required class="w-full px-3 py-2 border " placeholder="Enter category name">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Parent Category</label>
                    <select x-model="categoryForm.parent_id" class="w-full px-3 py-2 border ">
                        <option value="">None</option>
                        @if(!empty($parentCategories))
                        @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->category_name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select x-model="categoryForm.status" class="w-full px-3 py-2 border ">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Category Logo</label>
                    <input type="file" @change="categoryForm.logo = $event.target.files[0]" class="w-full"
                        accept="image/*" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button @click="showCreateModal = false" type="button" class="px-4 py-2 border "
                    :disabled="isSubmitting">
                    Cancel
                </button>
                <button type="submit" :disabled="isSubmitting"
                    class="px-4 py-2 bg-black text-white  disabled:opacity-50">
                    <span x-show="!isSubmitting">Save Category</span>
                    <span x-show="isSubmitting">Processing...</span>
                </button>
            </div>
        </form>
    </div>
</div>