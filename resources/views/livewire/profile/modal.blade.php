  <!-- Modal -->
  <div id="modalProfile" class="fixed z-50 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
      <div id="modalContent" class="bg-white w-full max-w-lg rounded-lg p-8 relative shadow-xl">

          <!-- Close Button -->
          <button onclick="closemodalProfile()"
              class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl font-bold">
              &times;
          </button>

          <!-- Avatar -->
          <!-- Avatar -->
          <div class="flex flex-col items-center mb-6">
              <img src="{{ auth()->user()->profile ? asset('storage/' . auth()->user()->profile) : asset('images/blank-avatar.png') }}"
                  alt="Avatar" class="w-24 h-24 rounded-full border-4 border-green-500 mb-2">
              <p class="text-lg font-semibold">User Profile</p>
          </div>

          <!-- Form -->
          <form class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                  <input value="{{ auth()->user()->FirstName }}" type="text" placeholder="First Name"
                      class="border p-2 rounded w-full" />
                  <input value="{{ auth()->user()->MiddleName }}" type="text" placeholder="Middle Name"
                      class="border p-2 rounded w-full" />
              </div>
              <div class="grid grid-cols-2 gap-4">
                  <input value="{{ auth()->user()->LastName }}" type="text" placeholder="Last Name"
                      class="border p-2 rounded w-full" />
                  <input value="{{ auth()->user()->extension_name }}" type="text" placeholder="Extension Name"
                      class="border p-2 rounded w-full" />
              </div>
              <input value="{{ auth()->user()->email }}" type="email" placeholder="Email"
                  class="border p-2 rounded w-full" />
              <input value="" type="password" placeholder="Password" class="border p-2 rounded w-full" />
              <input value="" type="confirm_password" placeholder="confirm_password"
                  class="border p-2 rounded w-full" />

              <!-- Submit Button -->
              <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-blue-700">
                  Submit Request
              </button>
          </form>
      </div>
      <script>
          function modalProfile() {
              const modal = document.getElementById('modalProfile');
              const content = document.getElementById('modalContent');

              modal.classList.remove('hidden');

              // Delay to allow CSS transition
              setTimeout(() => {
                  content.classList.remove('translate-y-10', 'opacity-0');
                  content.classList.add('translate-y-0', 'opacity-100');
              }, 3000);
          }

          function closemodalProfile() {
              const modal = document.getElementById('modalProfile');
              const content = document.getElementById('modalContent');

              // Start exit animation
              content.classList.remove('translate-y-0', 'opacity-100');
              content.classList.add('translate-y-10', 'opacity-0');

              // Hide after animation ends
              setTimeout(() => {
                  modal.classList.add('hidden');
              }, 10); // match transition duration
          }
      </script>

  </div>
