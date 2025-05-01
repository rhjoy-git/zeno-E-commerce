<!-- Edit Brand Modal -->
<div x-show="showEditModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div @click.away="showEditModal = false" class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <form @submit.prevent="submitEditForm" enctype="multipart/form-data" class="p-6">
            <div class="flex justify-between items-center border-b pb-4">
                <h3 class="text-lg font-semibold">Edit Brand</h3>
                <button @click="showEditModal = false" type="button" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mt-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
                    <input x-model="editForm.name" type="text" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Logo</label>
                    <img x-bind:src="editForm.currentLogo"
                        class="h-24 w-24 rounded-md object-cover border border-gray-200 mb-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Update Logo (Optional)</label>
                    <div x-data="{ fileName: '', previewUrl: '' }">
                        <div class="flex items-center">
                            <label
                                class="relative flex flex-col items-center justify-center w-full h-32 px-4 py-6 text-blue-500 rounded-lg border-2 border-dashed border-gray-300 cursor-pointer hover:border-blue-400 transition-all duration-200 overflow-hidden"
                                :style="previewUrl ? 'background-image: url(' + previewUrl + '); background-size: cover; background-position: center' : ''">
                                <div class="absolute inset-0 bg-white bg-opacity-70 hover:bg-opacity-30 backdrop-blur-sm hover:backdrop-blur-none transition-all duration-300"
                                    x-show="previewUrl"></div>
                                <div class="relative z-10 flex flex-col items-center">
                                    <i class="fas fa-cloud-upload-alt text-2xl mb-2"></i>
                                    <span x-text="fileName || 'Choose an image'" class="text-sm"></span>
                                </div>
                                <input type="file" @change="
                                       fileName = $event.target.files[0]?.name;
                                       previewUrl = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : '';
                                       editForm.newLogo = $event.target.files[0];
                                   " class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button @click="showEditModal = false" type="button"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Close
                </button>
                <button type="submit" :disabled="isSubmitting"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50">
                    <span x-show="!isSubmitting">Update Brand</span>
                    <span x-show="isSubmitting" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>