<!-- Modal 2a: Graduate -->
<div id="graduateModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <form id="graduateForm"
        action="{{ route('graduate') }}"
        method="POST" id="graduateContent"
        class="bg-white rounded-lg p-6 max-w-md w-full transform scale-95 transition-all duration-300">
        @csrf
        <h2 class="text-xl font-semibold mb-4">Select Graduation Year <span class="text-red-500">*</span></h2>
        <select required class="w-full hover:border-2 hover:border-blue-400 border rounded px-4 py-2 mb-4">
            <option value="">Choose a year</option>
            <option>2025</option>
            <option>2024</option>
            <option>2023</option>
            <option>2022</option>
        </select>
        <div class="flex justify-between">
            <button onclick="goBackToUserType()"
                class="px-4 py-2 bg-yellow-400 text-white rounded hover:bg-yellow-500">Back</button>
            <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Continue</button>
        </div>
    </form>
</div>