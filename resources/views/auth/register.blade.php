<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BruFuel Registration</title>
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

    <div class="text-center mb-8">
      <div class="relative mx-auto w-20 h-20 rounded-full flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/logo4.jpg') }}" 
      </div>
      <h1 class="text-3xl font-bold text-white">BruFuel</h1>
      <p class="text-gray-300 mt-2">Create a new account</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
      @csrf

      <div>
        <label for="name" class="block text-sm font-medium text-gray-200 mb-1">Full Name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required
               class="w-full px-4 py-3 rounded-lg border border-gray-500 bg-[#2b3a5c] text-white placeholder-gray-400 input-focus focus:ring-2 focus:ring-indigo-500"
               placeholder="John Doe">
        @error('name')
          <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Email Address</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required
               class="w-full px-4 py-3 rounded-lg border border-gray-500 bg-[#2b3a5c] text-white placeholder-gray-400 input-focus focus:ring-2 focus:ring-indigo-500"
               placeholder="you@brufuel.com">
        @error('email')
          <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-200 mb-1">Password</label>
        <input id="password" name="password" type="password" required
               class="w-full px-4 py-3 rounded-lg border border-gray-500 bg-[#2b3a5c] text-white placeholder-gray-400 input-focus focus:ring-2 focus:ring-indigo-500"
               placeholder="••••••••">
        @error('password')
          <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-200 mb-1">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required
               class="w-full px-4 py-3 rounded-lg border border-gray-500 bg-[#2b3a5c] text-white placeholder-gray-400 input-focus focus:ring-2 focus:ring-indigo-500"
               placeholder="••••••••">
      </div>

      <button type="submit"
        class="w-full py-3 px-4 rounded-lg text-sm font-medium text-white bg-[#2563EB] hover:bg-[#1E40AF] focus:ring-2 focus:ring-offset-2 focus:ring-[#2563EB] transition duration-200">
        Register
      </button>

      <p class="text-center text-gray-300 text-sm mt-4">
        Already have an account?
        <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300">Sign in</a>
      </p>
    </form>

    <div class="mt-6 text-center">
      <p class="text-xs text-gray-400">© 2025 BruFuel. All rights reserved.</p>
    </div>
  </div>

  <script>AOS.init();</script>
</body>
</html>
