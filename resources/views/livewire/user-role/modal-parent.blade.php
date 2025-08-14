<!-- Modal 2b: Parent -->
<div id="parentModalQA" onclick="handleModalOverlayClick(event)"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">

    <form method="POST" action="{{ route('selectStudentController') }}" id="parentContentQA"
        class="bg-white rounded-lg p-6 max-w-2xl w-full transform scale-95 transition-all duration-300"
        onclick="event.stopPropagation()">
        @csrf
        <h2 class="text-xl font-semibold mb-2">Select Your Child</h2>
        <p class="text-gray-600 mb-4">Select from the recommended students the one(s) you wish to remove.</p>
        <!-- ✅ Hidden input to send selected IDs to Livewire -->
        <input type="hidden" id="selected_ids" name="selected_ids">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            @forelse ($childrens as $child)
                <div data-student-id="{{ $child->id }}" role="button"
                    class="student-card flex-col items-center border p-3 rounded hover:border-2 hover:border-red-400 border-green-400 hover:shadow cursor-pointer">
                    <div class="flex">
                        <img src="/storage/{{ $child->profile }}" class="w-12 h-12 rounded-full mr-3" alt="Child">
                        <span>{{ $child->lastname . ', ' . $child->firstname . ' ' . $child->middlename . ' ' . $child->extension_name }}</span>
                    </div>
                    <div class="flex w-full justify-center">
                        <p class="text-md font-semibold">{{ $child->grade }} - {{ $child->section }}</p>
                    </div>
                </div>
            @empty
            @endforelse
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Child not listed?</label>
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
            <button type="button" onclick="goBackToUserTypeQA()"
                class="px-4 py-2 bg-yellow-400 text-white rounded hover:bg-yellow-500">Back</button>
            <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Continue</button>
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
            const modal = document.getElementById('parentModalQA');
            modal.classList.add('opacity-0', 'pointer-events-none');
        }

        function goBackToUserTypeQA() {
            // Custom logic to go back
            closeAllModals(); // Only closes if clicked intentionally
        }

        let selectedStudentIds = [];

        const studentCards = document.querySelectorAll('.student-card');

        studentCards.forEach(card => {
            card.addEventListener('click', () => {
                const studentId = card.getAttribute('data-student-id');

                if (selectedStudentIds.includes(studentId)) {
                    selectedStudentIds = selectedStudentIds.filter(id => id !== studentId);
                    card.classList.remove('border-2', 'border-red-500');
                } else {
                    selectedStudentIds.push(studentId);
                    card.classList.add('border-2', 'border-red-500');
                }
                document.getElementById('selected_ids').value = selectedStudentIds.join(',');
                // alert(selectedStudentIds)
                console.log("Selected Student IDs:", selectedStudentIds);

                // ✅ Sync JS array with hidden input for Livewire
            });
        });

        function addInputField() {
            const container = document.getElementById('extraInputContainer');

            const wrapper = document.createElement('div');
            wrapper.className = 'flex gap-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'student_name[]';
            input.placeholder = "Enter another child's name";
            input.className = 'w-full border px-4 py-2 rounded';

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
