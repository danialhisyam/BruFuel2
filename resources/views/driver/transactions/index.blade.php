<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Driver Transaction BruFuel</title>
  <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>

  <style>
    :root { color-scheme: dark; }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to bottom right, #0b1220, #141c2b);
      color: #e2e8f0;
      min-height: 100vh;
    }

    .glass-card {
      background: rgba(20, 28, 43, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(60, 72, 100, 0.3);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
      transition: all 0.3s ease;
    }

    .glass-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
    }

    .tab-active {
      background: linear-gradient(to right, #2563eb, #4f46e5);
      color: white;
      box-shadow: 0 3px 8px rgba(37, 99, 235, 0.4);
    }

    .tab {
      transition: all 0.25s ease;
      color: #cbd5e1;
    }

    .tab:hover {
      background-color: rgba(37, 99, 235, 0.1);
    }

    .transaction-item {
      background: rgba(15, 22, 37, 0.8);
      border: 1px solid rgba(45, 55, 72, 0.6);
      transition: all 0.3s ease;
    }

    .transaction-item:hover {
      background: rgba(30, 41, 59, 0.9);
    }

    header {
      background: linear-gradient(to right, #1e3a8a, #3730a3);
      color: white;
    }

    .text-gray-500 { color: #94a3b8 !important; }
    .text-gray-600 { color: #cbd5e1 !important; }

    .bg-gray-50 { background: #0f1625 !important; border-top: 1px solid #1e293b; }

    footer { color: #94a3b8; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade {
      animation: fadeIn 0.4s ease-in-out;
    }
  </style>
</head>

<body>
  <div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="p-4 shadow-md">
      <div class="container mx-auto flex items-center gap-3">
        <a href="{{ route('driver.dashboard') }}" class="p-2 rounded-full hover:bg-white/10 transition">
          <i data-feather="arrow-left" class="w-5 h-5 text-white"></i>
        </a>
        <h1 class="text-xl font-semibold tracking-wide">Transactions</h1>
      </div>
    </header>

    <!-- Main -->
    <main class="flex-grow container mx-auto p-6 animate-fade">
      <div class="glass-card rounded-2xl overflow-hidden">
        <!-- Earnings Summary -->
        <div class="p-6 bg-gradient-to-r from-blue-700 to-indigo-700 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-lg font-medium opacity-90">Total Earnings</h2>
            <p class="text-4xl font-bold mt-1">$1,245.50</p>
            <p class="text-sm opacity-80 mt-1">Last 30 days: $876.25</p>
          </div>
          <button class="mt-4 sm:mt-0 px-4 py-2 bg-white/20 rounded-lg text-sm hover:bg-white/30 transition">
            Download Report
          </button>
        </div>

        <!-- Tabs -->
        <div class="flex justify-around p-4 border-b border-slate-700 bg-[#0f1625] text-sm font-medium">
          <button class="tab tab-active px-4 py-2 rounded-full" data-tab="all">All</button>
          <button class="tab px-4 py-2 rounded-full" data-tab="completed">Completed</button>
          <button class="tab px-4 py-2 rounded-full" data-tab="pending">Pending</button>
          <button class="tab px-4 py-2 rounded-full" data-tab="cancelled">Cancelled</button>
        </div>

        <!-- Transaction List -->
        <div id="transactions" class="p-6 space-y-4">
          @foreach($transactions as $t)
            <div class="transaction-item flex items-center justify-between p-4 rounded-xl transition"
                data-status="{{ $t->status }}">
              <div class="flex items-center gap-3">
                <div class="p-3 rounded-full
                    @if($t->status=='completed') bg-green-900/30
                    @elseif($t->status=='pending') bg-yellow-900/30
                    @else bg-red-900/30 @endif">
                  <i data-feather="
                    @if($t->status=='completed') dollar-sign
                    @elseif($t->status=='pending') clock
                    @else alert-circle @endif"
                    class="w-5 h-5
                    @if($t->status=='completed') text-green-400
                    @elseif($t->status=='pending') text-yellow-400
                    @else text-red-400 @endif"></i>
                </div>
                <div>
                  <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($t->transaction_date)->format('M d, Y h:i A') }}
                  </p>
                </div>
              </div>
              <div class="text-right">
                @if($t->status=='completed')
                  <p class="font-semibold text-green-400">+${{ number_format($t->amount, 2) }}</p>
                  <p class="text-xs text-gray-500">Completed</p>
                @elseif($t->status=='pending')
                  <p class="font-semibold text-yellow-400">Pending</p>
                  <p class="text-xs text-gray-500">Awaiting confirmation</p>
                @else
                  <p class="font-semibold text-red-400">-${{ number_format($t->amount, 2) }}</p>
                  <p class="text-xs text-gray-500">Cancelled</p>
                @endif
              </div>
            </div>
          @endforeach
        </div>

        <!-- Footer Button -->
        <div class="p-4 border-t border-slate-700 bg-[#0f1625]">
          <a href="{{ route('driver.dashboard') }}" 
            class="block w-full text-center py-3 rounded-xl bg-gradient-to-r from-blue-700 to-indigo-700 text-white font-medium hover:opacity-90 transition">
            ← Return to Dashboard
          </a>
        </div>
      </div>
    </main>

    <footer class="text-sm text-center p-4 mt-8">
      © 2025 <span class="font-semibold text-blue-500">BruFuel</span>. All rights reserved.
    </footer>
  </div>

  <script>
    feather.replace();

    const tabs = document.querySelectorAll('.tab');
    const items = document.querySelectorAll('.transaction-item');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('tab-active'));
        tab.classList.add('tab-active');
        const selected = tab.dataset.tab;

        items.forEach(item => {
          const status = item.dataset.status;
          item.style.display = (selected === 'all' || status === selected) ? 'flex' : 'none';
        });
      });
    });
  </script>
</body>
</html>
