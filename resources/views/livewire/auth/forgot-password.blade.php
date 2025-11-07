<div class="min-h-screen flex items-center justify-center bg-[#0A0F1D] text-white font-[Poppins]">
  <div class="w-full max-w-md bg-[#0F172A] rounded-3xl shadow-2xl border border-white/10 px-8 py-10 text-center">

    <!-- ✅ Logo -->
    <div class="flex justify-center mb-5">
      <img src="{{ asset('images/Logook.png') }}" alt="BruFuel Logo" class="w-20 h-20 rounded-full">
    </div>

    <!-- ✅ Title -->
    <h1 class="text-3xl font-bold mb-1 text-white">BruFuel</h1>
    <p class="text-gray-400 mb-8">Forgot your password?</p>

    <!-- ✅ Status Message -->
    @if (session('status'))
      <div class="bg-green-500/10 text-green-400 text-sm px-4 py-2 rounded-lg mb-5 border border-green-500/20">
        {{ session('status') }}
      </div>
    @endif

    <!-- ✅ Form -->
    <form wire:submit.prevent="sendPasswordResetLink" class="space-y-6 text-left">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Email Address</label>
        <input
          id="email"
          type="email"
          wire:model.defer="email"
          placeholder="Email"
          class="w-full px-4 py-3 rounded-lg bg-[#1E293B] text-white placeholder-gray-400 border border-white/10 focus:outline-none focus:ring-2 focus:ring-yellow-400"
        />
        @error('email')
          <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- ✅ Red Button -->
      <button
        type="submit"
        class="w-full bg-[#991B1B] hover:bg-[#7F1D1D] text-white font-semibold py-3 rounded-lg transition duration-200">
        Send Reset Link
      </button>
    </form>

    <!-- ✅ Back to login -->
    <div class="mt-6 text-center text-sm">
      <a href="{{ route('login') }}" class="text-yellow-400 hover:underline">
        ← Back to login
      </a>
    </div>

    <!-- ✅ Footer -->
    <p class="text-gray-500 text-xs mt-8">
      © {{ now()->year }} BruFuel. All rights reserved.
    </p>
  </div>
</div>

