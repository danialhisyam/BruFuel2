<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Trips - BruFuel Driver</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to bottom right, #eef2ff, #f9fafb);
      min-height: 100vh;
    }
    .glass-card {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(12px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .glass-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    .tab-btn.active {
      background-color: #2563eb;
      color: white;
      box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }
    .tab-btn {
      transition: all 0.25s ease;
    }
    .trip-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 1.5rem;
      animation: fadeIn 0.35s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body class="flex flex-col">

  <!-- Header -->
  <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-20">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
      <div class="flex items-center gap-2">
        <i data-feather="truck" class="w-6 h-6 text-blue-600"></i>
        <h1 class="text-lg md:text-xl font-semibold text-gray-800 tracking-tight">BruFuel Driver Portal</h1>
      </div>
      <a href="login.html" 
         class="text-blue-600 font-medium border border-blue-100 px-4 py-2 rounded-lg hover:bg-blue-50 transition">
        Logout
      </a>
    </div>
  </header>

  <!-- Back Button -->
  <div class="container mx-auto px-6 py-4">
    <a href="index.html" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Back to Dashboard
    </a>
  </div>

  <!-- Main Section -->
  <main class="flex-grow container mx-auto px-6 pb-16">
    <div class="text-center mb-10">
      <h2 class="text-4xl font-bold text-gray-800 tracking-tight">My Trips</h2>
      <p class="text-gray-500 mt-2">Easily manage, track, and complete your deliveries</p>
    </div>

    <!-- Tabs -->
    <div class="flex justify-center mb-10 flex-wrap gap-3">
      <button onclick="filterTrips('pending')" id="btn-pending" class="tab-btn active bg-blue-600 text-white px-6 py-2 rounded-full font-medium shadow-md hover:shadow-lg">Pending</button>
      <button onclick="filterTrips('inprogress')" id="btn-inprogress" class="tab-btn bg-white text-gray-800 px-6 py-2 rounded-full font-medium hover:bg-blue-50">In Progress</button>
      <button onclick="filterTrips('completed')" id="btn-completed" class="tab-btn bg-white text-gray-800 px-6 py-2 rounded-full font-medium hover:bg-blue-50">Completed</button>
      <button onclick="filterTrips('cancelled')" id="btn-cancelled" class="tab-btn bg-white text-gray-800 px-6 py-2 rounded-full font-medium hover:bg-blue-50">Cancelled</button>
    </div>

    <!-- Trips Container -->
    <div id="trips" class="trip-grid">
      <!-- Pending -->
      <div class="glass-card rounded-2xl p-6 trip" data-status="pending">
        <div class="flex justify-between items-start mb-3">
          <h3 class="font-semibold text-gray-800">Trip #A100</h3>
          <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-medium">Pending</span>
        </div>
        <div class="text-gray-600 text-sm mb-3 space-y-1">
          <p><b>From:</b> Serusop</p>
          <p><b>To:</b> Kiulap</p>
          <p class="text-xs text-gray-500">Scheduled: Oct 20, 2025 • 10:00 AM</p>
        </div>
        <div class="flex gap-2">
          <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">Accept</button>
          <button class="flex-1 bg-gray-200 text-gray-800 py-2 rounded-lg hover:bg-gray-300 transition text-sm font-medium">Decline</button>
        </div>
      </div>

      <!-- In Progress -->
      <div class="glass-card rounded-2xl p-6 trip" data-status="inprogress">
        <div class="flex justify-between items-start mb-3">
          <h3 class="font-semibold text-gray-800">Trip #B210</h3>
          <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">In Progress</span>
        </div>
        <div class="text-gray-600 text-sm mb-3 space-y-1">
          <p><b>From:</b> Airport Terminal</p>
          <p><b>To:</b> Bandar</p>
          <p class="text-xs text-gray-500">Started: Oct 19, 2025 • 09:15 AM</p>
        </div>
        <div class="flex gap-2">
          <button class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">View Route</button>
          <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">Mark Complete</button>
        </div>
      </div>

      <!-- Completed -->
      <div class="glass-card rounded-2xl p-6 trip" data-status="completed">
        <div class="flex justify-between items-start mb-3">
          <h3 class="font-semibold text-gray-800">Trip #C330</h3>
          <span class="bg-gray-200 text-gray-700 text-xs px-3 py-1 rounded-full font-medium">Completed</span>
        </div>
        <div class="text-gray-600 text-sm mb-3 space-y-1">
          <p><b>From:</b> Gadong</p>
          <p><b>To:</b> Berakas</p>
          <p class="text-xs text-gray-500">Completed: Oct 18, 2025 • 02:45 PM</p>
        </div>
        <div class="flex gap-2">
          <button class="flex-1 bg-gray-700 text-white py-2 rounded-lg hover:bg-gray-800 transition text-sm font-medium">View Details</button>
          <button class="flex-1 bg-green-100 text-green-700 py-2 rounded-lg text-sm font-medium">Earned: $15</button>
        </div>
      </div>

      <!-- Cancelled -->
      <div class="glass-card rounded-2xl p-6 trip" data-status="cancelled">
        <div class="flex justify-between items-start mb-3">
          <h3 class="font-semibold text-gray-800">Trip #D400</h3>
          <span class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-medium">Cancelled</span>
        </div>
        <div class="text-gray-600 text-sm mb-3 space-y-1">
          <p><b>From:</b> Sengkurong</p>
          <p><b>To:</b> Tutong</p>
          <p class="text-xs text-gray-500">Cancelled: Oct 17, 2025 • 11:30 AM</p>
        </div>
        <div class="flex items-center text-xs text-gray-500">
          <i data-feather="info" class="w-3 h-3 mr-1"></i> Customer cancelled before pickup
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="text-center py-6 border-t border-gray-200 bg-white/60 backdrop-blur-sm text-gray-500 text-sm">
    © 2025 BruFuel. All rights reserved.
  </footer>

  <script>
    feather.replace();

    const trips = document.querySelectorAll('.trip');
    const buttons = document.querySelectorAll('.tab-btn');

    function filterTrips(status) {
      // Toggle active button style
      buttons.forEach(btn => btn.classList.remove('active'));
      document.getElementById('btn-' + status).classList.add('active');

      // Filter logic
      trips.forEach(trip => {
        const tripStatus = trip.getAttribute('data-status');
        if (status === 'pending') {
          trip.style.display = tripStatus === 'pending' ? 'block' : 'none';
        } else if (status === 'inprogress') {
          trip.style.display = (tripStatus === 'inprogress' || tripStatus === 'completed') ? 'block' : 'none';
        } else {
          trip.style.display = tripStatus === status ? 'block' : 'none';
        }
      });
    }
  </script>
</body>
</html>
