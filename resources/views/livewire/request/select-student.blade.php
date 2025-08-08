<!-- selectStudentModal 2b: Parent -->

<div id="RequestFrom137" onclick="handleselectStudentModalOverlayClick(event)"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">

    <form method="POST" action="{{ route('selectedRequestForm') }}" id="parentContent"
        class="bg-white rounded-lg p-6 max-w-2xl w-full transform scale-95 transition-all duration-300"
        onclick="event.stopPropagation()">
        @csrf
        <h2 class="text-2xl font-semibold mb-2">Select Your Child</h2>
        <h2 class="text-lg font-semibold mb-2" id="reqType"></h2>
        <p class="text-gray-600 mb-4">Select from the recommended students the one(s) you wish to request a document.
        </p>
        <!-- ✅ Hidden input to send selected IDs to Livewire -->
        <input type="hidden" id="selected_ids" name="selected_ids">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            @forelse ($childrens as $child)
                <div data-student-id="{{ $child->id }}" role="button"
                    class="student-card flex-col items-center border-2 p-3 rounded  cursor-pointer">
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
        <div class="grid grid-col-12 p-4">
            <div class="px-4 py-2 rounded-md bg-gray-100 col-12">

                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                    reason</label>
                <textarea id="message" rows="4" name="message"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Write your reason here..."></textarea>

            </div>
        </div>


        <div class="flex justify-between">
            <button type="button" onclick="goBackToUserType()"
                class="px-4 py-2 bg-yellow-400 text-white rounded hover:bg-yellow-500">Back</button>
            <button type="submit" id="submit" class="px-4 py-2 text-white rounded">Continue</button>
        </div>
        <input type="hidden" name="formid" id="formid">
        <!-- Optional Flash Messages -->
        @if (session()->has('message'))
            <div class="mt-4 text-green-600 font-medium">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="mt-4 text-red-600 font-medium">{{ session('error') }}</div>
        @endif
    </form>
    {{-- @script --}}
    <script>
        const submit = document.getElementById('submit');
        submit.disabled = true
        document.addEventListener('livewire:init', () => {
            Livewire.on('form', (event) => {
                const formid = document.getElementById('formid');
                formid.value = event.id;
                console.log(event.id)
                document.getElementById('reqType').innerHTML =
                    `Document Type:  <span class="px-4 py-2 bg-green-100 border-green-500 border-2 rounded-sm">${event.id=='0' ? "Form 137" : event.id=='1' ? "Form 138" : "Cert. of Good Moral"}</span>`;
            });
        });

        function toggleselectStudentModal(show) {
            const selectStudentModal = document.getElementById("selectStudentModal");
            const selectStudentModalContent = document.getElementById("selectStudentModalContent");

            if (show) {
                selectStudentModal.classList.remove("invisible", "opacity-0");
                setTimeout(() => {
                    selectStudentModalContent.classList.remove("scale-95", "opacity-0");
                }, 10);
            } else {
                selectStudentModalContent.classList.add("scale-95", "opacity-0");
                setTimeout(() => {
                    selectStudentModal.classList.add("invisible", "opacity-0");
                }, 300);
            }
        }

        function handleselectStudentModalOverlayClick(event) {
            // Prevent selectStudentModal from closing on outside click
            console.log("Click outside selectStudentModal ignored");
        }

        function closeAllselectStudentModals() {
            const selectStudentModal = document.getElementById('RequestFrom137');
            selectStudentModal.classList.add('opacity-0', 'pointer-events-none');
            toggleFormModal(true)
        }

        function goBackToUserType() {
            // Custom logic to go back
            closeAllselectStudentModals(); // Only closes if clicked intentionally
        }
    </script>
    <script>
        let selectedStudentIds = [];

        const studentCards = document.querySelectorAll('.student-card');
        submit.classList.add('bg-gray-400')

        studentCards.forEach(card => {
            card.addEventListener('click', () => {
                const studentId = card.getAttribute('data-student-id');
                if (selectedStudentIds.includes(studentId)) {
                    selectedStudentIds = selectedStudentIds.filter(id => id !== studentId);
                    card.classList.remove('border-green-500', 'shadow-md', 'bg-green-50');
                } else {
                    selectedStudentIds.push(studentId);
                    card.classList.add('border-green-500', 'shadow-md', 'bg-green-50');

                }
                document.getElementById('selected_ids').value = selectedStudentIds.join(',');
                // alert(selectedStudentIds)
                console.log("Selected Student IDs:", selectedStudentIds);
                if (selectedStudentIds.length > 0) {
                    submit.classList.remove('bg-gray-400');
                    submit.classList.add('bg-green-600', 'hover:bg-green-700');
                    submit.disabled = false;
                } else {
                    submit.classList.remove('bg-green-600', 'hover:bg-green-700');
                    submit.classList.add('bg-gray-400');
                    submit.disabled = true;
                }
                // ✅ Sync JS array with hidden input for Livewire
            });
        });
    </script>
</div>
