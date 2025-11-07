<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Driver Portal Login - BruFuel</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-50 to-blue-100 min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-8">
    <!-- Logo/Icon -->
    <div class="flex justify-center mb-4">
      <div class="bg-blue-600 p-4 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 13h18M5 10l1.5-4.5A1 1 0 017.47 5h9.06a1 1 0 01.97.5L19 10m-9 8h4m-9 0h14a1 1 0 001-1v-5H3v5a1 1 0 001 1z" />
        </svg>
      </div>
    </div>

    <!-- Header -->
    <h1 class="text-center text-2xl font-bold text-gray-800">BruFuel Driver Portal</h1>
    <p class="text-center text-gray-500 mb-6">Login to access your account</p>

    <!-- Login Form -->
    <form method="POST" action="{{ route('driver.login.submit') }}" class="space-y-5">
      @csrf

      @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
          {{ $errors->first() }}
        </div>
      @endif

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 12H8m8 0H8m8 0V6a2 2 0 00-2-2H8a2 2 0 00-2 2v6m0 0v6a2 2 0 002 2h6a2 2 0 002-2v-6" />
            </svg>
          </span>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                 placeholder="driver@example.com"
                 class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2v2h4v-2zM5 13V9a7 7 0 0114 0v4" />
            </svg>
          </span>
          <input type="password" id="password" name="password" required
                 placeholder="••••••••"
                 class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
      </div>

      <!-- Remember Me & Forgot -->
      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center">
          <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
          <span class="ml-2 text-gray-600">Remember me</span>
        </label>
        <a href="#" class="text-blue-600 hover:text-blue-700">Forgot password?</a>
      </div>

      <!-- Submit Button -->
      <button type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition-all duration-200">
        Sign In
      </button>
    </form>

    <!-- Divider -->
    <div class="mt-6 border-t pt-4 text-center text-gray-500 text-sm">
      New to BruFuel? <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Register here</a>
    </div>
  </div>
</body>
</html>
