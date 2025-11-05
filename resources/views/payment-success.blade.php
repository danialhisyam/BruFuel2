<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment Success</title>

  {{-- Tailwind & Font --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#000A1F] flex items-center justify-center min-h-screen font-[Poppins]">

  <!-- iPhone Frame -->
  <div class="relative w-[430px] h-[932px] bg-[#000A1F] flex justify-center items-center scale-100 md:scale-90 sm:scale-75 origin-top transition-transform">

    <!-- White Success Box -->
    <div class="bg-white w-[360px] rounded-3xl shadow-2xl px-8 py-10 text-center">
      
      <!-- Success Icon -->
      <div class="flex justify-center mb-6">
        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="#00C853" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
        </div>
      </div>

      <!-- Text -->
      <h1 class="text-2xl font-bold text-black">Payment Success!</h1>
      <p class="text-gray-500 text-sm mt-1">Your payment has been successfully processed.</p>

      <!-- Dynamic Details -->
      <div class="mt-6 text-left space-y-2 text-gray-700 text-sm">
        <div class="flex justify-between"><span>Ref Number</span><span class="font-medium">#{{ str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT) }}</span></div>
        <div class="flex justify-between"><span>Payment Method</span><span class="font-medium">{{ ucfirst(session('payment_method', 'N/A')) }}</span></div>
        <div class="flex justify-between"><span>Payment Time</span><span class="font-medium">{{ now()->format('H:i:s') }}</span></div>
        <div class="flex justify-between"><span>Sender Name</span><span class="font-medium">{{ session('payer_name', 'Unknown') }}</span></div>
      </div>

      <!-- Total -->
      <div class="mt-8 border-t border-gray-200 pt-4 flex justify-between text-lg font-semibold text-black">
        <span>Total Payment</span>
        <span>B${{ number_format($amount, 2) }}</span>
      </div>

      <!-- Back Button -->
      <a href="{{ route('checkout') }}" 
         class="mt-8 inline-block bg-[#0A0F1D] text-white py-3 px-8 rounded-full font-medium hover:bg-[#00194A] transition">
        Continue
      </a>
    </div>
  </div>
</body>
</html>
