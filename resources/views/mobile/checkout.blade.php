<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - BruFuel</title>
  
  @vite('resources/css/app.css')
  @livewireStyles
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #0A0F1D;
      color: white;
    }
  </style>
</head>

<body class="bg-[#0A0F1D] text-white min-h-screen">
  <div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6 text-center">Checkout</h1>
    
    <div class="bg-slate-900/50 rounded-lg p-6 space-y-6">
      <!-- Fuel Selection -->
      <div>
        <label class="block text-sm font-medium mb-2">Select Fuel Type</label>
        <select id="fuelType" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white">
          <option value="">Choose fuel type...</option>
          <option value="Premium">Premium</option>
          <option value="Regular">Regular</option>
          <option value="Diesel">Diesel</option>
        </select>
      </div>

      <!-- Delivery Location -->
      <div>
        <label class="block text-sm font-medium mb-2">Delivery Address</label>
        <input type="text" id="deliveryAddress" placeholder="Enter delivery address" 
               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white">
      </div>

      <!-- Vehicle Details -->
      <div>
        <label class="block text-sm font-medium mb-2">License Plate</label>
        <input type="text" id="licensePlate" placeholder="Enter license plate" 
               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white">
      </div>

      <!-- Amount -->
      <div>
        <label class="block text-sm font-medium mb-2">Fuel Amount (B$)</label>
        <input type="number" id="fuelAmount" step="0.01" min="0.01" placeholder="0.00" 
               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white">
      </div>

      <!-- Payment Method -->
      <div>
        <label class="block text-sm font-medium mb-2">Payment Method</label>
        <select id="paymentMethod" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white">
          <option value="TAP">TAP</option>
          <option value="CASH">CASH</option>
          <option value="BIBD">BIBD</option>
          <option value="BAIDURI">BAIDURI</option>
        </select>
      </div>

      <!-- Action Buttons -->
      <div class="flex gap-4 pt-4">
        <button onclick="window.location.href='{{ route('mobile.home') }}'" 
                class="flex-1 bg-slate-700 hover:bg-slate-600 rounded-lg px-4 py-3 font-semibold transition">
          Cancel
        </button>
        <button onclick="confirmOrder()" 
                class="flex-1 bg-[#760000] hover:bg-[#8a0000] rounded-lg px-4 py-3 font-semibold transition">
          Confirm Order
        </button>
      </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
      <div class="mt-4 bg-green-500/20 border border-green-500/50 rounded-lg p-4 text-green-400">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="mt-4 bg-red-500/20 border border-red-500/50 rounded-lg p-4 text-red-400">
        {{ session('error') }}
      </div>
    @endif
  </div>

  @livewireScripts

  <script>
    async function confirmOrder() {
      const fuelType = document.getElementById('fuelType').value;
      const deliveryAddress = document.getElementById('deliveryAddress').value;
      const licensePlate = document.getElementById('licensePlate').value;
      const fuelAmount = document.getElementById('fuelAmount').value;
      const paymentMethod = document.getElementById('paymentMethod').value;

      // Validate required fields
      if (!fuelType || !deliveryAddress || !licensePlate || !fuelAmount) {
        alert('Please fill in all required fields');
        return;
      }

      try {
        const csrfToken = '{{ csrf_token() }}';
        
        // Step 1: Save fuel type
        const formData1 = new FormData();
        formData1.append('fuel_type', fuelType);
        formData1.append('_token', csrfToken);
        await fetch('{{ route('mobile.checkout.fuel') }}', {
          method: 'POST',
          body: formData1
        });

        // Step 2: Save location
        const formData2 = new FormData();
        formData2.append('address', deliveryAddress);
        formData2.append('_token', csrfToken);
        await fetch('{{ route('mobile.checkout.location') }}', {
          method: 'POST',
          body: formData2
        });

        // Step 3: Save vehicle
        const formData3 = new FormData();
        formData3.append('license_plate', licensePlate);
        formData3.append('_token', csrfToken);
        await fetch('{{ route('mobile.checkout.vehicle') }}', {
          method: 'POST',
          body: formData3
        });

        // Step 4: Confirm order - submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('mobile.checkout.confirm') }}';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = csrfToken;
        form.appendChild(csrf);

        const amount = document.createElement('input');
        amount.type = 'hidden';
        amount.name = 'fuel_amount';
        amount.value = fuelAmount;
        form.appendChild(amount);

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = 'payment_method';
        method.value = paymentMethod;
        form.appendChild(method);

        document.body.appendChild(form);
        form.submit();
      } catch (error) {
        console.error('Error:', error);
        alert('Failed to process order. Please try again.');
      }
    }
  </script>
</body>
</html>
