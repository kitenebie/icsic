<!-- Modal Wrapper -->
<div x-data="{ showModal: false }" 
     x-init="@if (session('invalidRequest') || session('success')) showModal = true @endif">

    <!-- Modal Overlay -->
    <div 
        x-show="showModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
        <!-- Modal Content -->
        <div 
            x-show="showModal"
            x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition transform ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative"
        >
            <!-- Close Button -->
            <button @click="showModal = false" 
                class="absolute top-2 w-[2.3rem] h-[2.3rem] bg-red-500 rounded-full shadow-lg  right-2 text-gray-50 hover:bg-red-700">
                ✕
            </button>

            <!-- Modal Body -->
            @if (session('invalidRequest'))
                <div class="bg-red-100 p-4 rounded-md">
                    <p class="font-bold mb-2 text-red-700">Some students already have existing requests:</p>
                    <ul class="list-disc pl-5 text-red-800">
                        @foreach (session('invalidRequest') as $item)
                            <li>{{ $item['student_name'] }} - Type: <strong>@switch($item['document_type'])
                                @case(0)
                                    FORM 137
                                @break

                                @case(1)
                                    FORM 138
                                @break

                                @case(2)
                                    Cert. of Good Moral
                                @break

                                @default
                            @endswitch </strong></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 p-4 rounded-md text-green-800">
                    ✅ {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</div>
