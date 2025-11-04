<!-- Modal 2b: Parent -->
<div id="parentModal" onclick="handleModalOverlayClick(event)"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">

    <form method="POST" action="{{ route('selectStudentController') }}" id="parentContent"
        class="bg-white rounded-lg p-6 max-w-2xl w-full transform scale-95 transition-all duration-300"
        onclick="event.stopPropagation()">
        @csrf
        <h2 class="text-xl font-semibold mb-2">Confirm Parent Role</h2>
        <p class="text-gray-600 mb-4">Do you want to continue and submit your request as a parent? Add any children not listed below if needed.</p>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Add Children Not Listed</label>
            <div id="extraInputContainer" class="space-y-2">
                <div class="flex gap-2">
                    <input type="text" name="student_name[]" placeholder="Enter your child's name"
                        class="w-full border px-4 py-2 rounded">
                </div>
            </div>
            <button type="button" onclick="addInputField()" class="mt-2 ml-2 text-sm text-green-600 hover:underline">+
                Add
                another child</button>
        </div>



        <div class="flex justify-between">
            <button type="button" onclick="reloadPage()"
                class="px-4 py-2 bg-yellow-400 text-white rounded hover:bg-yellow-500">Back</button>
            <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Submit Request</button>
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


        function addInputField() {
            const container = document.getElementById('extraInputContainer');

            const wrapper = document.createElement('div');
            wrapper.className = 'flex gap-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'student_name[]';
            input.placeholder = "Enter another child's name";
            input.className = 'w-full border px-4 py-2 rounded bg-white';
            input.required = true;

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.innerText = '✕';
            removeBtn.className = 'text-red-500 hover:text-red-700 px-2 rounded font-bold';
            removeBtn.onclick = () => wrapper.remove();

            wrapper.appendChild(input);
            wrapper.appendChild(removeBtn);

            container.appendChild(wrapper);
        }
    </script>
</div>
