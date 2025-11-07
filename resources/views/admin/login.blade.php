<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <style>
    /* Dashboard-like darker background gradient */
    .gradient-bg {
      background: linear-gradient(135deg, #0d1117 0%, #111827 100%);
    }

    /* Soft indigo focus ring that matches your scheme */
    .input-focus:focus {
      box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.4);
    }

    /* Ensure full height */
    html, body {
      height: 100%;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center gradient-bg">
  <div class="w-full max-w-md px-8 py-10 rounded-2xl shadow-2xl"
   style="background: linear-gradient(135deg, #151b29ff 0%, #040e23c7 100%);"
       data-aos="fade-up" data-aos-duration="800">

    <!-- Header -->
    <div class="text-center mb-8">
      <div class="mx-auto w-20 h-20 bg-black-100 rounded-full flex items-center justify-center mb-4">
        <img src="{{ asset('images/Logook.png') }}" class="w-20 h-20" alt="BruFuel Logo">
      </div>
      <h1 class="text-3xl font-bold text-white">BruFuel</h1>
      <p class="text-gray-300 mt-2">Sign In to your Admin Account</p>
    </div>

    <!-- Login Form -->
    <form class="space-y-6">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Email Address</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0l-4-4m0 8l4-4" />
            </svg>
          </div>
          <input id="email" name="email" type="email" required
                 class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-500 bg-[#2b3a5c] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 input-focus transition duration-200"
                 placeholder="admin@example.com">
        </div>
      </div>

      <div>
        <div class="flex justify-between items-center mb-1">
          <label for="password" class="block text-sm font-medium text-gray-200">Password</label>
          <a href="#" class="text-xs text-yellow-400">Forgot password?</a>
        </div>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2 .896 2 2 2 2-.896 2-2z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v10m-6-6h12" />
            </svg>
          </div>
          <input id="password" name="password" type="password" required
                 class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-500 bg-[#2b3a5c] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 input-focus transition duration-200"
                 placeholder="••••••••">
        </div>
      </div>

      <div class="flex items-center">
        <input id="remember-me" name="remember-me" type="checkbox"
               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
        <label for="remember-me" class="ml-2 block text-xs text-yellow-400">Remember me</label>
      </div>

      <div>
  <button type="submit"
    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#7F1D1D] hover:bg-[#991B1B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#991B1B] transition duration-200">
    Sign in
  </button>
</div>
    </form>

    <!-- Footer -->
    <div class="mt-6 text-center">
      <p class="text-xs text-gray-400">©️ 2025 Admin Portal. All rights reserved.</p>
    </div>
  </div>

    <script>
  AOS.init();

  document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (email && password) {
      // Redirect after successful validation
      window.location.href = "dashboard"; // or '/dashboard' for Laravel
    } else {
      alert('Please fill in all fields');
    }
  });
</script>

</body>
</html>
