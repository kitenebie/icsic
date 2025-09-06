<div id="modalProfile" class="fixed z-50 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div id="modalContent" class="bg-white w-full max-w-lg rounded-lg p-8 relative shadow-xl">

        <!-- Close Button -->
        <button onclick="closemodalProfile()"
            class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl font-bold">
            &times;
        </button>

        <!-- Avatar -->
        <div class="flex flex-col items-center mb-6">
            @if ($profile)
                <img src="{{ $profile->temporaryUrl() }}" alt="Avatar preview" class="w-24 h-24 rounded-full border-4 border-green-500 mb-2">
            @else
                <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : asset('images/blank-avatar.png') }}"
                    alt="Avatar" class="w-24 h-24 rounded-full border-4 border-green-500 mb-2">
            @endif
            <p class="text-lg font-semibold">User Profile</p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="updateProfile" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <input wire:model="first_name" type="text" placeholder="First Name" class="border p-2 rounded w-full" />
                <input wire:model="middle_name" type="text" placeholder="Middle Name" class="border p-2 rounded w-full" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <input wire:model="last_name" type="text" placeholder="Last Name" class="border p-2 rounded w-full" />
                <input wire:model="extension_name" type="text" placeholder="Extension Name" class="border p-2 rounded w-full" />
            </div>
            <input wire:model="email" type="email" placeholder="Email" class="border p-2 rounded w-full" />
            <input wire:model="password" type="password" placeholder="Password" class="border p-2 rounded w-full" />
            <input wire:model="confirm_password" type="password" placeholder="Confirm Password" class="border p-2 rounded w-full" />

            <!-- Profile Photo Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" wire:model="profile" accept="image/*" class="border p-2 rounded w-full" />
                @error('profile') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                <div wire:loading wire:target="profile" class="text-sm text-gray-500 mt-1">Uploading...</div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-blue-700" wire:loading.attr="disabled">
                Update Profile
            </button>
        </form>

        @if (session()->has('success'))
            <p class="text-green-600 mt-3">{{ session('success') }}</p>
        @endif
    </div>

    <script>
        function modalProfile() {
            const modal = document.getElementById('modalProfile');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('translate-y-10', 'opacity-0');
                content.classList.add('translate-y-0', 'opacity-100');
            }, 100);
        }

        function closemodalProfile() {
            const modal = document.getElementById('modalProfile');
            const content = document.getElementById('modalContent');

            content.classList.remove('translate-y-0', 'opacity-100');
            content.classList.add('translate-y-10', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    </script>
</div>
