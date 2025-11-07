<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BruFuel • Dashboard</title>

  <!-- Tailwind + Alpine -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    :root { color-scheme: dark; }
    body     { background:#0b1220; }
    .sidebar { background:#0f1625; }
    .card    { background:#141c2b; border-color:#1f2937; }
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
        <img src="{{ asset('images/Logook.png') }}" class="h-11 w-12" alt="BruFuel Logo">
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

    <!-- Drivers module -->
    <section id="driversApp" class="overflow-y-auto p-3" x-data="driversPage()" x-init="init()">

      <!-- Topbar (breadcrumb + quick actions) -->
      <div class="h-14 flex items-center justify-between px-4 border-b border-slate-800">
        <div class="text-sm text-slate-400">Admin / <span class="text-slate-200 font-medium">Drivers</span></div>
        <div class="flex items-center gap-2">
          <a href="{{ url('/admin/drivers') }}" class="px-3 py-1.5 rounded bg-slate-800 hover:bg-slate-700 text-sm">Refresh</a>
          <button @click="openCreate()" class="btn rounded-lg px-4 py-2 text-sm font-medium">Add Driver</button>
        </div>
      </div>

      <!-- Filters -->
      <div class="w-full p-4">
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

        <!-- Table -->
        <div class="overflow-x-auto -mx-2 md:mx-0">
          <table class="w-full table-fixed text-left">
            <colgroup>
              <col class="w-10">
              <col class="w-[38%] lg:w-[40%]">
              <col class="w-[30%] lg:w-[40%]">
              <col class="w-[20%]">
              <col class="w-[20%] lg:w-[30%]">
            </colgroup>

            <thead class="hidden md:table-header-group">
              <tr class="text-xs uppercase tracking-wide text-slate-400">
                <th class="py-2 pl-2 pr-3 text-left"></th>
                <th class="py-2 px-3 text-left">Driver</th>
                <th class="py-2 px-3 text-left">Contact</th>
                <th class="py-2 px-3 text-center">Status</th>
                <th class="py-2 pl-3 pr-4 text-right">Actions</th>
              </tr>
            </thead>

            <tbody class="divide-y divide-slate-800">
              @foreach($drivers as $driver)
                <tr class="align-middle">
                  <td class="py-3 pl-2 pr-3">
                    <input type="checkbox" class="h-4 w-4 rounded border-slate-600 bg-slate-900">
                  </td>

                  <td class="py-3 px-3">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-indigo-600 grid place-items-center text-white text-sm font-semibold">
                        {{ strtoupper(collect(explode(' ', $driver->name))->map(fn($n)=>substr($n,0,1))->take(2)->implode('')) }}
                      </div>
                      <div class="min-w-0">
                        <div class="font-semibold truncate">{{ $driver->name }}</div>
                        <div class="text-xs text-slate-400">ID: {{ $driver->driver_code }}</div>
                      </div>
                    </div>
                  </td>

                  <td class="py-3 px-3">
                    <div class="truncate">{{ $driver->email }}</div>
                    <div class="text-xs text-slate-400 truncate">{{ $driver->phone }}</div>
                  </td>

                  <td class="py-3 px-3 text-center">
                    @php $active = $driver->status === 'active'; @endphp
                    <span class="inline-flex h-7 items-center rounded-full px-3 text-xs font-medium whitespace-nowrap
                      {{ $active ? 'bg-emerald-900/40 text-emerald-300 border border-emerald-700'
                                 : 'bg-amber-900/30 text-amber-300 border border-amber-700' }}">
                      {{ ucfirst($driver->status) }}
                    </span>
                  </td>

                  <td class="py-3 pl-3 pr-4 text-right">
                    <div class="inline-flex items-center gap-2">
                      <button
                        @click="openEdit({{ $driver->id }})"
                        class="inline-flex h-8 items-center justify-center rounded bg-slate-700 hover:bg-slate-600 px-3 text-sm">
                        Edit
                      </button>
                      <button
                        @click="confirmDelete({{ $driver->id }})"
                        class="inline-flex h-8 items-center justify-center rounded bg-red-600 hover:bg-red-500 px-3 text-sm">
                        Delete
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
          {{ $drivers->links() }}
        </div>
      </div>

      <!-- Modal: Create/Edit -->
      <div
        x-show="modalOpen"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
      >
        <div class="relative w-[420px] rounded-2xl border border-amber-500/30 bg-[#101827] p-6 shadow-[0_0_40px_rgba(245,197,24,0.15)] text-slate-100">
          <button @click="modalOpen=false" class="absolute top-3 right-3 text-slate-400 hover:text-slate-200">✕</button>
          <h3 class="text-xl font-semibold mb-4 text-amber-400">
            <span x-text="mode === 'create' ? 'Add Driver' : 'Edit Driver'"></span>
          </h3>

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
              <button type="button" @click="modalOpen=false" class="px-4 py-2 rounded-lg bg-slate-700 text-sm hover:bg-slate-600 transition">Cancel</button>
              <button type="submit" class="px-4 py-2 rounded-lg text-sm font-medium bg-amber-500 hover:bg-amber-400 text-slate-900 transition">
                <span x-text="mode === 'create' ? 'Create' : 'Save'"></span>
              </button>
            </div>
          </form>
        </div>
      </div>

    </section>
  </main>
</div>

<!-- ===== Single script block (no duplicates) ===== -->
<script>
  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  async function http(url, opts = {}) {
    const base = {
      credentials: 'same-origin',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...(opts.method && opts.method !== 'GET' ? { 'Content-Type': 'application/json' } : {}),
        ...(token ? { 'X-CSRF-TOKEN': token } : {})
      }
    };
    const res = await fetch(url, { ...base, ...opts });
    if (!res.ok) {
      const txt = await res.text().catch(() => '');
      console.error('HTTP error', res.status, res.statusText, txt);
      throw new Error(`HTTP ${res.status}`);
    }
    const ct = res.headers.get('content-type') || '';
    return ct.includes('application/json') ? res.json() : {};
  }

  document.addEventListener('alpine:init', () => {
    Alpine.data('driversPage', () => ({
      modalOpen: false,
      mode: 'edit', // 'create' | 'edit'
      q: '{{ request('q','') }}',
      status: '{{ request('status','') }}',
      form: { id:null, name:'', email:'', phone:'', license_type:'', license_expiry:'', status:'inactive' },

      init(){},

      // CREATE
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

      // EDIT
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

      // DELETE
      async confirmDelete(id) {
        if (!confirm('Delete driver? This cannot be undone.')) return;
        try {
          const res = await http(`{{ url('/admin/drivers') }}/${id}`, { method: 'DELETE' });
          if (res.success) location.reload(); else alert('Delete failed');
        } catch (e) { alert('Delete error (see console)'); }
      },

      // FILTERS
      applyFilters() {
        const p = new URLSearchParams(window.location.search);
        this.q ? p.set('q', this.q) : p.delete('q');
        this.status ? p.set('status', this.status) : p.delete('status');
        window.location.search = p.toString();
      }
    }));
  });
</script>
</body>
</html>
