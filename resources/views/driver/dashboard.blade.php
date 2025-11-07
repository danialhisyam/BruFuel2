<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BruFuel - Driver Dashboard</title>

  <!-- Tailwind CDN (no Vite needed) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    :root { color-scheme: dark; }
    body { background:#0b1220; }
    .sidebar { background:#0f1625; }
    .card { background:#141c2b; border-color:#1f2937; transition: all 0.3s ease; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
  </style>
</head>

<body class="min-h-screen text-slate-100 antialiased flex flex-col">

  <!-- Header -->
  <header class="bg-[#0f1625] border-b border-gray-800 shadow-sm sticky top-0 z-10">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
      <div class="flex items-center gap-2">
        <i data-feather="truck" class="w-6 h-6 text-blue-500"></i>
        <h1 class="text-lg md:text-xl font-semibold text-white tracking-tight">BruFuel Driver Portal</h1>
      </div>
      <a href="login.html" class="text-blue-400 font-medium border border-blue-900 px-4 py-2 rounded-lg hover:bg-blue-600/20 transition">
        Logout
      </a>
    </div>
  </header>

  <!-- MAIN DASHBOARD -->
  <main class="flex-grow container mx-auto px-6 py-12">
    <h2 class="text-3xl font-semibold text-white text-center mb-10 tracking-tight">Driver Dashboard</h2>

    <div class="flex justify-center">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl w-full">

        <!-- View Trips -->
        <a href="trips.html" class="block">
          <div class="card rounded-2xl p-8 text-center border border-gray-700 shadow-md hover:shadow-lg">
            <div class="flex justify-center mb-5">
              <div class="bg-blue-900/40 p-4 rounded-full">
                <i data-feather="package" class="w-10 h-10 text-blue-400"></i>
              </div>
            </div>
            <h3 class="font-semibold text-xl text-white mb-2">View Trips</h3>
            <p class="text-gray-400 text-sm mb-6 leading-relaxed">Monitor your assigned trips, deliveries, and current statuses.</p>
            <button class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition w-full font-medium">
              Open
            </button>
          </div>
        </a>

        <!-- Transactions -->
        <a href="transactions.html" class="block">
          <div class="card rounded-2xl p-8 text-center border border-gray-700 shadow-md hover:shadow-lg">
            <div class="flex justify-center mb-5">
              <div class="bg-green-900/40 p-4 rounded-full">
                <i data-feather="dollar-sign" class="w-10 h-10 text-green-400"></i>
              </div>
            </div>
            <h3 class="font-semibold text-xl text-white mb-2">Transactions</h3>
            <p class="text-gray-400 text-sm mb-6 leading-relaxed">View and track your daily earnings and completed payments.</p>
            <button class="bg-green-600 text-white px-5 py-2 rounded-md hover:bg-green-700 transition w-full font-medium">
              Open
            </button>
          </div>
        </a>

      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="text-center py-6 border-t border-gray-800 bg-[#0f1625] text-gray-500 text-sm">
    © 2025 <span class="text-blue-400 font-semibold">BruFuel</span>. All rights reserved.
  </footer>

  <script>
    feather.replace();
  </script>
</body>
</html>
