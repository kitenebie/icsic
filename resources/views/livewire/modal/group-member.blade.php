<div class="absolute w-full h-screen">
    <!-- Modal -->
    <div id="myModal"
        class="fixed inset-0 pointer-events-none opacity-0 flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
        <div
            class="bg-white rounded-lg shadow-lg max-w-3/4 p-6 relative max-h-[90vh] overflow-y-auto transform scale-95 opacity-0 transition-all duration-300">
            <!-- Close Button -->
            <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl">
                &times;
            </button>

            <!-- Modal Content: Grid with Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <!-- Card 1 -->
                <div class="bg-gray-100 p-4 rounded shadow flex items-center space-x-4">
                    <!-- User Group Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold mb-1">Card Title 1</h3>
                        <p class="text-sm text-gray-700">This is a description for card 1.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const modal = document.getElementById('myModal');
        const modalContent = modal.querySelector('div.bg-white');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('pointer-events-none', 'opacity-0');
            modal.classList.add('pointer-events-auto', 'opacity-100');

            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        });

        closeBtn.addEventListener('click', () => {
            modalContent.classList.add('scale-95', 'opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');

            // Wait for animation before hiding backdrop
            setTimeout(() => {
                modal.classList.add('pointer-events-none', 'opacity-0');
                modal.classList.remove('pointer-events-auto', 'opacity-100');
            }, 300);
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeBtn.click();
            }
        });
    </script>
</div>
