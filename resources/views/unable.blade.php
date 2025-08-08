<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Account Rejected</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
  <div class="bg-white max-w-md w-full p-8 rounded-2xl shadow-xl text-center">
    <div class="mb-6">
      <svg class="mx-auto h-16 w-16 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M19.07 4.93L4.93 19.07" />
      </svg>
    </div>
    <h1 class="text-2xl font-bold text-red-600 mb-4">Account Rejected</h1>
    <p class="text-gray-700 mb-4">
      Your account has been <span class="font-semibold">rejected</span> because it does not comply with our system's rules and regulations.
    </p>
    <p class="text-sm text-gray-600 mb-4">
      This may be due to providing inaccurate or incomplete information, attempting to bypass verification, or engaging in activity that violates our terms of service.
    </p>
    <p class="text-sm text-gray-600 mb-6">
      Please review our <a href="#" class="text-blue-500 underline">User Policy</a> and <a href="#" class="text-blue-500 underline">Terms of Service</a> for more details.
    </p>
    <a href="/contact-support" class="inline-block bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition">
      Contact Support
    </a>
  </div>
</body>
</html>
