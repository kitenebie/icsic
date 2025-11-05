@if (env('NOT_PAID') == true)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="paymentOverlay" style="display: none;">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full mx-4">
        <h2 class="text-xl font-bold mb-4">Payment Section</h2>
        <p class="mb-4">Please complete your payment using GCash.</p>
        <img src="/gcash.jpg" alt="GCash Logo" class="w-32 h-32 mx-auto mb-4">
    </div>
</div>

<script>
    function closePaymentOverlay() {
        document.getElementById('paymentOverlay').style.display = 'none';
    }
</script>
    
@endif