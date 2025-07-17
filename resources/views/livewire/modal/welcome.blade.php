  <!-- Modal backdrop -->
  <div id="modalBackdrop1"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300 ease-in-out opacity-100">
      <!-- Modal -->
      <div id="modal"
          class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 transform transition-transform duration-300 ease-in-out scale-100 opacity-100">
          <h2 class="text-xl font-semibold mb-4">Welcome!</h2>
          <p class="mb-6">Your Account is successfully Update.</p>
          <a href="/" id="closeBtn1"
              class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400">
              Close
          </a>
      </div>
      <script>
          // Get elements
          const modalBackdrop1 = document.getElementById('modalBackdrop1');
          const modal = document.getElementById('modal');
          const closeBtn1 = document.getElementById('closeBtn1');

          // Close modal function with transition
          function closeModal1() {
              // Animate modal fade out + scale down
              modal.classList.remove('opacity-100', 'scale-100');
              modal.classList.add('opacity-0', 'scale-90');
              modalBackdrop1.classList.remove('opacity-100');
              modalBackdrop1.classList.add('opacity-0');

              // After transition, hide modal completely
              setTimeout(() => {
                  modalBackdrop1.style.display = 'none';
              }, 300); // same as transition duration
              location.href = '/';
          }

          // Close on button click
          closeBtn1.addEventListener('click', closeModal1);
      </script>
  </div>
