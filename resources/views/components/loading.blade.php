<div style="z-index: 9999" id="loadingIndicator" class="fixed inset-0 flex items-center justify-center bg-white">
    <div class="flex flex-col items-center space-y-4">
        <!-- Spinner -->
        <div class="w-16 h-16 border-4 border-green-500 border-t-transparent rounded-full animate-spin"></div>
        <!-- Loading Text -->
        <p class="text-gray-700 text-lg font-medium">Loading, please wait...</p>
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        const loadingIndicator = document.getElementById('loadingIndicator');
        loadingIndicator.classList.add('hidden');
    });
    
</script>