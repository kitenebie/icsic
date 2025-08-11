<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Irosin Central School @ Password Verification</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .pw-input { width: 100%; }
    .meter {
      height: 8px;
      border-radius: 999px;
      background: #e6e6e6;
      overflow: hidden; 
    }
    .meter > span {
      display: block;
      height: 100%;
      width: 0%;
      transition: width .25s ease;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-2">Create your password</h1>
    <p class="text-sm text-gray-500 mb-6">Make sure it's strong — you'll use this to verify your account.</p>

    <form id="pwForm" class="space-y-4" novalidate>
      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <div class="relative">
          <input id="password" type="password" class="pw-input border border-gray-200 rounded-lg px-4 py-2 pr-12 focus:outline-none focus:ring-2 focus:ring-emerald-300" autocomplete="new-password" required />
          <button type="button" id="togglePw" class="absolute right-2 top-1/2 -translate-y-1/2 text-sm text-gray-600 hover:text-gray-800">Show</button>
        </div>
      </div>

      <!-- Strength meter -->
      <div class="space-y-1">
        <div class="flex justify-between text-xs text-gray-500">
          <span>Password strength</span>
          <span id="strengthText">—</span>
        </div>
        <div class="meter">
          <span id="strengthBar" class="bg-red-500"></span>
        </div>
      </div>

      <!-- Confirm Password -->
      <div>
        <label for="confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirm password</label>
        <div class="relative">
          <input id="confirm" type="password" class="pw-input border border-gray-200 rounded-lg px-4 py-2 pr-12 focus:outline-none focus:ring-2 focus:ring-emerald-300" autocomplete="new-password" required />
          <button type="button" id="toggleConfirm" class="absolute right-2 top-1/2 -translate-y-1/2 text-sm text-gray-600 hover:text-gray-800">Show</button>
        </div>
        <p id="matchText" class="text-xs mt-2"></p>
      </div>

      <!-- Submit -->
      <div class="pt-2">
        <button type="submit" class="w-full px-4 py-2 bg-emerald-500 text-white rounded-lg shadow hover:brightness-95">Set password</button>
      </div>
    </form>
  </div>

<script>
  const pw = document.getElementById('password');
  const cf = document.getElementById('confirm');
  const togglePw = document.getElementById('togglePw');
  const toggleCf = document.getElementById('toggleConfirm');
  const strengthBar = document.getElementById('strengthBar');
  const strengthText = document.getElementById('strengthText');
  const matchText = document.getElementById('matchText');
  const form = document.getElementById('pwForm');

  const rules = {
    length: /.{8,}/,
    upper: /[A-Z]/,
    number: /[0-9]/,
    special: /[!@#\$%\^&\*(),.?":{}|<>\-\[\]\/\+=~`]/
  };

  function toggleVisibility(input, btn) {
    if (input.type === 'password') {
      input.type = 'text';
      btn.textContent = 'Hide';
    } else {
      input.type = 'password';
      btn.textContent = 'Show';
    }
  }
  togglePw.addEventListener('click', () => toggleVisibility(pw, togglePw));
  toggleCf.addEventListener('click', () => toggleVisibility(cf, toggleCf));

  function calcStrength(value) {
    let score = 0;
    if (rules.length.test(value)) score++;
    if (rules.upper.test(value)) score++;
    if (rules.number.test(value)) score++;
    if (rules.special.test(value)) score++;
    return score;
  }

  function updateStrengthUI() {
    const val = pw.value;
    const score = calcStrength(val);
    const pct = (score / 4) * 100;
    strengthBar.style.width = pct + '%';
    if (score <= 1) {
      strengthBar.className = 'bg-red-500';
      strengthText.textContent = 'Weak';
    } else if (score === 2) {
      strengthBar.className = 'bg-yellow-400';
      strengthText.textContent = 'Fair';
    } else if (score === 3) {
      strengthBar.className = 'bg-emerald-400';
      strengthText.textContent = 'Good';
    } else {
      strengthBar.className = 'bg-green-600';
      strengthText.textContent = 'Strong';
    }
  }

  function updateMatchUI() {
    if (!cf.value && !pw.value) {
      matchText.textContent = '';
      return;
    }
    if (pw.value === cf.value) {
      matchText.textContent = 'Passwords match';
      matchText.className = 'text-xs mt-2 text-green-600';
    } else {
      matchText.textContent = 'Passwords do not match';
      matchText.className = 'text-xs mt-2 text-red-600';
    }
  }

  pw.addEventListener('input', () => {
    updateStrengthUI();
    updateMatchUI();
  });
  cf.addEventListener('input', updateMatchUI);

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    const value = pw.value;
    const confirm = cf.value;
    const problems = [];

    if (!rules.length.test(value)) problems.push('At least 8 characters');
    if (!rules.upper.test(value)) problems.push('One uppercase letter');
    if (!rules.number.test(value)) problems.push('One number');
    if (!rules.special.test(value)) problems.push('One special character');
    if (value !== confirm) problems.push('Passwords must match');

    if (problems.length > 0) {
      Swal.fire({
        icon: 'error',
        title: 'Fix these first',
        html: '<ul style="text-align:left;">' + problems.map(p => `<li>• ${p}</li>`).join('') + '</ul>'
      });
      return;
    }

    Swal.fire({
      title: 'Verifying password...',
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading()
    });

    fetch(`/verify/${encodeURIComponent(value)}`, {
      method: 'GET',
      headers: { 'Accept': 'application/json' }
    })
    .then(async res => {
      if (!res.ok) {
        const errorText = await res.text();
        throw new Error(errorText || 'Verification failed.');
      }
      return res.json();
    })
    .then(data => {
      Swal.fire({
        icon: 'success',
        title: 'Verified',
        text: data.message || 'Password is correct!'
      }).then(() => {
        location.href = '/';
      });
    })
    .catch(err => {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: err.message || 'Something went wrong.'
      });
    });
  });
</script>
</body>
</html>
