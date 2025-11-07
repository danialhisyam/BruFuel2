<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BruFuel • Dashboard</title>

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
          <img src="/AdminPics/whiteshell.png" class="h-11 w-12" alt="Shell Icon" />
        </div>
        <div>
          <p class="text-lg font-semibold">BruFuel</p>
          <p class="text-xs text-slate-400">Admin</p>
        </div>
      </div>

      <!-- Nav -->
      <nav class="px-3">
        <ul class="space-y-1">
          <li>
            <a class="flex items-center gap-3 rounded-lg px-3 py-2 bg-indigo-500/15 text-white" href="{{ route('admin.dashboard') }}">
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
      </nav>
        
       <!-- FOOTER (profile + logout below it) -->
  <div class="px-5 pb-5">
    <!-- Profile -->
    <div class="flex items-center gap-3 rounded-xl border border-slate-800 p-3 bg-[#101826]">
     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z"/><path d="M12 14c-5 0-9 2.5-9 5v1h18v-1c0-2.5-4-5-9-5z"/></svg>
      <div>
        <p class="text-sm font-medium text-slate-100">Admin User</p>
        <p class="text-xs text-slate-400">Administrator</p>
      </div>
    </div>

    <!-- Logout BELOW profile -->
    @auth
      <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit"
          class="w-full px-4 py-2 rounded-lg bg-red-600/90 hover:bg-red-600 text-white text-sm font-medium transition">
          Log out
        </button>
      </form>
    @endauth
  </div>
</aside>

    <!-- MAIN -->
    <main class="flex-1">
      <!-- Top bar -->
      <header class="border-b border-slate-800">
        <div class="w-full px-5 py-4 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <span class="text-xl font-bold">BruFuel</span>
            <span class="text-xs font-semibold text-slate-900 bg-amber-400/90 px-2 py-0.5 rounded">ADMIN</span>
          </div>
        </div>
      </header>

      <!-- Content -->
      <section class="flex-1 p-6 md:p-8">
        <div class="mb-5">
          <h1 class="text-2xl font-bold">Dashboard Overview</h1>
          <p class="text-sm text-slate-400">Welcome back! Here's what's happening with your fleet today.</p>
        </div>

        <!-- KPI CARDS (single grid, no nested grids) -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-5 mt-2">

 {{-- Users --}}
<div class="card p-5 rounded-xl">
  <div class="text-sm text-slate-400">Total Users</div>
  <div class="text-3xl font-semibold mt-1">{{ number_format($totalUsers) }}</div>
  <div class="mt-2 text-xs text-slate-400">
    +{{ $usersThisWeek }} this week •
    <span class="text-green-400">↑ {{ $userGrowthPct }}%</span>
  </div>
</div>

{{-- Drivers --}}
<div class="card p-5 rounded-xl">
  <div class="text-sm text-slate-400">Active Drivers</div>
  <div class="text-3xl font-semibold mt-1">{{ number_format($activeDrivers) }}</div>
  <div class="mt-2 text-xs text-slate-400">
    {{ $activePct }}% available • {{ $onlineDrivers }} online
  </div>
</div>

{{-- Orders --}}
<div class="card p-5 rounded-xl">
  <div class="text-sm text-slate-400">Today's Orders</div>
  <div class="text-3xl font-semibold mt-1">{{ number_format($todaysOrders) }}</div>
  <div class="mt-2 text-xs">
    <span class="{{ $orderDeltaPct >= 0 ? 'text-amber-300' : 'text-red-400' }}">
      {{ $orderDeltaPct >= 0 ? '↑' : '↓' }} {{ abs($orderDeltaPct) }}%
    </span>
    <span class="text-slate-400">vs yesterday</span>
  </div>
</div>

  <!-- Payment Received -->
<a href="/admin/payments">
  <div class="rounded-2xl bg-[#141c2b] border border-slate-700 p-6 hover:border-purple-500 transition hover:-translate-y-1 duration-200">
    <div class="flex items-start justify-between">
      <p class="text-sm text-slate-400">Payment Received</p>
      <div class="grid h-9 w-9 place-items-center rounded-lg bg-purple-500/15">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 21c4.97 0 9-4.03 9-9s-4.03-9-9-9-9 4.03-9 9c0 3.93 2.54 7.25 6.03 8.49l.97-2.47A7 7 0 1 1 19 12h2a9 9 0 1 0-9 9z" />
        </svg>
      </div>
    </div>

    <!-- Total Revenue -->
    <p class="mt-3 text-3xl font-semibold">${{ number_format($totalRevenue ?? 0, 2) }}</p>

    <!-- Breakdown by Method -->
    <div class="mt-4 space-y-1.5 text-sm text-slate-300">
      @foreach ($paymentByMethod as $method => $amount)
        <div class="flex justify-between">
          <span>{{ $method }}</span>
          <span>${{ number_format($amount, 2) }}</span>
        </div>
      @endforeach
    </div>
  </div>
</a>


<!-- Put once near end of <body> -->
<script src="https://unpkg.com/feather-icons"></script>
<script>feather.replace();</script>

<!-- Recent Activity (full width under the 4 KPIs) -->
<div class="card rounded-xl border p-5 col-span-4 min-h-[450px]">
  <div class="mb-2 flex items-center justify-between">  <!-- fixed: mb-2flex -->
    <h2 class="text-lg font-semibold">Recent Activity</h2>
  </div>

  <div class="divide-y divide-slate-800 max-h-[380px] overflow-y-auto pr-2">
    @forelse(($recent ?? []) as $order)
      <div class="flex items-center justify-between py-4">
        <div class="flex items-center gap-4">
          <div class="grid h-10 w-10 place-items-center rounded-lg bg-white/5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" viewBox="0 0 24 24" fill="currentColor">
              <path d="M10 17l-4-4 1.4-1.4L10 14.2l6.7-6.7 1.4 1.4z"/>
            </svg>
          </div>
          <div>
            <p class="font-medium">
              Order #{{ $order->order_no ?? $order->id }} {{ $order->status ?? '' }}
            </p>
            <p class="text-sm text-slate-400">
              {{ optional($order->user)->name ?? '—' }} • {{ optional($order->updated_at)->diffForHumans() }}
            </p> <!-- fixed: missing closing </p> -->
          </div>
        </div>
        <p class="font-medium">${{ number_format((float)($order->total_amount ?? 0), 2) }}</p>
      </div>
    @empty
      <div class="py-6 text-slate-400">No recent activity.</div>
    @endforelse
  </div>
</div>


      </section>
    </main>
  </div>
</body>
</html>
