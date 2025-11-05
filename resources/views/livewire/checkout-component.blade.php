<div class="flex items-center justify-center w-full px-4 py-10">
  <div class="w-full max-w-md bg-white text-gray-900 rounded-2xl p-6 shadow-[0_0_35px_rgba(0,0,0,0.5)] border border-[#1a2235]">

    <!-- Title -->
    <h1 class="text-center text-2xl font-semibold mb-6 text-[#0A0F1D] tracking-wide">
      Checkout
    </h1>

    <!-- Payment Methods -->
    <div class="mb-6">
      <label class="block text-xs font-semibold mb-2 text-gray-600 uppercase tracking-wider">Payment Method</label>
      <div class="flex flex-wrap items-center gap-2 text-gray-600 text-sm">
        <span>Visa</span>
        <span>•</span>
        <span>Mastercard</span>
        <span>•</span>
        <span>Cash</span>
      </div>
    </div>

    <!-- Credit/Debit Card Option -->
    <div class="mb-3">
      <label class="flex items-center space-x-2">
        <input type="radio" wire:model="method" value="card" class="text-blue-600 focus:ring-blue-400">
        <span class="text-sm font-medium">Credit/Debit Card</span>
      </label>
    </div>

    @if($method === 'card')
      <div class="space-y-3 mb-6">
        <input type="text" wire:model="card_number" placeholder="1234567812345678"
          class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600" />

        <input type="text" wire:model="name_on_card" placeholder="Name on Card"
          class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600" />

        <div class="flex space-x-3">
          <input type="text" wire:model="expiry" placeholder="MM/YY"
            class="w-1/2 border border-gray-300 bg-white rounded-lg p-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600" />
          <input type="text" wire:model="cvv" placeholder="CVV"
            class="w-1/2 border border-gray-300 bg-white rounded-lg p-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600" />
        </div>

        <label class="flex items-center text-xs space-x-2">
          <input type="checkbox" wire:model="remember" class="text-blue-600 focus:ring-blue-400">
          <span class="text-gray-600">Remember this card.</span>
        </label>
      </div>
    @endif

    <!-- Cash Option -->
    <div class="mb-8">
      <label class="flex items-center space-x-2">
        <input type="radio" wire:model="method" value="cash" class="text-blue-600 focus:ring-blue-400">
        <span class="text-sm font-medium">Cash</span>
      </label>
      <p class="text-xs text-gray-500 ml-6 mt-1">
      Please pay the driver with exact change.
      </p>
    </div>

    <!-- Total -->
    <div class="border-t border-gray-300 pt-4 mb-5">
      <div class="flex justify-between text-sm font-semibold tracking-wide text-gray-900">
        <span>Total</span>
        <span>B${{ number_format($amount, 2) }}</span>
      </div>
    </div>

    @if ($errors->any())
  <div class="mt-4 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg p-3 text-sm">
      @foreach ($errors->all() as $error)
          <div>• {{ $error }}</div>
      @endforeach
  </div>
@endif


    <!-- Pay Now Button -->
    <button wire:click="processPayment"
      class="w-full bg-[#0A0F1D] text-white py-3 rounded-full font-semibold tracking-wide hover:bg-blue-700 hover:shadow-[0_0_20px_#2563eb] transition-all duration-300 ease-in-out">
      Pay Now
    </button>
  </div>
</div>


