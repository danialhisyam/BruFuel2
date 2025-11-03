<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>BruFuel • Payments</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <style>
    :root { color-scheme: dark; }
    body     { background:#0b1220; }
    .sidebar { background:#0f1625; }
    .card    { background:#141c2b; border:1px solid #1f2937; }
  </style>
</head>
<body class="min-h-screen text-slate-100 antialiased">
<div class="flex min-h-screen">

  {{-- Sidebar --}}
  <aside class="sidebar w-64 shrink-0 border-r border-slate-800 flex flex-col">
    <div class="flex items-center gap-3 px-5 py-5">
      <div class="grid h-12 w-12 place-items-center rounded-xl bg-white/5">
        <img src="/AdminPics/whiteshell.png" class="h-11 w-12" alt="Shell Icon">
      </div>
      <div>
        <p class="text-lg font-semibold">BruFuel</p>
        <p class="text-xs text-slate-400">Admin</p>
      </div>
    </div>

    <nav class="px-3">
      <ul class="space-y-1">
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/dashboard"><span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>Dashboard</a></li>
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/orders"><span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>Orders</a></li>
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/users"><span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>Users</a></li>
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/drivers"><span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>Drivers</a></li>
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 bg-indigo-500/15 text-white" href="/admin/payments"><span class="inline-block h-1.5 w-1.5 rounded-full bg-indigo-400"></span>Payments</a></li>
      </ul>
    </nav>

    <div class="mt-auto p-4">
      <div class="flex items-center gap-3 rounded-xl border border-slate-800 bg-[#0b1220] p-3">
        <div class="grid h-9 w-9 place-items-center rounded-full bg-white/10">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z"/><path d="M12 14c-5 0-9 2.5-9 5v1h18v-1c0-2.5-4-5-9-5z"/></svg>
        </div>
        <div class="text-sm">
          <p class="font-medium">Admin User</p>
          <p class="text-slate-400">Administrator</p>
        </div>
      </div>
    </div>
  </aside>

  {{-- Main --}}
  <main class="flex-1">
    <header class="border-b border-slate-800">
      <div class="w-full px-5 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="text-xl font-bold">BruFuel</span>
          <span class="text-xs font-semibold text-slate-900 bg-amber-400/90 px-2 py-0.5 rounded">ADMIN</span>
        </div>
        <img class="h-8 w-8 rounded-full" src="http://static.photos/workspace/200x200/5" alt="Admin avatar" />
      </div>
    </header>

    <div class="max-w-7xl mx-auto px-5 py-6 space-y-6">

      {{-- Title + Export --}}
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold">Payment Overview</h1>
          <p class="text-slate-400 text-sm">Search, filter, and export your payments.</p>
        </div>
        <div class="flex gap-2">
          <a href="{{ route('admin.payments.export.excel', request()->query()) }}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400">EXPORT TO EXCEL</a>
          <a href="{{ route('admin.payments.export.csv', request()->query()) }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500">EXPORT TO CSV</a>
        </div>
      </div>

      {{-- KPIs --}}
      <section class="grid md:grid-cols-4 gap-4">
        <div class="card rounded-2xl p-5"><p class="text-sm text-slate-400">Total Revenue</p><p class="text-3xl font-extrabold mt-1">B${{ number_format($totalRevenue, 2) }}</p></div>
        <div class="card rounded-2xl p-5"><p class="text-sm text-slate-400">Total Transactions</p><p class="text-3xl font-extrabold mt-1">{{ $totalTransactions }}</p></div>
        <div class="card rounded-2xl p-5"><p class="text-sm text-slate-400">Pending</p><p class="text-3xl font-extrabold mt-1 text-amber-400">{{ $pending }}</p></div>
        <div class="card rounded-2xl p-5"><p class="text-sm text-slate-400">Failed</p><p class="text-3xl font-extrabold mt-1 text-rose-400">{{ $failed }}</p></div>
      </section>

      {{-- Chart + Filters --}}
      <section class="grid lg:grid-cols-3 gap-6">
        <div class="card rounded-2xl p-5 lg:col-span-1" style="height:260px">
          <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold">Revenue (B$)</h3>
            <span class="text-xs text-slate-400">Monthly</span>
          </div>
          <canvas id="revChart" style="height:100%"></canvas>
        </div>

        <div class="card rounded-2xl p-5 lg:col-span-2">
          <h3 class="font-semibold mb-4">Filters</h3>
          <form method="GET" action="{{ route('admin.payments') }}" class="grid sm:grid-cols-2 xl:grid-cols-4 gap-3">
            <div>
              <label class="text-sm text-slate-400">Search</label>
              <input name="search" value="{{ request('search') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900/40 px-3 py-2" placeholder="Name, Order ID (e.g. ORD-0012), Provider…"/>
            </div>
            <div>
              <label class="text-sm text-slate-400">Status</label>
              <select name="status" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900/40 px-3 py-2">
                @foreach (['All','Paid','Pending','Fail'] as $s)
                  <option value="{{ $s }}" {{ request('status','All')===$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="text-sm text-slate-400">Provider</label>
              <select name="provider" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900/40 px-3 py-2">
                <option {{ request('provider','All')==='All'?'selected':'' }}>All</option>
                @foreach ($providers as $prov)
                  <option value="{{ $prov }}" {{ request('provider')===$prov?'selected':'' }}>{{ $prov }}</option>
                @endforeach
              </select>
            </div>
            <div class="grid grid-cols-2 gap-2">
              <div>
                <label class="text-sm text-slate-400">From</label>
                <input type="date" name="from" value="{{ request('from') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900/40 px-3 py-2"/>
              </div>
              <div>
                <label class="text-sm text-slate-400">To</label>
                <input type="date" name="to" value="{{ request('to') }}" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900/40 px-3 py-2"/>
              </div>
            </div>

            <div class="col-span-full flex gap-2 mt-1">
              <button class="px-3 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-sm">Apply</button>
              <a href="{{ route('admin.payments') }}" class="px-3 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-sm">Reset</a>
            </div>
          </form>
        </div>
      </section>

      {{-- Table --}}
      <section class="card rounded-2xl overflow-hidden">
        <div class="p-5 border-b border-slate-700/50 flex items-center justify-between">
          <h3 class="font-semibold">Transactions</h3>
          <span class="text-sm text-slate-400">{{ $payments->total() }} results</span>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-slate-900/40 text-slate-300">
              <tr>
                <th class="px-4 py-3 text-left">Name / Order ID</th>
                <th class="px-4 py-3 text-left">Date / Time</th>
                <th class="px-4 py-3 text-right">Amount (B$)</th>
                <th class="px-4 py-3 text-left">Provider</th>
                <th class="px-4 py-3 text-left">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/40">
              @forelse ($payments as $p)
                @php
                  $oid = 'ORD-' . str_pad($p->id, 4, '0', STR_PAD_LEFT);
                  $dt  = $p->paid_at ?? $p->created_at;
                  $badge = match($p->status) {
                    'Paid'    => 'bg-green-500/15 text-green-400',
                    'Pending' => 'bg-amber-500/15 text-amber-400',
                    'Fail'    => 'bg-rose-500/15 text-rose-400',
                    default   => 'bg-slate-500/15 text-slate-300',
                  };
                @endphp
                <tr class="hover:bg-slate-900/30">
                  <td class="px-4 py-3">
                    <div class="font-medium">{{ $p->customer_name }}</div>
                    <div class="text-xs text-slate-400">ID: {{ $oid }}</div>
                  </td>
                  <td class="px-4 py-3">
                    <div>{{ optional($dt)->format('M d, Y') }}</div>
                    <div class="text-xs text-slate-400">{{ optional($dt)->format('h:i A') }}</div>
                  </td>
                  <td class="px-4 py-3 text-right font-semibold">B${{ number_format($p->amount, 2) }}</td>
                  <td class="px-4 py-3">{{ $p->provider }}</td>
                  <td class="px-4 py-3"><span class="inline-flex px-2 py-1 rounded-md text-xs font-semibold {{ $badge }}">{{ $p->status }}</span></td>
                </tr>
              @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-400">No transactions found.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="px-5 py-4">
          {{ $payments->links() }}
        </div>
      </section>
    </div>
  </main>
</div>

{{-- Chart script --}}
<script>
  const labels = @json($chartLabels);
  const data   = @json($chartData);
  new Chart(document.getElementById('revChart'), {
    type: 'bar',
    data: { labels, datasets: [{ label: 'Paid Revenue', data, backgroundColor: '#e5c546' }] },
    options: { animation:false, maintainAspectRatio:false, plugins:{ legend:{display:false} } }
  });
</script>
</body>
</html>
