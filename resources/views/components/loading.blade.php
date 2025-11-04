<style>
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.spinner {
    width: 64px;
    height: 64px;
    border: 4px solid #a0522d;
    border-top: 4px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
</style>
<div style="z-index: 9999" id="loadingIndicator" class="fixed inset-0 flex items-center justify-center bg-brown-100">
    <div class="flex flex-col items-center space-y-4">
        <!-- Spinner -->
        <div class="spinner"></div>
        <!-- Loading Text -->
        <p class="text-brown-700 text-lg font-medium">Loading, please wait...</p>
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        const loadingIndicator = document.getElementById('loadingIndicator');
        loadingIndicator.classList.add('hidden');
    });
    
</script>