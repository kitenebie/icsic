<!-- FormModal Overlay -->
<div id="Formmodal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 invisible opacity-0 transition-opacity duration-300">
    <!-- FormModal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 transform scale-95 transition-transform duration-300 opacity-0"
        id="FormmodalContent">

        <!-- FormModal Header -->
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">Request Document</h2>
            <p class="text-gray-600">Select the type of document you want to request below.</p>
        </div>

        <!-- Document Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">

            <!-- Card Template -->
            <button type="button" wire:click.prevent='selectCategory({{ 0 }})' onclick="openRequestFrom137()"
                class="border border-gray-200 rounded-lg p-4 transition hover:border-green-500 hover:shadow-md cursor-pointer">
                <div class="flex flex-col items-center text-center">
                    <div class="text-green-500 mb-2">
                        <!-- Icon: Academic Cap -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l6.16-3.422A12.042 12.042 0 0118 20H6a12.042 12.042 0 01-.16-9.422L12 14z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Form 137</h3>
                    <p class="text-sm text-gray-600">Official record of grades from previous years.</p>
                </div>
            </button>

            <!-- Form 138 -->
            <button type="button" wire:click.prevent='selectCategory({{ 1 }})'
                onclick="openRequestFrom137()"
                class="border border-gray-200 rounded-lg p-4 transition hover:border-green-500 hover:shadow-md cursor-pointer">
                <div class="flex flex-col items-center text-center">
                    <div class="text-green-500 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5h6m2 2H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V9a2 2 0 00-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Form 138</h3>
                    <p class="text-sm text-gray-600">Report card showing student’s current academic year performance.
                    </p>
                </div>
            </button>

            <!-- Good Moral Certificate -->
            <button type="button" wire:click.prevent='selectCategory({{ 2 }})'
                onclick="openRequestFrom137()"
                class="border border-gray-200 rounded-lg p-4 transition hover:border-green-500 hover:shadow-md cursor-pointer">
                <div class="flex flex-col items-center text-center">
                    <div class="text-green-500 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2l4-4m1-6H8a2 2 0 00-2 2v2a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2zM5 13v6a2 2 0 002 2h10a2 2 0 002-2v-6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Good Moral Certificate</h3>
                    <p class="text-sm text-gray-600">Proof of exemplary behavior and conduct.</p>
                </div>
            </button>
            <!-- Requested Forms -->
            <div></div>
            <button role="button" onclick="toggleStatusFormModal(true)"
                class="border cursor-pointer border-green-300 bg-green-50 rounded-lg p-4 transition hover:border-green-500 hover:shadow-md cursor-default">
                <div class="flex flex-col items-center text-center">
                    <div class="text-green-600 mb-2">
                        <!-- Icon: Document Check -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2l4-4m1-6H8a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Requested Forms</h3>
                    <p class="text-sm text-gray-600">You’ve already requested 2 documents. Waiting for approval.</p>
                </div>
            </button>
            <div></div>

        </div>

        <!-- Close Button -->
        <div class="mt-6 text-center">
            <button onclick="toggleFormModal(false)"
                class="mt-4 px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                Close
            </button>
        </div>

    </div>
</div>
<!-- JavaScript -->
<script>
    function toggleFormModal(show) {
        const Formmodal = document.getElementById("Formmodal");
        const FormmodalContent = document.getElementById("FormmodalContent");

        if (show) {
            Formmodal.classList.remove("invisible", "opacity-0");
            setTimeout(() => {
                FormmodalContent.classList.remove("scale-95", "opacity-0");
            }, 10);
        } else {
            FormmodalContent.classList.add("scale-95", "opacity-0");
            setTimeout(() => {
                Formmodal.classList.add("invisible", "opacity-0");
            }, 300);
        }
    }
</script>
