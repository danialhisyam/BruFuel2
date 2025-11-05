<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
 <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BruFuel • Dashboard</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Alpine.js (load ONCE) -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    :root { color-scheme: dark; }
    body     { background:#0b1220; }         /* page bg (dark blue/black) */
    .sidebar { background:#0f1625; }         /* sidebar bg */
    .card    { background:#141c2b; border-color:#1f2937; } /* card/border */
    .chip    { background:#111827; }
    .btn     { background:#1f2937; }
    .btn:hover{ background:#263041; }
    .input   { background:#0f1625; border-color:#1f2937; }
  </style>
</head>
<body class="min-h-screen text-slate-100 antialiased">
<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="sidebar w-64 shrink-0 border-r border-slate-800 flex flex-col">
    <div class="flex items-center gap-3 px-5 py-5">
      <div class="grid h-12 w-12 place-items-center rounded-xl bg-black-500/20">
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
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 bg-indigo-500/15 text-white" href="/admin/drivers"><span class="inline-block h-1.5 w-1.5 rounded-full bg-indigo-400"></span>Drivers</a></li>
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/payments"><span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>Payments</a></li>
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

   <!-- MAIN -->
    <main class="flex-1">
      <!-- Top bar (brand left, avatar far right) -->
      <header class="border-b border-slate-800">
     <div class="w-full px-5 py-4 flex items-center justify-between">
      
          <!-- Brand on FAR LEFT -->
          <div class="flex items-center gap-2">
            <span class="text-xl font-bold">BruFuel</span>
            <span class="text-xs font-semibold text-slate-900 bg-amber-400/90 px-2 py-0.5 rounded">ADMIN</span>
          </div>

          <!-- Avatar on FAR RIGHT -->
          <img class="h-8 w-8 rounded-full" src="http://static.photos/workspace/200x200/5" alt="Admin avatar" />
        </div>
      </header>

    <!-- Drivers module -->
  <section id="driversApp" class="overflow-y-auto p-3" x-data="driversPage()" x-init="init()">


  

  {{-- ============================== MAIN COLUMN (TOPBAR + PAGE) ============================== --}}
 <div class=" min-h-screen flex flex-col">

    {{-- ---------- TOPBAR (breadcrumb + quick actions) ---------- --}}
    <header class="sticky top-0 z-20 border-b border-brand-border glass">
      <div class="h-14 flex items-center justify-between px-4">
        <div class="flex items-center gap-3">
          <button class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-lg bg-slate-800 hover:bg-slate-700"
                  @click="sidebarOpen=!sidebarOpen" aria-label="Menu">☰</button>
          <div class="text-sm text-slate-400">Admin / <span class="text-slate-200 font-medium">Drivers</span></div>
        </div>
        <div class="flex items-center gap-2">
          <a href="{{ url('/admin/drivers') }}" class="px-3 py-1.5 rounded bg-slate-800 hover:bg-slate-700 text-sm">Refresh</a>
        </div>
      </div>
    </header>

    {{-- ---------- PAGE CONTENT ---------- --}}
    <main class="flex-1">
      <div class="w-full p-3 md:p-5 lg:p-6 xl:p-8 
            mx-auto max-w-screen-xl 2xl:max-w-[1600px]">



        {{-- ===== FILTERS / SEARCH ROW ===== --}}
        <div class="mb-4 flex gap-3">
          <input type="text" x-model="q" placeholder="Search name, code, email"
                 @keydown.enter="applyFilters()" class="px-3 py-2 rounded bg-slate-800 w-64">
          <select x-model="status" class="px-3 py-2 rounded bg-slate-800">
            <option value="">All Status</option>
            <option value="active" {{ request('status')==='active'?'selected':'' }}>Active</option>
            <option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>Inactive</option>
          </select>
          <button @click="applyFilters()" class="px-4 py-2 rounded bg-blue-600">Apply</button>
        </div>

            <!-- Header & actions -->
      <div class="sticky top-0 z-20 border-b border-slate-800/80 backdrop-blur supports-[backdrop-filter]:bg-[#0b1220]/70">
        <div class="w-full max-w-none px-6 py-4 flex items-center justify-between">

          <div>
            <h1 class="text-2xl font-semibold">Drivers</h1>
            <p class="text-sm text-slate-400">Manage your fleet drivers and their information.</p>
          </div>
          <div class="flex items-center gap-2">
            <button @click="openCreate()" class="btn rounded-lg px-4 py-2 text-sm font-medium">Add Driver</button>


        @if (Route::has('logout'))
        <form method="POST" action="{{ route('logout') }}">@csrf
          <button class="px-3 py-1 rounded bg-slate-800 text-xs hover:bg-slate-700">Logout</button>
        </form>
        @endif
      </div>
    </div>

          {{-- ---- Table ---- --}}
         <div class="overflow-x-auto -mx-2 md:mx-0">
  <table class="w-full table-fixed text-left">
    <colgroup>
      <col class="w-10">
      <col class="w-[38%] lg:w-[40%] xl:w-[42%]">
      <col class="w-[16%] lg:w-[18%]">
      <col class="w-[26%] lg:w-[24%] xl:w-[22%]">
      <col class="w-[10%]">
      <col class="w-[10%]">
    </colgroup>

              <tbody class="divide-y divide-slate-800">
              @foreach($drivers as $driver)
                <tr>
                  <td class="py-3 w-10"><input type="checkbox"></td>

                  {{-- Driver identity cell (avatar initials + name + code) --}}
                  <td class="py-3">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-indigo-600 grid place-items-center text-white">
                        {{ strtoupper(collect(explode(' ', $driver->name))->map(fn($n)=>substr($n,0,1))->take(2)->implode('')) }}
                      </div>
                      <div>
                        <div class="font-semibold">{{ $driver->name }}</div>
                        <div class="text-xs text-slate-400">ID: {{ $driver->driver_code }}</div>
                      </div>
                    </div>
                  </td>

                  {{-- License info --}}
                  <td>
                    <div>{{ $driver->license_type ?? '-' }}</div>
                    <div class="text-xs text-slate-400">
                      Exp: {{ \Illuminate\Support\Carbon::parse($driver->license_expiry)->format('Y-m-d') }}
                    </div>
                  </td>

                  {{-- Contact info --}}
                  <td>
                    <div>{{ $driver->email }}</div>
                    <div class="text-xs text-slate-400">{{ $driver->phone }}</div>
                  </td>

                  {{-- Status pill --}}
                  <td>
                    @php $active = $driver->status === 'active'; @endphp
                    <span class="px-2 py-1 rounded text-xs {{ $active ? 'bg-green-800 text-green-300' : 'bg-amber-800 text-amber-300' }}">
                      {{ ucfirst($driver->status) }}
                    </span>
                  </td>

                  {{-- Row actions --}}
                  <td class="text-right">
                    <button class="px-3 py-1 rounded bg-slate-700 text-sm mr-2"
                            @click="openEdit({{ $driver->id }})">Edit</button>
                    <button class="px-3 py-1 rounded bg-red-600 text-sm"
                            @click="confirmDelete({{ $driver->id }})">Delete</button>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          <div class="mt-4">
            {{ $drivers->links() }}
          </div>
        </div>

      </div>
    </main>
  </div>

  {{-- ============================== EDIT MODAL ============================== --}}
  {{-- ============================== EDIT MODAL ============================== --}}
<div 
  x-show="modalOpen" 
  x-transition.opacity 
  class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
>
  <div 
    class="relative w-[420px] rounded-2xl border border-amber-500/30 bg-[#101827] p-6 shadow-[0_0_40px_rgba(245,197,24,0.15)] text-slate-100"
  >
    <!-- Close button -->
    <button 
      @click="modalOpen=false"
      class="absolute top-3 right-3 text-slate-400 hover:text-slate-200"
    >✕</button>

    <h3 class="text-xl font-semibold mb-4 text-amber-400">
      <span x-text="mode === 'create' ? 'Add Driver' : 'Edit Driver'"></span>
    </h3>

    <!-- Form -->
    <form @submit.prevent="mode === 'create' ? submitCreate() : submitEdit()">
      <div class="space-y-3">
        <label class="block text-sm">
          <span class="text-slate-300">Name</span>
          <input x-model="form.name" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg focus:ring-2 focus:ring-amber-400 focus:outline-none" required>
        </label>

        <label class="block text-sm">
          <span class="text-slate-300">Email</span>
          <input x-model="form.email" type="email" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg focus:ring-2 focus:ring-amber-400 focus:outline-none">
        </label>

        <label class="block text-sm">
          <span class="text-slate-300">Phone</span>
          <input x-model="form.phone" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg focus:ring-2 focus:ring-amber-400 focus:outline-none">
        </label>

        <label class="block text-sm">
          <span class="text-slate-300">License Type</span>
          <input x-model="form.license_type" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg focus:ring-2 focus:ring-amber-400 focus:outline-none">
        </label>

        <label class="block text-sm">
          <span class="text-slate-300">Expiry</span>
          <input x-model="form.license_expiry" type="date" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg focus:ring-2 focus:ring-amber-400 focus:outline-none">
        </label>

        <label class="block text-sm">
          <span class="text-slate-300">Status</span>
          <select x-model="form.status" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg focus:ring-2 focus:ring-amber-400 focus:outline-none">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </label>
      </div>

      <div class="flex justify-end gap-3 mt-5">
        <button 
          type="button" 
          @click="modalOpen=false" 
          class="px-4 py-2 rounded-lg bg-slate-700 text-sm hover:bg-slate-600 transition"
        >Cancel</button>

        <button 
          type="submit" 
          class="px-4 py-2 rounded-lg text-sm font-medium bg-amber-500 hover:bg-amber-400 text-slate-900 transition"
        >
          <span x-text="mode === 'create' ? 'Create' : 'Save'"></span>
        </button>
      </div>
    </form>
  </div>
</div>
    </div>
  </div>

  {{-- ============================== PAGE SCRIPTS (CRUD via fetch) ============================== --}}
  <script>
  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Helper to access the Alpine component by id
  const $app = () => Alpine.$data(document.getElementById('driversApp'));

  // Generic HTTP wrapper for fetch with Laravel-friendly defaults
  async function http(url, opts = {}) {
    const base = {
      credentials: 'same-origin', // send session cookies
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...(opts.method && opts.method !== 'GET' ? { 'Content-Type': 'application/json' } : {}),
        ...(token ? { 'X-CSRF-TOKEN': token } : {})
      }
    };
    const res = await fetch(url, { ...base, ...opts });
    if (!res.ok) {
      const text = await res.text().catch(() => '');
      console.error('HTTP error', res.status, res.statusText, text);
      throw new Error(`HTTP ${res.status}`);
    }
    const ct = res.headers.get('content-type') || '';
    return ct.includes('application/json') ? res.json() : {};
  }

  // Alpine component
  document.addEventListener('alpine:init', () => {
    Alpine.data('driversPage', () => ({
      modalOpen: false,
      mode: 'edit', // 'create' | 'edit'
      q: '{{ request('q','') }}',
      status: '{{ request('status','') }}',
      form: { id:null, name:'', email:'', phone:'', license_type:'', license_expiry:'', status:'inactive' },

      init(){},

      // ------- CREATE -------
      openCreate() {
        this.mode = 'create';
        this.form = { id:null, name:'', email:'', phone:'', license_type:'', license_expiry:'', status:'inactive' };
        this.modalOpen = true;
      },
      async submitCreate() {
        try {
          const res = await http(`{{ route('admin.drivers.store') }}`, {
            method: 'POST',
            body: JSON.stringify(this.form)
          });
          if (res.success) location.reload(); else alert('Create failed');
        } catch (e) { alert('Create error (see console)'); }
      },

      // ------- EDIT -------
      async openEdit(id) {
        try {
          const d = await http(`{{ url('/admin/drivers') }}/${id}`);
          this.mode = 'edit';
          this.form = {
            id: d.id,
            name: d.name ?? '',
            email: d.email ?? '',
            phone: d.phone ?? '',
            license_type: d.license_type ?? '',
            license_expiry: d.license_expiry ? String(d.license_expiry).slice(0,10) : '',
            status: d.status ?? 'inactive'
          };
          this.modalOpen = true;
        } catch (e) { alert('Failed to load driver (see console)'); }
      },
      async submitEdit() {
        try {
          const res = await http(`{{ url('/admin/drivers') }}/${this.form.id}`, {
            method: 'PUT',
            body: JSON.stringify(this.form)
          });
          if (res.success) location.reload(); else alert('Update failed');
        } catch (e) { alert('Update error (see console)'); }
      },

      // ------- DELETE -------
      async confirmDelete(id) {
        if (!confirm('Delete driver? This cannot be undone.')) return;
        try {
          const res = await http(`{{ url('/admin/drivers') }}/${id}`, { method: 'DELETE' });
          if (res.success) location.reload(); else alert('Delete failed');
        } catch (e) { alert('Delete error (see console)'); }
      },

      // ------- FILTERS -------
      applyFilters() {
        const p = new URLSearchParams(window.location.search);
        this.q ? p.set('q', this.q) : p.delete('q');
        this.status ? p.set('status', this.status) : p.delete('status');
        window.location.search = p.toString();
      }
    }));
  });
</script>
