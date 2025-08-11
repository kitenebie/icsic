<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Irosin Central School @ One-Time Password</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- SweetAlert2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .otp-input {
      @apply border border-gray-200 focus:border-emerald-400 focus:ring-0 rounded-lg text-center font-medium;
      width: 3.5rem; /* ~56px */
      height: 3.5rem;
      font-size: 1.25rem;
    }
    @media (max-width: 640px) {
      .otp-input {
        width: 2.75rem;
        height: 2.75rem;
        font-size: 1.125rem;
      }
    }
    @media (min-width: 1024px) {
      .otp-input {
        width: 4rem;
        height: 4rem;
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4 py-6">
  <div class="w-full max-w-sm sm:max-w-md bg-white rounded-2xl shadow-lg p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-2">Verify your account</h1>
    <p class="text-sm text-gray-500 mb-6">Enter the 6-digit code we sent. Check your phone or email.</p>

    <div class="flex flex-wrap justify-center gap-3 mb-4" id="otp-fields"></div>

    <div class="flex flex-col sm:flex-row gap-3 justify-center mb-2">
      <button id="verifyBtn" class="flex-1 px-4 py-2 bg-emerald-500 text-white rounded-lg shadow hover:brightness-95">Verify</button>
      <button id="resendBtn" class="flex-1 px-4 py-2 bg-yellow-400 text-gray-800 rounded-lg shadow hover:brightness-95">Resend</button>
    </div>

    <p class="text-xs text-gray-400 text-center" id="timerText"></p>
  </div>

<script>
  // Show loading when DOM starts loading
  document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
      title: 'Loading...',
      text: 'Please wait while we send the OTP',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });
  });

  // Close loading when everything is fully loaded
  window.addEventListener('load', () => {
    Swal.close();
  });
</script>

<script>
const OTP_LENGTH = 6;
const RESEND_DELAY = 30; // seconds
const otpContainer = document.getElementById('otp-fields');
const verifyBtn = document.getElementById('verifyBtn');
const resendBtn = document.getElementById('resendBtn');
const timerText = document.getElementById('timerText');
let timerInterval = null;

function createOtpInputs() {
  otpContainer.innerHTML = '';
  for (let i = 0; i < OTP_LENGTH; i++) {
    const input = document.createElement('input');
    input.type = 'text';
    input.inputMode = 'numeric';
    input.maxLength = 1;
    input.className = 'otp-input';
    input.autocomplete = 'one-time-code';
    input.dataset.index = i;
    input.addEventListener('input', onOtpInput);
    input.addEventListener('keydown', onOtpKeyDown);
    input.addEventListener('paste', onOtpPaste);
    otpContainer.appendChild(input);
  }
}

function onOtpInput(e) {
  const el = e.target;
  const val = el.value.replace(/\D/g,'');
  el.value = val;
  if (val && el.nextElementSibling) {
    el.nextElementSibling.focus();
  }
}

function onOtpKeyDown(e) {
  const el = e.target;
  const idx = Number(el.dataset.index);
  if (e.key === 'Backspace' && !el.value && idx > 0) {
    const prev = otpContainer.querySelector(`input[data-index="${idx-1}"]`);
    prev.focus();
    prev.value = '';
    e.preventDefault();
  }
  if (e.key === 'ArrowLeft' && idx > 0) {
    otpContainer.querySelector(`input[data-index="${idx-1}"]`).focus();
    e.preventDefault();
  }
  if (e.key === 'ArrowRight' && idx < OTP_LENGTH-1) {
    otpContainer.querySelector(`input[data-index="${idx+1}"]`).focus();
    e.preventDefault();
  }
}

function onOtpPaste(e) {
  e.preventDefault();
  const text = (e.clipboardData || window.clipboardData).getData('text');
  const digits = text.replace(/\D/g,'').slice(0,OTP_LENGTH).split('');
  const inputs = otpContainer.querySelectorAll('input');
  for (let i=0; i<OTP_LENGTH; i++){
    inputs[i].value = digits[i] ?? '';
  }
  const lastIndex = Math.min(digits.length, OTP_LENGTH) - 1;
  (inputs[lastIndex >= 0 ? lastIndex : 0]).focus();
}

function verifyOtpInput() {
  const inputs = otpContainer.querySelectorAll('input');
  const entered = Array.from(inputs).map(i => i.value || '').join('');

  if (entered.length !== OTP_LENGTH) {
    Swal.fire({ icon: 'error', title: "Incomplete", text: "Please enter the full 6-digit code." });
    return;
  }
  if (!/^\d{6}$/.test(entered)) {
    Swal.fire({ icon: 'error', title: "Invalid", text: "Only digits are allowed." });
    return;
  }
  
  fetch(`/verify/otp/${entered}`, {
    method: 'GET',
    headers: { 'Accept': 'application/json' }
  })
  .then(data => {
    Swal.fire({
      title: 'Validating...',
      text: 'Please wait while we check the OTP',
      allowOutsideClick: false,
    });
    location.href="/login";
  })
  .catch(err => {
    Swal.fire({ icon: 'error', title: "Error", text: err.message || "Something went wrong." });
  });
}

function startTimer(seconds) {
  clearInterval(timerInterval);
  resendBtn.disabled = true;
  resendBtn.classList.add('opacity-50', 'cursor-not-allowed');
  let remaining = seconds;

  timerText.textContent = `You can resend code in ${remaining}s`;
  timerInterval = setInterval(() => {
    remaining--;
    if (remaining <= 0) {
      clearInterval(timerInterval);
      resendBtn.disabled = false;
      resendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
      timerText.textContent = "You can resend the code now.";
    } else {
      timerText.textContent = `You can resend code in ${remaining}s`;
    }
  }, 1000);
}

verifyBtn.addEventListener('click', verifyOtpInput);
resendBtn.addEventListener('click', () => {
  Swal.fire({ icon: 'info', title: "Resend clicked", text: "Trigger your resend API here." });
  startTimer(RESEND_DELAY);
});

createOtpInputs();
otpContainer.querySelector('input').focus();
</script>
</body>
</html>
