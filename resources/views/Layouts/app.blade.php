{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BruFuel • Admin')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Tailwind CDN + Alpine (simple, zero build) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Tailwind theme tokens to match your UI --}}
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              brand: {
                bg:    '#0b1220',
                panel: '#0f1625',
                card:  '#141c2b',
                border:'#1f2937',
                accent:'#e5c546'
              }
            }
          }
        }
      }
    </script>

    <style>
      :root { color-scheme: dark; }
      html, body { height: 100%; }
      body { background: #0b1220; }
      .glass { backdrop-filter: blur(6px); background: rgba(20, 28, 43, .65); }
      .ring-brand { box-shadow: 0 0 0 2px rgba(229,197,70,.35); }
      .scroll-slim::-webkit-scrollbar { width: 8px; }
      .scroll-slim::-webkit-scrollbar-thumb { background:#1f2937; border-radius:6px; }
    </style>

    @stack('head') {{-- per-page extra <head> items --}}
</head>
<body class="text-slate-100 antialiased">

  <!-- Mobile overlay -->
  <div
    class="fixed inset-0 z-30 bg-black/40 md:hidden"
    x-show="sidebarOpen"
    x-transition.opacity
    @click="sidebarOpen=false"></div>

  <!-- Sidebar -->
  <aside
    class="fixed z-40 inset-y-0 left-0 w-72 overflow-y-auto scroll-slim border-r border-brand-border bg-brand-panel md:translate-x-0 transform transition-transform duration-200"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    <!-- Brand -->
    <div class="flex items-center gap-3 px-5 py-4 border-b border-brand-border">
      <div class="grid h-10 w-10 place-items-center rounded-lg bg-brand.card">
        {{-- Shell / fuel icon replacement --}}
        <span class="text-lg font-bold text-amber-300">⛽</span>
      </div>
      <div>
        <div class="text-lg font-semibold leading-tight">BruFuel</div>
        <div class="text-[11px] text-slate-400 tracking-wide">ADMIN</div>
      </div>
    </div>

    <!-- Nav -->
    <nav class="p-3 space-y-1">
      @php
        $is = fn($pattern) => request()->is($pattern);
        $item = function($href,$label,$icon,$active=false){
            $cls = $active
              ? 'bg-slate-800 text-white'
              : 'text-slate-300 hover:text-white hover:bg-slate-800/60';
            return <<<HTML
              <a href="{$href}" class="flex items-center gap-3 px-3 py-2 rounded-lg {$cls}">
                <span class="w-5 text-center">{$icon}</span>
                <span class="text-sm font-medium">{$label}</span>
              </a>
            HTML;
        };
      @endphp

      {!! $item(url('/admin/dashboard'), 'Dashboard', '🏠', $is('admin') || $is('admin/dashboard')) !!}
      {!! $item(url('/admin/orders'),    'Orders',    '🧾', $is('admin/orders*')) !!}
      {!! $item(url('/admin/users'),     'Users',     '👥', $is('admin/users*')) !!}
      {!! $item(url('/admin/drivers'),   'Drivers',   '🚚', $is('admin/drivers*')) !!}
      {!! $item(url('/admin/payments'),  'Payments',  '💳', $is('admin/payments*')) !!}
    </nav>

    <!-- Footer (logged in user) -->
    <div class="absolute bottom-0 inset-x-0 border-t border-brand-border p-3">
      <div class="flex items-center gap-3">
        <img class="h-10 w-10 rounded-full object-cover ring-1 ring-brand"
             src="https://i.pravatar.cc/100?img=5" alt="avatar">
        <div class="flex-1">
          <div class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin User' }}</div>
          <div class="text-xs text-slate-400">{{ auth()->user()->email ?? 'admin@example.com' }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="px-3 py-1 rounded bg-slate-800 text-xs hover:bg-slate-700">Logout</button>
        </form>
      </div>
    </div>
  </aside>

  <!-- Main column -->
  <div class="md:pl-72 min-h-screen flex flex-col">

    <!-- Top bar -->
    <header class="sticky top-0 z-20 border-b border-brand-border bg-brand.card/70 glass">
      <div class="h-14 flex items-center justify-between px-4">
        <div class="flex items-center gap-3">
          <button
            class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-lg bg-slate-800 hover:bg-slate-700"
            @click="sidebarOpen = !sidebarOpen" aria-label="Toggle menu">☰</button>
          <div class="text-sm text-slate-400">
            @yield('crumb', 'Admin / ') <span class="text-slate-200 font-medium">@yield('page', 'Dashboard')</span>
          </div>
        </div>

        <div class="flex items-center gap-2">
          {{-- Quick actions (export, filter, etc.) can be @section("actions") --}}
          @yield('actions')
        </div>
      </div>
    </header>

    <!-- Page content wrapper -->
    <main class="flex-1">
      <div class="mx-auto max-w-7xl p-4 md:p-6">
        @yield('content')
      </div>
    </main>

    <!-- Footer (optional) -->
    <footer class="border-t border-brand-border text-xs text-slate-400 px-6 py-3">
      © {{ now()->year }} BruFuel Admin
    </footer>
  </div>

  @stack('scripts') {{-- per-page scripts --}}
</body>
</html>
