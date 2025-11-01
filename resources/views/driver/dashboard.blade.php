<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BruFuel - Driver Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    body { font-family: 'Inter', sans-serif; }
    .card { transition: all 0.3s ease; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    input, select { transition: all 0.2s ease; }
    input:focus, select:focus {
      border-color: #2563eb; outline: none;
      box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to {opacity:1; transform:translateY(0);} }
    .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(2px);
      justify-content: center; align-items: center; z-index: 50; }
    .modal.show { display: flex; animation: fadeIn 0.3s ease-in-out; }
  </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-10">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
      <div class="flex items-center gap-2">
        <i data-feather="truck" class="w-6 h-6 text-blue-600"></i>
        <h1 class="text-lg md:text-xl font-semibold text-gray-800 tracking-tight">BruFuel Driver Portal</h1>
      </div>

      <!-- ✅ Proper Laravel logout -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
          class="text-blue-600 font-medium border border-blue-100 px-4 py-2 rounded-lg hover:bg-blue-50 transition">
          Logout
        </button>
      </form>
    </div>
  </header>

  <!-- MAIN DASHBOARD -->
  <main class="flex-grow container mx-auto px-6 py-12">
    <h2 class="text-3xl font-semibold text-gray-800 text-center mb-10 tracking-tight">Driver Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-center">

      <!-- View Trips -->
      <a href="{{ route('driver.trips') }}" class="block">
        <div class="card bg-white rounded-2xl p-8 text-center border border-gray-100 shadow-sm hover:shadow-md">
          <div class="flex justify-center mb-5">
            <div class="bg-blue-50 p-4 rounded-full">
              <i data-feather="package" class="w-10 h-10 text-blue-600"></i>
            </div>
          </div>
          <h3 class="font-semibold text-xl text-gray-800 mb-2">View Trips</h3>
          <p class="text-gray-600 text-sm mb-6 leading-relaxed">Monitor your assigned trips, deliveries, and current statuses.</p>
          <button class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition w-full font-medium">
            Open
          </button>
        </div>
      </a>

      <!-- Transactions -->
      <a href="{{ route('driver.transactions') }}" class="block">
        <div class="card bg-white rounded-2xl p-8 text-center border border-gray-100 shadow-sm hover:shadow-md">
          <div class="flex justify-center mb-5">
            <div class="bg-green-50 p-4 rounded-full">
              <i data-feather="dollar-sign" class="w-10 h-10 text-green-600"></i>
            </div>
          </div>
          <h3 class="font-semibold text-xl text-gray-800 mb-2">Transactions</h3>
          <p class="text-gray-600 text-sm mb-6 leading-relaxed">View and track your daily earnings and completed payments.</p>
          <button class="bg-green-600 text-white px-5 py-2 rounded-md hover:bg-green-700 transition w-full font-medium">
            Open
          </button>
        </div>
      </a>

      <!-- Account Settings (Popup Modal) -->
      <div class="block">
        <div class="card bg-white rounded-2xl p-8 text-center border border-gray-100 shadow-sm hover:shadow-md">
          <div class="flex justify-center mb-5">
            <div class="bg-gray-100 p-4 rounded-full">
              <i data-feather="settings" class="w-10 h-10 text-gray-700"></i>
            </div>
          </div>
          <h3 class="font-semibold text-xl text-gray-800 mb-2">Account Settings</h3>
          <p class="text-gray-600 text-sm mb-6 leading-relaxed">Manage your personal details, vehicle info, and credentials.</p>
          <button onclick="toggleModal(true)" class="bg-gray-700 text-white px-5 py-2 rounded-md hover:bg-gray-800 transition w-full font-medium">
            Open
          </button>
        </div>
      </div>
    </div>
  </main>

  <!-- Account Settings Modal -->
  <div id="accountModal" class="modal">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 w-full max-w-3xl relative">
      <button onclick="toggleModal(false)" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700">
        <i data-feather="x" class="w-6 h-6"></i>
      </button>

      <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Account Settings</h2>

      <!-- Tabs -->
      <div class="flex justify-center mb-8 space-x-4">
        <button onclick="openTab(event, 'personal')" class="tab-btn bg-blue-600 text-white px-6 py-2 rounded-md font-medium">Personal Info</button>
        <button onclick="openTab(event, 'vehicle')" class="tab-btn bg-gray-200 text-gray-800 px-6 py-2 rounded-md font-medium hover:bg-gray-300">Vehicle Info</button>
        <button onclick="openTab(event, 'security')" class="tab-btn bg-gray-200 text-gray-800 px-6 py-2 rounded-md font-medium hover:bg-gray-300">Security</button>
      </div>

      <!-- PERSONAL INFO -->
      <div id="personal" class="tab-content active">
        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
            <input type="text" placeholder="John Doe" class="w-full border rounded-lg px-3 py-2" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Email Address</label>
            <input type="email" placeholder="driver@brufuel.com" class="w-full border rounded-lg px-3 py-2" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Phone Number</label>
            <input type="text" placeholder="+673 888 1234" class="w-full border rounded-lg px-3 py-2" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
            <input type="text" placeholder="Kg Kiulap, Bandar Seri Begawan" class="w-full border rounded-lg px-3 py-2" />
          </div>
        </div>
      </div>

      <!-- VEHICLE INFO -->
      <div id="vehicle" class="tab-content">
        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Vehicle Type</label>
            <select class="w-full border rounded-lg px-3 py-2">
              <option>Car</option><option>Motorcycle</option><option>Van</option><option>Truck</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Plate Number</label>
            <input type="text" placeholder="BBA 1234" class="w-full border rounded-lg px-3 py-2" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Vehicle Model</label>
            <input type="text" placeholder="Toyota Hilux 2020" class="w-full border rounded-lg px-3 py-2" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Insurance Expiry</label>
            <input type="date" class="w-full border rounded-lg px-3 py-2" />
          </div>
        </div>
      </div>

      <!-- SECURITY SETTINGS -->
      <div id="security" class="tab-content">
        <div class="grid md:grid-cols-3 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
            <input type="password" placeholder="********" class="w-full border rounded-lg px-3 py-2" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">New Password</label>
            <input type="password" placeholder="********" class="w-full border rounded-lg px-3 py-2" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Confirm Password</label>
            <input type="password" placeholder="********" class="w-full border rounded-lg px-3 py-2" />
          </div>
        </div>
        <div class="mt-6 flex justify-end">
          <button class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition font-medium">
            Update Password
          </button>
        </div>
      </div>

      <!-- Save Button -->
      <div class="mt-10 border-t pt-6 flex justify-end">
        <button class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition font-medium">
          Save All Changes
        </button>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center py-6 border-t border-gray-200 bg-white text-gray-500 text-sm">
    © 2025 BruFuel. All rights reserved.
  </footer>

  <script>
    feather.replace();

    function openTab(evt, tabName) {
      const tabs = document.querySelectorAll('.tab-btn');
      const contents = document.querySelectorAll('.tab-content');
      tabs.forEach(t => t.classList.remove('bg-blue-600','text-white'));
      tabs.forEach(t => t.classList.add('bg-gray-200','text-gray-800'));
      evt.currentTarget.classList.add('bg-blue-600','text-white');
      evt.currentTarget.classList.remove('bg-gray-200','text-gray-800');
      contents.forEach(c => c.classList.remove('active'));
      document.getElementById(tabName).classList.add('active');
    }

    function toggleModal(show) {
      const modal = document.getElementById('accountModal');
      modal.classList.toggle('show', show);
    }
  </script>
</body>
</html>

