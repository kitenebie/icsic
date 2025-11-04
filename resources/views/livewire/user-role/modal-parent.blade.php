<!-- Modal 2b: Parent -->
<div id="parentModal" onclick="handleModalOverlayClick(event)"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">

    <form method="POST" action="{{ route('selectStudentController') }}" id="parentContent"
        class="bg-cream-50 rounded-lg p-6 max-w-2xl w-full transform scale-95 transition-all duration-300"
        onclick="event.stopPropagation()">
        @csrf
        <h2 class="text-xl font-semibold mb-2 text-brown-800">Confirm Parent Role</h2>
        <p class="text-gray-600 mb-4">Do you want to continue and submit your request as a parent?</p>




        <div class="flex justify-between">
            <button type="button" onclick="reloadPage()"
                class="px-4 py-2 bg-cream-600 text-white rounded hover:bg-cream-700">Back</button>
            <button type="submit"
                class="px-4 py-2 bg-cream-600 text-white rounded hover:bg-cream-700">Continue</button>
        </div>

        <!-- Optional Flash Messages -->
        @if (session()->has('message'))
            <div class="mt-4 text-green-600 font-medium">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="mt-4 text-red-600 font-medium">{{ session('error') }}</div>
        @endif
    </form>

    <!-- ✅ JS stays as you wrote it -->
    <script>
        function handleModalOverlayClick(event) {
            // Prevent modal from closing on outside click
            console.log("Click outside modal ignored");
        }

        function closeAllModals() {
            const modal = document.getElementById('parentModal');
            modal.classList.add('opacity-0', 'pointer-events-none');
        }

        function goBackToUserType() {
            // Custom logic to go back
            closeAllModals(); // Only closes if clicked intentionally
        }


    </script>
</div>
