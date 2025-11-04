<div id="modalProfile" class="fixed z-50 inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden">
    <div id="modalContent" class="bg-white w-full max-w-2xl max-h-[80vh] rounded-lg relative shadow-xl transform translate-y-10 opacity-0 transition-all duration-300 overflow-hidden flex flex-col">

        <!-- Close Button -->
        <button onclick="closemodalProfile()"
            class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl font-bold hover:bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center transition-colors">
            &times;
        </button>

        <!-- Header (Fixed) -->
        <div class="flex-shrink-0 px-8 py-6 border-b border-gray-200">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900">Edit Profile</h2>
                <p class="text-gray-600 mt-1">Update your personal information</p>
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-8 py-6">
            <!-- Avatar Section -->
            <div class="flex flex-col items-center mb-8">
                <div class="relative">
                    @if ($profile)
                        <img src="{{ $profile->temporaryUrl() }}" alt="Avatar preview"
                             class="w-32 h-32 rounded-full border-4 border-blue-500 object-cover shadow-lg">
                    @else
                        <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : asset('images/blank-avatar.png') }}"
                             alt="Current Avatar"
                             class="w-32 h-32 rounded-full border-4 border-gray-300 object-cover shadow-lg">
                    @endif
                    <div class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-2 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    @if (auth()->user()->profile_picture)
                        <button wire:click="removeProfilePicture"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-lg hover:bg-red-600 transition-colors"
                                title="Remove profile picture">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>
                <p class="text-lg font-semibold text-gray-900 mt-4">{{ auth()->user()->FirstName }} {{ auth()->user()->LastName }}</p>
                <p class="text-gray-600">{{ auth()->user()->email }}</p>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="updateProfile" class="space-y-6">
            <!-- Name Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                    <input readonly wire:model="first_name" type="text" placeholder="Enter first name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('first_name') border-red-500 @enderror" />
                    @error('first_name') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                    <input readonly wire:model="middle_name" type="text" placeholder="Enter middle name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                    <input readonly wire:model="last_name" type="text" placeholder="Enter last name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('last_name') border-red-500 @enderror" />
                    @error('last_name') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Extension Name</label>
                    <input readonly wire:model="extension_name" type="text" placeholder="Enter extension name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" />
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input wire:model="email" type="email" placeholder="Enter email address"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('email') border-red-500 @enderror" />
                @error('email') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Password Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input wire:model="password" type="password" placeholder="Enter new password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('password') border-red-500 @enderror" />
                    @error('password') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input wire:model="confirm_password" type="password" placeholder="Confirm new password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('confirm_password') border-red-500 @enderror" />
                    @error('confirm_password') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Profile Photo Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition-colors">
                    <input type="file" wire:model="profile" accept="image/*" class="hidden" id="profile-upload" />
                    <label for="profile-upload" class="cursor-pointer">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-gray-600 font-medium">Click to upload profile photo</p>
                            <p class="text-gray-400 text-sm mt-1">PNG, JPG up to 2MB</p>
                        </div>
                    </label>
                    @if ($profile)
                        <div class="mt-4">
                            <p class="text-sm text-brown-600 font-medium">Selected: {{ $profile->getClientOriginalName() }}</p>
                        </div>
                    @endif
                </div>
                @error('profile') <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span> @enderror
                <div wire:loading wire:target="profile" class="text-sm text-brown-600 mt-2 flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-brown-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Uploading image...
                </div>
            </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-brown-600 text-white py-3 px-6 rounded-lg hover:bg-brown-700 focus:ring-2 focus:ring-brown-500 focus:ring-offset-2 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>Update Profile</span>
                    <span wire:loading class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Updating Profile...
                    </span>
                </button>
            </form>

            <!-- Success/Error Messages -->
            @if (session()->has('success'))
                <div class="mt-6 bg-brown-50 border border-brown-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-brown-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-brown-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-red-800">
                            <p class="font-medium">Please fix the following errors:</p>
                            <ul class="list-disc list-inside mt-2 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Modal state management with localStorage
        const MODAL_STATE_KEY = 'profile_modal_open';

        function modalProfile() {
            const modal = document.getElementById('modalProfile');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            localStorage.setItem(MODAL_STATE_KEY, 'true');

            // Trigger animation
            setTimeout(() => {
                content.classList.remove('translate-y-10', 'opacity-0');
                content.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        }

        function closemodalProfile() {
            const modal = document.getElementById('modalProfile');
            const content = document.getElementById('modalContent');

            content.classList.remove('translate-y-0', 'opacity-100');
            content.classList.add('translate-y-10', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                localStorage.removeItem(MODAL_STATE_KEY);
                // Clear stored file when modal closes
                localStorage.removeItem(FILE_STORAGE_KEY);
            }, 300);
        }

        // Prevent modal from closing on backdrop click or escape key
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalProfile');
            const content = document.getElementById('modalContent');

            // Check if modal should be open from localStorage
            if (localStorage.getItem(MODAL_STATE_KEY) === 'true') {
                modalProfile();
            }

            // Prevent backdrop click from closing modal (but allow form interactions)
            modal.addEventListener('click', function(e) {
                const target = e.target;
                const isFileInput = target.type === 'file' || target.tagName === 'LABEL' || target.closest('label');
                const isFormElement = target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.tagName === 'SELECT' || target.tagName === 'BUTTON';
                const isInsideForm = target.closest('form');

                // If it's a file input interaction or form element, allow the event
                if (isFileInput || (isFormElement && isInsideForm)) {
                    return; // Allow the event to proceed
                }

                // For backdrop clicks, prevent modal closure
                if (e.target === modal) {
                    e.stopPropagation();
                    e.preventDefault();
                }
            });

            // Prevent escape key from closing modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    // Don't close the modal on escape
                }
            });

            // Allow file input and form interactions while preventing modal closure
            modal.addEventListener('click', function(e) {
                // Allow clicks on file inputs, labels, and form elements
                const target = e.target;
                const isFileInput = target.type === 'file' || target.tagName === 'LABEL' || target.closest('label');
                const isFormElement = target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.tagName === 'SELECT' || target.tagName === 'BUTTON';
                const isInsideForm = target.closest('form');

                // If it's a file input interaction or form element, allow the event
                if (isFileInput || (isFormElement && isInsideForm)) {
                    return; // Allow the event to proceed
                }

                // For backdrop clicks, prevent modal closure
                if (e.target === modal) {
                    e.stopPropagation();
                    e.preventDefault();
                }
            }, true); // Use capture phase to intercept events early
        });

        // Prevent page unload from affecting modal
        window.addEventListener('beforeunload', function(e) {
            if (!document.getElementById('modalProfile').classList.contains('hidden')) {
                localStorage.setItem(MODAL_STATE_KEY, 'true');
            }
        });

        // Ultra-aggressive modal protection after any update
        document.addEventListener('livewire:updated', function (event) {
            // Force modal to stay open after any Livewire update
            setTimeout(() => {
                const modal = document.getElementById('modalProfile');
                if (modal) {
                    modal.classList.remove('hidden');
                    localStorage.setItem(MODAL_STATE_KEY, 'true');

                    // Re-apply animation classes
                    const content = document.getElementById('modalContent');
                    if (content) {
                        content.classList.remove('translate-y-10', 'opacity-0');
                        content.classList.add('translate-y-0', 'opacity-100');
                    }
                }
            }, 10);
        });

        // Prevent modal closure during file upload process
        document.addEventListener('livewire:loading', function (event) {
            const modal = document.getElementById('modalProfile');
            if (modal && !modal.classList.contains('hidden')) {
                localStorage.setItem(MODAL_STATE_KEY, 'true');
            }
        });

        // Listen for form submission and force modal to stay open
        document.addEventListener('submit', function(e) {
            const modal = document.getElementById('modalProfile');
            if (modal && e.target.closest('#modalProfile')) {
                // Aggressive prevention of modal closure
                localStorage.setItem(MODAL_STATE_KEY, 'true');

                // Add multiple event listeners to prevent closure
                const preventClosure = (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    return false;
                };

                // Prevent any modal closure events
                setTimeout(() => {
                    modal.classList.remove('hidden');
                    const content = document.getElementById('modalContent');
                    if (content) {
                        content.classList.remove('translate-y-10', 'opacity-0');
                        content.classList.add('translate-y-0', 'opacity-100');
                    }
                }, 100);
            }
        });

        // Continuous modal monitoring
        setInterval(() => {
            const modal = document.getElementById('modalProfile');
            if (modal && localStorage.getItem(MODAL_STATE_KEY) === 'true' && modal.classList.contains('hidden')) {
                // Force modal back open if it was supposed to be open
                modal.classList.remove('hidden');
                const content = document.getElementById('modalContent');
                if (content) {
                    content.classList.remove('translate-y-10', 'opacity-0');
                    content.classList.add('translate-y-0', 'opacity-100');
                }
            }
        }, 500);

        // File storage and retrieval from localStorage
        const FILE_STORAGE_KEY = 'profile_upload_file';

        // Listen for store-file event from PHP
        document.addEventListener('store-file', function(e) {
            const fileInfo = e.detail.fileInfo;
            localStorage.setItem(FILE_STORAGE_KEY, JSON.stringify(fileInfo));
        });

        // Listen for restore-file event from PHP
        document.addEventListener('restore-file', function(e) {
            const storedFile = localStorage.getItem(FILE_STORAGE_KEY);
            if (storedFile) {
                const fileInfo = JSON.parse(storedFile);

                // Convert base64 back to blob
                fetch(`data:${fileInfo.mime};base64,${fileInfo.data}`)
                    .then(res => res.blob())
                    .then(blob => {
                        // Create a new File object
                        const file = new File([blob], fileInfo.name, {
                            type: fileInfo.mime,
                            lastModified: fileInfo.timestamp * 1000
                        });

                        // Set the file to the input (this will trigger Livewire)
                        const fileInput = document.getElementById('profile-upload');
                        if (fileInput) {
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            fileInput.files = dataTransfer.files;

                            // Trigger change event to notify Livewire
                            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    })
                    .catch(error => {
                        console.error('Error restoring file from localStorage:', error);
                        localStorage.removeItem(FILE_STORAGE_KEY);
                    });
            }
        });

        // Restore file on page load if modal was open
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalProfile');
            const storedFile = localStorage.getItem(FILE_STORAGE_KEY);

            if (storedFile && localStorage.getItem(MODAL_STATE_KEY) === 'true') {
                // Small delay to ensure Livewire is ready
                setTimeout(() => {
                    document.dispatchEvent(new CustomEvent('restore-file'));
                }, 100);
            }
        });

        // Clear stored file when modal closes or form is submitted
        function clearStoredFile() {
            localStorage.removeItem(FILE_STORAGE_KEY);
        }

        // Clear file when form is submitted successfully
        document.addEventListener('livewire:updated', function(e) {
            if (document.querySelector('.bg-brown-50')) {
                clearStoredFile();
            }
        });

        // Auto-hide success message after 5 seconds
        @if (session()->has('success'))
            setTimeout(() => {
                const successMessage = document.querySelector('.bg-brown-50');
                if (successMessage) {
                    successMessage.style.transition = 'opacity 0.5s';
                    successMessage.style.opacity = '0';
                    setTimeout(() => successMessage.remove(), 500);
                }
            }, 5000);
        @endif
    </script>
</div>
