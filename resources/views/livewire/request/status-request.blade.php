<!-- Modal HTML -->
<div id="statusModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 opacity-0 invisible transition-opacity duration-300">

    <style>
        .hide-scrollbar {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari and Opera */
        }
    </style>
    <div id="statusModalContent"
        class="bg-white rounded-lg shadow-lg max-h-screen overflow-y-auto w-full max-w-2xl p-6 transform scale-95 opacity-0 transition-transform duration-300 relative hide-scrollbar">

        <!-- ❌ Close Button -->
        <button onclick="toggleStatusFormModal(false)"
            class="absolute top-4 right-4 text-gray-500 hover:text-red-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- 🧾 Modal Header -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Request Status</h2>
        <!-- 🧩 Requests Section -->
        <div class="flex flex-col gap-6">

            <!-- ⏳ Pending Requests -->
            <div class="@if ($pending->count() === 0) hidden @endif">
                <h3 class="text-lg font-semibold text-yellow-600 mb-2">Pending Requests</h3>
                @forelse ($pending as $pendingReq)
                    <div class="bg-yellow-50 border mb-2 border-yellow-300 rounded p-4">
                        <p class="py-2">Type: <strong>@switch($pendingReq->document_type)
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
                            @endswitch </strong>- Awaiting approval</p>
                        <p class="py-2">Student: {{ $pendingReq->student_name }}</p>
                        <p class="py-2 rounded-md border-yellow-100 border-2 bg-yellow-100"><strong>Reason: </strong> {{ $pendingReq->reason }}</p>
                        <p class="py-2">Requested Date:
                            {{ \Carbon\Carbon::parse($pendingReq->created_at)->format('F jS, Y @ H:i A') }}</p>
                    </div>
                    @empty
                    @endforelse
                </div>

                <!-- ✅ Approved Requests -->
                <div class="@if ($approved->count() === 0) hidden @endif">
                    <h3 class="text-lg font-semibold text-green-600 mb-2">Approved Requests</h3>
                    <div class="bg-green-50 border border-green-300 rounded p-4 space-y-3">
                        <!-- Approved Item 1 -->
                        <div class="flex-col items-center justify-between">
                            @forelse ($approved as $approvedReq)
                                <p class="py-2">Type: <strong>
                                        @switch($approvedReq->document_type)
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
                                        @endswitch
                                    </strong>- Approved on
                                    {{ \Carbon\Carbon::parse($approvedReq->updated_at)->format('F jS, Y @ H:i A') }}</p>
                                <p class="py-2">Student: {{ $approvedReq->student_name }}</p>
                                <p class="py-2 rounded-md border-green-100 border-2 bg-green-100"><strong>Reason: </strong> {{ $approvedReq->reason }}</p>
                                <p class="py-2">Requested Date:
                                    {{ \Carbon\Carbon::parse($approvedReq->created_at)->format('F jS, Y @ H:i A') }}</p>
                                <button onclick="startDownload('/storage/{{ $approvedReq->document_path }}')"
                                    class="flex mt-2 bg-green-500 px-4 py-2 items-center text-white hover:bg-green-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                                    </svg>
                                    <span class="text-sm">Download</span>
                                </button>
                                @empty
                                @endforelse
                            </div>

                            <!-- Progress Bar Container -->
                            <div id="downloadProgressContainer" class="hidden mt-6">
                                <h3 class="text-md font-semibold text-green-600 mb-2 flex items-center gap-2">
                                    <!-- File Icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 2v6h6" />
                                    </svg>
                                    Download Progress
                                </h3>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="downloadProgressBar" class="bg-green-600 h-2 rounded"
                                        style="width: 0%; transition: width 0.3s ease;"></div>
                                </div>
                                <p id="downloadPercent" class="text-center hidden text-white text-[12px] mt-1">0%</p>
                            </div>
                            <hr>

                        </div>
                    </div>


            <!-- ⏳ Pending Requests -->
            <div class="@if ($rejected->count() === 0) hidden @endif">
                <h3 class="text-lg font-semibold text-red-600 mb-2">Rejected Requests</h3>
                @forelse ($rejected as $rejectedReq)
                    <div class="bg-red-50 border mb-2 border-red-300 rounded p-4">
                        <p class="py-2">Type: <strong>@switch($rejectedReq->document_type)
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
                            @endswitch </strong>- Awaiting approval</p>
                        <p class="py-2">Student: {{ $rejectedReq->student_name }}</p>
                        <p class="py-2 rounded-md border-red-100 border-2 bg-red-100"><strong>Reason: </strong> {{ $rejectedReq->reason }}</p>
                        <p class="py-2">Requested Date:
                            {{ \Carbon\Carbon::parse($rejectedReq->created_at)->format('F jS, Y @ H:i A') }}</p>
                    </div>
                    @empty
                    @endforelse
                </div>

                </div>
                </>
            </div>

            <script>
                function toggleStatusFormModal(show) {
                    const modal = document.getElementById('statusModal');
                    const content = document.getElementById('statusModalContent');

                    if (show) {
                        modal.classList.remove('opacity-0', 'invisible');
                        setTimeout(() => {
                            content.classList.remove('scale-95', 'opacity-0');
                        }, 10);
                    } else {
                        content.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            modal.classList.add('opacity-0', 'invisible');
                            resetProgressBar();
                        }, 300);
                    }
                }

                function resetProgressBar() {
                    const progressContainer = document.getElementById('downloadProgressContainer');
                    const progressBar = document.getElementById('downloadProgressBar');
                    const percentText = document.getElementById('downloadPercent');

                    progressBar.style.width = '0%';
                    percentText.textContent = '0%';
                    progressContainer.classList.add('hidden');

                    // Re-enable buttons if needed
                    const downloadButtons = document.querySelectorAll('button.flex.items-center.text-green-600');
                    downloadButtons.forEach(btn => btn.disabled = false);
                }

                async function startDownload(fileUrl) {
                    toggleStatusFormModal(true);

                    const progressContainer = document.getElementById('downloadProgressContainer');
                    progressContainer.classList.remove('hidden');

                    const progressBar = document.getElementById('downloadProgressBar');
                    const percentText = document.getElementById('downloadPercent');

                    progressBar.style.width = '0%';
                    percentText.textContent = '0%';

                    // Disable all download buttons while downloading
                    const downloadButtons = document.querySelectorAll('button.flex.items-center.text-green-600');
                    downloadButtons.forEach(btn => btn.disabled = true);

                    try {
                        const response = await fetch(fileUrl);
                        if (!response.ok) throw new Error('Network response was not ok');

                        const contentLength = response.headers.get('Content-Length');
                        if (!contentLength) throw new Error('Content-Length response header missing');

                        const total = parseInt(contentLength, 10);
                        let loaded = 0;

                        const reader = response.body.getReader();
                        const chunks = [];

                        while (true) {
                            const {
                                done,
                                value
                            } = await reader.read();
                            if (done) break;
                            chunks.push(value);
                            loaded += value.length;
                            const percent = Math.floor((loaded / total) * 100);
                            progressBar.style.width = percent + '%';
                            percentText.textContent = percent + '%';
                        }

                        // Combine chunks into a Blob
                        const blob = new Blob(chunks);

                        // Create a temporary URL to download
                        const downloadUrl = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = downloadUrl;

                        // Extract filename from URL or set a default name
                        const filename = fileUrl.split('/').pop() || 'download.pdf';
                        a.download = filename;

                        document.body.appendChild(a);
                        a.click();

                        // Clean up
                        a.remove();
                        window.URL.revokeObjectURL(downloadUrl);
                    } catch (error) {} finally {
                        // Enable buttons and reset progress bar after a delay
                        setTimeout(() => {
                            resetProgressBar();
                        }, 1500);
                    }
                }
            </script>
