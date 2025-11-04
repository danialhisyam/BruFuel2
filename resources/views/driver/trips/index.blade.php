<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Trips - BruFuel Driver</title>

  <!-- Tailwind CDN (no Vite needed) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    :root { color-scheme: dark; }
    body { background:#0b1220; }
    .sidebar { background:#0f1625; }
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
      <a href="login.html" class="text-blue-400 font-medium border border-blue-900 px-4 py-2 rounded-lg hover:bg-blue-600/20 transition">Logout</a>
    </div>
  </header>

  <!-- Back + Search -->
  <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
    <a href="index.html" class="inline-flex items-center text-blue-400 hover:text-blue-300 font-medium transition">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Back to Dashboard
    </a>
    <input id="searchInput" onkeyup="searchTrips()" type="text" placeholder="🔍 Search trip ID or location..."
      class="w-full md:w-1/3 border border-gray-700 bg-[#0f1625] text-gray-200 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
  </div>

  <!-- Main -->
  <main class="flex-grow container mx-auto px-6 pb-16">
    <div class="text-center mb-10">
      <h2 class="text-4xl font-bold text-white">My Trips</h2>
      <p class="text-gray-400 mt-2">Easily manage, navigate, and contact your customers</p>
    </div>

    <!-- Tabs -->
    <div class="flex justify-center mb-8 flex-wrap gap-3">
      <button onclick="filterTrips('pending')" id="btn-pending" class="tab-btn active bg-blue-600 text-white px-6 py-2 rounded-full font-medium shadow-md hover:shadow-lg">Pending</button>
      <button onclick="filterTrips('inprogress')" id="btn-inprogress" class="tab-btn bg-[#141c2b] text-gray-200 px-6 py-2 rounded-full font-medium hover:bg-blue-700/20">In Progress</button>
      <button onclick="filterTrips('completed')" id="btn-completed" class="tab-btn bg-[#141c2b] text-gray-200 px-6 py-2 rounded-full font-medium hover:bg-blue-700/20">Completed</button>
      <button onclick="filterTrips('cancelled')" id="btn-cancelled" class="tab-btn bg-[#141c2b] text-gray-200 px-6 py-2 rounded-full font-medium hover:bg-blue-700/20">Cancelled</button>
    </div>

    <!-- Trips Grid -->
    <div id="trips" class="trip-grid">
      <!-- Pending -->
      <div class="glass-card rounded-2xl p-6 trip border border-gray-700" data-status="pending" data-search="serusop kiulap a100">
        <div class="flex justify-between items-start mb-3">
          <h3 class="font-semibold text-white">Trip #A100</h3>
          <span class="bg-yellow-900/50 text-yellow-400 text-xs px-3 py-1 rounded-full font-medium">Pending</span>
        </div>
        <div class="text-gray-400 text-sm space-y-1 mb-4">
          <p><b>From:</b> Serusop</p>
          <p><b>To:</b> Kiulap</p>
          <p><b>Fare Estimate:</b> $10</p>
          <p class="text-xs text-gray-500">Pickup: Oct 20, 2025 • 10:00 AM</p>
        </div>
        <div class="flex gap-2">
          <button onclick="acceptTrip(this.closest('.trip'))" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">Accept</button>
          <button onclick="declineTrip(this.closest('.trip'))" class="flex-1 bg-[#1f2937] text-gray-300 py-2 rounded-lg hover:bg-gray-700 transition text-sm font-medium">Decline</button>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="text-center py-6 border-t border-gray-800 bg-[#0f1625] text-gray-500 text-sm">
    © 2025 <span class="text-blue-400 font-semibold">BruFuel</span>. All rights reserved.
  </footer>

  <!-- Modal -->
  <div id="detailsModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center">
    <div class="bg-[#141c2b] border border-gray-700 rounded-2xl shadow-xl p-6 w-11/12 md:w-1/3 text-center">
      <h3 class="text-lg font-semibold text-white mb-4">Trip Details</h3>
      <p id="modalText" class="text-gray-400 mb-6"></p>
      <button onclick="closeDetailsModal()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Close</button>
    </div>
  </div>

  <script>
    feather.replace();

    const trips = document.querySelectorAll('.trip');
    const buttons = document.querySelectorAll('.tab-btn');

    // --- Filter Tabs ---
    function filterTrips(status) {
      buttons.forEach(btn => btn.classList.remove('active'));
      document.getElementById('btn-' + status).classList.add('active');
      document.querySelectorAll('.trip').forEach(trip => {
        const s = trip.getAttribute('data-status');
        trip.style.display = (status === 'all' || s === status) ? 'block' : 'none';
      });
    }

    // --- Search Trips ---
    function searchTrips() {
      const query = document.getElementById('searchInput').value.toLowerCase();
      trips.forEach(trip => {
        trip.style.display = trip.getAttribute('data-search').includes(query) ? 'block' : 'none';
      });
    }

    // --- Accept Trip (turns into in-progress immediately) ---
    function acceptTrip(card) {
      const badge = card.querySelector('span');
      badge.className = "bg-green-900/40 text-green-400 text-xs px-3 py-1 rounded-full font-medium";
      badge.innerText = "In Progress";
      card.setAttribute("data-status", "inprogress");

      const buttonArea = card.querySelector('.flex.gap-2');
      buttonArea.innerHTML = `
        <button onclick="window.open('https://maps.google.com?q=Serusop+to+Kiulap')" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 text-sm font-medium">
          <i data-feather='map-pin' class='inline w-4 h-4 mr-1'></i> Navigate
        </button>
        <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
          <i data-feather='check-circle' class='inline w-4 h-4 mr-1'></i> Mark Complete
        </button>
        <button onclick="contactCustomer('+6738889988')" class="flex-1 bg-blue-900/30 text-blue-400 py-2 rounded-lg hover:bg-blue-700/40 text-sm font-medium">
          <i data-feather='phone' class='inline w-4 h-4 mr-1'></i> Call
        </button>
        <button onclick="contactViaWhatsApp('+6738889988', 'Hi, this is your BruFuel driver. I’m on the way!')" class="flex-1 bg-green-900/30 text-green-400 py-2 rounded-lg hover:bg-green-700/40 text-sm font-medium">
          <i data-feather='message-circle' class='inline w-4 h-4 mr-1'></i> WhatsApp
        </button>
      `;
      feather.replace();
      alert("Trip accepted! You can now start navigation and contact your customer.");
    }

    // --- Decline Trip ---
    function declineTrip(card) {
      if (confirm("Are you sure you want to decline this trip?")) {
        card.remove();
        alert("Trip declined and removed from your list.");
      }
    }

    // --- Modal ---
    function openDetailsModal(text) {
      document.getElementById('modalText').innerText = text;
      document.getElementById('detailsModal').classList.remove('hidden');
    }
    function closeDetailsModal() {
      document.getElementById('detailsModal').classList.add('hidden');
    }

    // --- Contact Methods ---
    function contactCustomer(phoneNumber) {
      window.location.href = `tel:${phoneNumber}`;
    }
    function contactViaWhatsApp(phoneNumber, message) {
      const encodedMsg = encodeURIComponent(message);
      const formattedPhone = phoneNumber.replace(/\D/g, '');
      window.open(`https://wa.me/${formattedPhone}?text=${encodedMsg}`, '_blank');
    }
  </script>
</body>
</html>
