<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>BruFuel • Dashboard</title>

  <!-- Tailwind CDN (no Vite needed) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root { color-scheme: dark; }
    body     { background:#0b1220; }
    .sidebar { background:#0f1625; }
    .card    { background:#141c2b; border-color:#1f2937; }
  </style>
</head>
<body class="min-h-screen text-slate-100 antialiased">
  <div class="flex min-h-screen">
    
    <!-- SIDEBAR -->
    <aside class="sidebar w-64 shrink-0 border-r border-slate-800 flex flex-col">
     
      <!-- Brand -->
      <div class="flex items-center gap-3 px-5 py-5">
        <div class="grid h-12 w-12 place-items-center rounded-xl bg-white/10">
          <img src="/AdminPics/whiteshell.png" class="h-11 w-12" alt="Shell Icon">
        </div>
        <div>
          <p class="text-lg font-semibold">BruFuel</p>
          <p class="text-xs text-slate-400">Admin</p>
        </div>
      </div>

      <!-- Nav -->
      <nav class="px-3 flex-1">
        <ul class="space-y-1">
          <li>
            <a class="flex items-center gap-3 rounded-lg px-3 py-2 bg-indigo-500/15 text-white" href="/admin/dashboard">
              <span class="inline-block h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
              Dashboard
            </a>
          </li>

          <li>
            <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/orders">
              <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>
              Orders
            </a>
          </li>

          <li>
            <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/users">
              <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>
              Users
            </a>
          </li>

          <li>
            <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/drivers">
              <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>
              Drivers
            </a>
          </li>

          <li>
            <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/payments">
              <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>
              Payments
            </a>
          </li>
        </ul>

        <!-- ✅ LOGOUT SECTION ADDED -->
        <div class="mt-6 border-t border-slate-800 pt-4">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 rounded-lg px-3 py-2 text-red-400 hover:text-red-300 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 002 2h3a2 2 0 002-2v-1m-7-4V7a2 2 0 012-2h3a2 2 0 012 2v1" />
              </svg>
              Logout
            </button>
          </form>
        </div>
        <!-- ✅ END LOGOUT SECTION -->

      </nav>

      <!-- Push footer card to bottom -->
      <div class="p-4">
        <div class="flex items-center gap-3 rounded-xl border border-slate-800 bg-[#0b1220] p-3">
          <div class="grid h-9 w-9 place-items-center rounded-full bg-white/10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z"/><path d="M12 14c-5 0-9 2.5-9 5v1h18v-1c0-2.5-4-5-9-5z"/>
            </svg>
          </div>
          <div class="text-sm">
            <p class="font-medium">Admin User</p>
            <p class="text-slate-400">Administrator</p>
          </div>
        </div>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1">
     
      <!-- Top bar -->
      <header class="border-b border-slate-800">
        <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <span class="text-xl font-bold">BruFuel</span>
            <span class="text-xs font-semibold text-slate-900 bg-amber-400/90 px-2 py-0.5 rounded">ADMIN</span>
          </div>
          <div class="flex items-center gap-3">
            <img class="h-8 w-8 rounded-full" src="http://static.photos/workspace/200x200/5" alt="Admin">
          </div>
        </div>
      </header>

      <!-- Main -->
      <main class="flex-1 p-6 md:p-8">
        <div class="mb-5 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold">Dashboard Overview</h1>
            <p class="text-sm text-slate-400">Welcome back! Here's what's happening with your fleet today.</p>
          </div>
        </div>

        <!-- KPI cards -->
        <section class="grid gap-4 md:grid-cols-4">
          <!-- cards omitted for brevity (same as your version) -->
        </section>

      </main>
    </main>
  </div>
</body>
</html>

