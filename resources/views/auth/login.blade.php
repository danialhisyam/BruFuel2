<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BruFuel Login</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <style>
    .gradient-bg { background: linear-gradient(135deg, #0d1117 0%, #111827 100%); }
    .input-focus:focus { box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.4); }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center gradient-bg">
  <div class="w-full max-w-md px-8 py-10 rounded-2xl shadow-2xl"
       style="background: linear-gradient(135deg, #151b29ff 0%, #040e23c7 100%);"
       data-aos="fade-up" data-aos-duration="800">

    <!-- Header -->
    <div class="text-center mb-8">
      <img src="{{ asset('images/logook.jpg') }}" class="mx-auto w-24 h-24 object-contain mb-4" alt="BruFuel Logo">
      <h1 class="text-3xl font-bold text-white">BruFuel</h1>
      <p class="text-gray-300 mt-2">Sign in to your account</p>
    </div>

    <!-- ✅ Laravel Fortify Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
      @csrf

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Email Address</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
               class="w-full px-4 py-3 rounded-lg border border-gray-500 bg-[#2b3a5c] text-white placeholder-gray-400 input-focus focus:ring-2 focus:ring-indigo-500"
               placeholder="Email">
        @error('email')
          <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password -->
      <div>
        <div class="flex justify-between items-center mb-1">
          <label for="password" class="block text-sm font-medium text-gray-200">Password</label>
          <a href="{{ route('password.request') }}" class="text-xs text-yellow-400">Forgot password?</a>
        </div>
        <input id="password" name="password" type="password" required
               class="w-full px-4 py-3 rounded-lg border border-gray-500 bg-[#2b3a5c] text-white placeholder-gray-400 input-focus focus:ring-2 focus:ring-indigo-500"
               placeholder="••••••••">
        @error('password')
          <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Remember Me -->
      <div class="flex items-center">
        <input id="remember-me" name="remember" type="checkbox"
               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
        <label for="remember-me" class="ml-2 block text-xs text-yellow-400">Remember me</label>
      </div>

      <!-- Submit -->
      <button type="submit"
        class="w-full py-3 px-4 rounded-lg text-sm font-medium text-white bg-[#7F1D1D] hover:bg-[#991B1B] focus:ring-2 focus:ring-offset-2 focus:ring-[#991B1B] transition duration-200">
        Sign in
      </button>

      <!-- Register -->
      <p class="text-center text-gray-300 text-sm mt-4">
        Don’t have an account?
        <a href="{{ route('register') }}" class="text-yellow-400 hover:text-yellow-300">Register here</a>
      </p>
    </form>

    <div class="mt-6 text-center">
      <p class="text-xs text-gray-400">© 2025 BruFuel. All rights reserved.</p>
    </div>
  </div>

  <script>AOS.init();</script>
</body>
</html>
