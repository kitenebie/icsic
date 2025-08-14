<div>
    <!-- Modal 1: User Type Selection -->
    <div id="userTypeModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="userTypeContent"
            class="bg-white rounded-lg shadow-lg max-w-3xl w-full p-6 transform scale-95 transition-all duration-300">
            <button onclick="closeModal('userTypeModal')"
                class="text-gray-500 hover:text-red-500 text-2xl font-bold absolute top-4 right-6">
                &times;
            </button>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Choose User Type</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Parent -->
                <div
                    class="border rounded-lg p-5 hover:shadow-lg hover:border-2 hover:border-green-400 bg-gray-50 transition cursor-pointer">
                    <div class="flex items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.29.533 6.121 1.474M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="text-lg font-bold">Parent</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Monitor your child's classroom updates and school announcements.</p>
                    <button onclick="openModal('parentModalDOC')"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Select Parent</button>
                </div>

                <!-- Graduate -->
                <div
                    class="border rounded-lg p-5 hover:shadow-lg hover:border-2 hover:border-green-400 bg-gray-50 transition cursor-pointer">
                    <div class="flex items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l6.16-3.422A12.083 12.083 0 0118 20H6a12.083 12.083 0 01-.16-9.422L12 14z" />
                        </svg>
                        <h3 class="text-lg font-bold">Graduate</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Stay informed with school updates, news, and alumni info.</p>
                    <button onclick="openModal('graduateModal')"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Select Graduate</button>
                </div>
            </div>
        </div>
    </div>


    <!-- JavaScript -->
    <script>
        const modals = {
            userTypeModal: {
                wrapper: document.getElementById('userTypeModal'),
                content: document.getElementById('userTypeContent')
            },
            graduateModal: {
                wrapper: document.getElementById('graduateModal'),
                content: document.getElementById('graduateContent')
            },
            parentModalDOC: {
                wrapper: document.getElementById('parentModalDOC'),
                content: document.getElementById('parentContent')
            }
        };

        function showModal(key) {
            const modal = modals[key];
            modal.wrapper.classList.remove('opacity-0', 'pointer-events-none');
            modal.content.classList.remove('scale-95');
            modal.content.classList.add('scale-100');
        }

        function hideModal(key) {
            const modal = modals[key];
            modal.content.classList.remove('scale-100');
            modal.content.classList.add('scale-95');
            modal.wrapper.classList.add('opacity-0', 'pointer-events-none');
        }

        function openModal(modalId) {
            hideModal('userTypeModal');
            showModal(modalId);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('opacity-0', 'pointer-events-none');
        }

        function closeAllModals() {
            Object.keys(modals).forEach(key => hideModal(key));
        }

        // New function for Back buttons in graduateModal and parentModalDOC
        function goBackToUserType() {
            hideModal('graduateModal');
            hideModal('parentModalDOC');
            showModal('userTypeModal');
        }

        window.addEventListener('DOMContentLoaded', () => {
            showModal('userTypeModal');
        });
    </script>

</div>
