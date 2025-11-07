<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Trips - BruFuel Driver</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    :root { color-scheme: dark; }
    body { background:#0b1220; }
    .card, .glass-card { background:#141c2b; border-color:#1f2937; transition: all 0.3s ease; }
    .glass-card:hover { transform: translateY(-4px); box-shadow: 0 15px 30px rgba(0,0,0,0.4); }
    body { font-family: 'Inter', sans-serif; min-height: 100vh; }
    .tab-btn.active {
      background-color: #2563eb;
      color: white;
      box-shadow: 0 4px 10px rgba(37,99,235,0.3);
    }
    .trip-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
      gap: 1.5rem;
      animation: fadeIn 0.35s ease-in-out;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(10px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>

<body class="min-h-screen text-slate-100 antialiased flex flex-col">
  <!-- Header -->
  <header class="bg-[#0f1625] border-b border-gray-800 shadow-sm sticky top-0 z-20">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
      <div class="flex items-center gap-2">
        <i data-feather="truck" class="w-6 h-6 text-blue-500"></i>
        <h1 class="text-lg md:text-xl font-semibold text-white tracking-tight">BruFuel Driver Portal</h1>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-blue-400 font-medium border border-blue-900 px-4 py-2 rounded-lg hover:bg-blue-600/20 transition">Logout</button>
      </form>
    </div>
  </header>

  <!-- Back + Search -->
  <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
    <a href="{{ route('driver.dashboard') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 font-medium transition">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Back to Dashboard
    </a>
    <input id="searchInput" onkeyup="searchTrips()" type="text" placeholder="🔍 Search trip ID or location..."
      class="w-full md:w-1/3 border border-gray-700 bg-[#0f1625] text-gray-200 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
  </div>

  <!-- Success/Error Messages -->
  @if(session('success'))
    <div class="container mx-auto px-6">
      <div class="bg-green-500/20 border border-green-500/50 rounded-lg p-4 text-green-400 mb-4">
        {{ session('success') }}
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="container mx-auto px-6">
      <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 text-red-400 mb-4">
        {{ session('error') }}
      </div>
    </div>
  @endif

  @if(isset($error))
    <div class="container mx-auto px-6">
      <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 text-red-400 mb-4">
        {{ $error }}
      </div>
    </div>
  @endif

  <!-- Main -->
  <main class="flex-grow container mx-auto px-6 pb-16">
    <div class="text-center mb-10">
      <h2 class="text-4xl font-bold text-white">My Trips</h2>
      <p class="text-gray-400 mt-2">Easily manage, navigate, and contact your customers</p>
    </div>

    <!-- Tabs -->
    <div class="flex justify-center mb-8 flex-wrap gap-3">
      <button onclick="filterTrips('pending')" id="btn-pending" class="tab-btn active bg-blue-600 text-white px-6 py-2 rounded-full font-medium shadow-md hover:shadow-lg">Pending</button>
      <button onclick="filterTrips('in_progress')" id="btn-in_progress" class="tab-btn bg-[#141c2b] text-gray-200 px-6 py-2 rounded-full font-medium hover:bg-blue-700/20">In Progress</button>
      <button onclick="filterTrips('completed')" id="btn-completed" class="tab-btn bg-[#141c2b] text-gray-200 px-6 py-2 rounded-full font-medium hover:bg-blue-700/20">Completed</button>
      <button onclick="filterTrips('cancelled')" id="btn-cancelled" class="tab-btn bg-[#141c2b] text-gray-200 px-6 py-2 rounded-full font-medium hover:bg-blue-700/20">Cancelled</button>
    </div>

    <!-- Trips Grid -->
    <div id="trips" class="trip-grid">
      <!-- Pending Trips -->
      @foreach($pendingTrips as $trip)
        <div class="glass-card rounded-2xl p-6 trip border border-gray-700" data-status="pending" data-search="{{ strtolower($trip->order_no . ' ' . ($trip->delivery_address ?? '')) }}">
          <div class="flex justify-between items-start mb-3">
            <h3 class="font-semibold text-white">Trip #{{ $trip->order_no }}</h3>
            <span class="bg-yellow-900/50 text-yellow-400 text-xs px-3 py-1 rounded-full font-medium">Pending</span>
          </div>
          <div class="text-gray-400 text-sm space-y-1 mb-4">
            <p><b>From:</b> {{ $trip->delivery_address ?? 'N/A' }}</p>
            <p><b>Fuel Type:</b> {{ $trip->fuel_type ?? 'N/A' }}</p>
            <p><b>Fare Estimate:</b> B${{ number_format($trip->total_amount ?? 0, 2) }}</p>
            <p class="text-xs text-gray-500">Customer: {{ optional($trip->user)->name ?? 'N/A' }}</p>
            <p class="text-xs text-gray-500">Created: {{ $trip->created_at->format('M d, Y • h:i A') }}</p>
          </div>
          <div class="flex gap-2">
            <form method="POST" action="{{ route('driver.trips.accept', $trip) }}" class="flex-1">
              @csrf
              <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">Accept</button>
            </form>
            <form method="POST" action="{{ route('driver.trips.decline', $trip) }}" class="flex-1">
              @csrf
              <button type="submit" class="w-full bg-[#1f2937] text-gray-300 py-2 rounded-lg hover:bg-gray-700 transition text-sm font-medium">Decline</button>
            </form>
          </div>
        </div>
      @endforeach

      <!-- In Progress Trips -->
      @foreach($inProgressTrips as $trip)
        <div class="glass-card rounded-2xl p-6 trip border border-gray-700" data-status="in_progress" data-search="{{ strtolower($trip->order_no . ' ' . ($trip->delivery_address ?? '')) }}">
          <div class="flex justify-between items-start mb-3">
            <h3 class="font-semibold text-white">Trip #{{ $trip->order_no }}</h3>
            <span class="bg-green-900/40 text-green-400 text-xs px-3 py-1 rounded-full font-medium">In Progress</span>
          </div>
          <div class="text-gray-400 text-sm space-y-1 mb-4">
            <p><b>From:</b> {{ $trip->delivery_address ?? 'N/A' }}</p>
            <p><b>Fuel Type:</b> {{ $trip->fuel_type ?? 'N/A' }}</p>
            <p><b>Fare:</b> B${{ number_format($trip->total_amount ?? 0, 2) }}</p>
            <p class="text-xs text-gray-500">Customer: {{ optional($trip->user)->name ?? 'N/A' }}</p>
            <p class="text-xs text-gray-500">Accepted: {{ $trip->updated_at->format('M d, Y • h:i A') }}</p>
          </div>
          <div class="flex gap-2 flex-wrap">
            <button onclick="window.open('https://maps.google.com?q={{ urlencode($trip->delivery_address ?? '') }}')" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 text-sm font-medium">
              <i data-feather='map-pin' class='inline w-4 h-4 mr-1'></i> Navigate
            </button>
            <form method="POST" action="{{ route('driver.trips.status', $trip) }}" class="flex-1">
              @csrf
              <input type="hidden" name="status" value="completed">
              <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                <i data-feather='check-circle' class='inline w-4 h-4 mr-1'></i> Mark Complete
              </button>
            </form>
            @if(optional($trip->user)->phone)
              <button onclick="contactCustomer('{{ $trip->user->phone }}')" class="flex-1 bg-blue-900/30 text-blue-400 py-2 rounded-lg hover:bg-blue-700/40 text-sm font-medium">
                <i data-feather='phone' class='inline w-4 h-4 mr-1'></i> Call
              </button>
            @endif
          </div>
        </div>
      @endforeach

      <!-- Completed Trips -->
      @foreach($completedTrips as $trip)
        <div class="glass-card rounded-2xl p-6 trip border border-gray-700" data-status="completed" data-search="{{ strtolower($trip->order_no . ' ' . ($trip->delivery_address ?? '')) }}">
          <div class="flex justify-between items-start mb-3">
            <h3 class="font-semibold text-white">Trip #{{ $trip->order_no }}</h3>
            <span class="bg-blue-900/40 text-blue-400 text-xs px-3 py-1 rounded-full font-medium">Completed</span>
          </div>
          <div class="text-gray-400 text-sm space-y-1 mb-4">
            <p><b>From:</b> {{ $trip->delivery_address ?? 'N/A' }}</p>
            <p><b>Fuel Type:</b> {{ $trip->fuel_type ?? 'N/A' }}</p>
            <p><b>Fare:</b> B${{ number_format($trip->total_amount ?? 0, 2) }}</p>
            <p class="text-xs text-gray-500">Customer: {{ optional($trip->user)->name ?? 'N/A' }}</p>
            <p class="text-xs text-gray-500">Completed: {{ $trip->updated_at->format('M d, Y • h:i A') }}</p>
          </div>
        </div>
      @endforeach

      <!-- Cancelled Trips -->
      @foreach($cancelledTrips as $trip)
        <div class="glass-card rounded-2xl p-6 trip border border-gray-700" data-status="cancelled" data-search="{{ strtolower($trip->order_no . ' ' . ($trip->delivery_address ?? '')) }}">
          <div class="flex justify-between items-start mb-3">
            <h3 class="font-semibold text-white">Trip #{{ $trip->order_no }}</h3>
            <span class="bg-red-900/40 text-red-400 text-xs px-3 py-1 rounded-full font-medium">Cancelled</span>
          </div>
          <div class="text-gray-400 text-sm space-y-1 mb-4">
            <p><b>From:</b> {{ $trip->delivery_address ?? 'N/A' }}</p>
            <p><b>Fuel Type:</b> {{ $trip->fuel_type ?? 'N/A' }}</p>
            <p><b>Fare:</b> B${{ number_format($trip->total_amount ?? 0, 2) }}</p>
            <p class="text-xs text-gray-500">Customer: {{ optional($trip->user)->name ?? 'N/A' }}</p>
            <p class="text-xs text-gray-500">Cancelled: {{ $trip->updated_at->format('M d, Y • h:i A') }}</p>
          </div>
        </div>
      @endforeach

      @if($pendingTrips->isEmpty() && $inProgressTrips->isEmpty() && $completedTrips->isEmpty() && $cancelledTrips->isEmpty())
        <div class="col-span-full text-center py-12 text-gray-400">
          <i data-feather="inbox" class="w-16 h-16 mx-auto mb-4 opacity-50"></i>
          <p class="text-lg">No trips found</p>
        </div>
      @endif
    </div>
  </main>

  <!-- Footer -->
  <footer class="text-center py-6 border-t border-gray-800 bg-[#0f1625] text-gray-500 text-sm">
    © 2025 <span class="text-blue-400 font-semibold">BruFuel</span>. All rights reserved.
  </footer>

  <script>
    feather.replace();

    const trips = document.querySelectorAll('.trip');
    const buttons = document.querySelectorAll('.tab-btn');

    // --- Filter Tabs ---
    function filterTrips(status) {
      buttons.forEach(btn => btn.classList.remove('active'));
      const btnId = 'btn-' + status.replace('_', '');
      const btn = document.getElementById(btnId);
      if (btn) btn.classList.add('active');
      
      document.querySelectorAll('.trip').forEach(trip => {
        const s = trip.getAttribute('data-status');
        trip.style.display = (status === 'all' || s === status) ? 'block' : 'none';
      });
    }

    // --- Search Trips ---
    function searchTrips() {
      const query = document.getElementById('searchInput').value.toLowerCase();
      trips.forEach(trip => {
        const searchText = trip.getAttribute('data-search') || '';
        trip.style.display = searchText.includes(query) ? 'block' : 'none';
      });
    }

    // --- Contact Methods ---
    function contactCustomer(phoneNumber) {
      window.location.href = `tel:${phoneNumber}`;
    }
  </script>
</body>
</html>
