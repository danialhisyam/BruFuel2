<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>BruFuel • Users</title>

  <!-- Tailwind + Alpine -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    :root { color-scheme: dark; }
    [x-cloak]{ display:none !important; }
    body     { background:#0b1220; }
    .sidebar { background:#0f1625; }
    .card    { background:#141c2b; border-color:#1f2937; }
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
      <div class="grid h-12 w-12 place-items-center rounded-xl bg-white/10">
        <img src="/AdminPics/whiteshell.png" class="h-11 w-12" alt="Shell Icon">
      </div>
      <div>
        <p class="text-lg font-semibold">BruFuel</p>
        <!-- dynamic small role label -->
        <p class="text-xs text-slate-400" x-data x-text="$root.__x?.$data?.contextRole ?? 'Admin'"></p>
      </div>
    </div>

    <nav class="px-3">
      <ul class="space-y-1">
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/dashboard"><span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>Dashboard</a></li>
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/orders"><span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>Orders</a></li>
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 bg-indigo-500/15 text-white" href="/admin/users"><span class="inline-block h-1.5 w-1.5 rounded-full bg-indigo-400"></span>Users</a></li>
        <li><a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/drivers"><span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>Drivers</a></li>
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

    <!-- Users module -->
    <section class="mx-auto max-w-7xl px-6 py-8" x-data="usersPage()" x-init="init()">
      <!-- Top actions -->
      <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
          <h1 class="text-2xl font-semibold">User Management</h1>

          <!-- Role toggle -->
          <div class="inline-flex rounded-lg border border-slate-700 overflow-hidden ml-2">
            <button class="px-3 py-1.5 text-sm"
                    :class="contextRole==='Admin' ? 'bg-indigo-600 text-white' : 'text-slate-300'"
                    @click="setContext('Admin')">Admin</button>
            <button class="px-3 py-1.5 text-sm"
                    :class="contextRole==='Customer' ? 'bg-indigo-600 text-white' : 'text-slate-300'"
                    @click="setContext('Customer')">Customer</button>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M10 2a8 8 0 0 1 6.32 12.906l4.387 4.387-1.414 1.414-4.387-4.387A8 8 0 1 1 10 2zm0 2a6 6 0 1 0 .001 12.001A6 6 0 0 0 10 4z"/></svg>
            </span>
            <input x-model="q" @input="applyFilters" class="w-72 rounded-md border border-slate-700 bg-[#0f1625] pl-9 pr-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Search users" />
          </div>

          <!-- Import -->
          <input type="file" accept=".csv" class="hidden" x-ref="file" @change="handleImport($event)">
          <button class="btn rounded-md px-4 py-2 text-sm" @click="$refs.file.click()" x-show="!isStatic">Import</button>

          <!-- Export -->
          <div class="relative" x-data="{open:false}" x-show="!isStatic">
            <button @click="open=!open" class="btn rounded-md px-4 py-2 text-sm">Export ▾</button>
            <div x-cloak x-show="open" @click.outside="open=false" class="absolute right-0 mt-2 w-48 rounded-lg border border-slate-800 bg-[#0f1625] p-1 shadow-xl">
              <button @click="exportCSV(false); open=false" class="w-full rounded-md px-3 py-2 text-left text-sm hover:bg-[#141c2b]">All rows (CSV)</button>
              <button @click="exportCSV(true); open=false"  class="w-full rounded-md px-3 py-2 text-left text-sm hover:bg-[#141c2b]">Selected only (CSV)</button>
            </div>
          </div>

          <!-- Add -->
          <button x-show="!isStatic" @click="openForm()" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">+ Add User</button>
        </div>
      </div>

      <!-- Filters -->
      <div class="card rounded-lg border p-4 mb-6">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
          <div>
            <label class="mb-1 block text-sm text-slate-300">Role</label>
            <select class="input w-full rounded-md border px-3 py-2 text-sm" x-model="filters.role" @change="applyFilters">
              <option value="">All Roles</option>
              <option>Admin</option><option>Dispatcher</option><option>Driver</option><option>Customer</option>
            </select>
          </div>
          <div>
            <label class="mb-1 block text-sm text-slate-300">Status</label>
            <select class="input w-full rounded-md border px-3 py-2 text-sm" x-model="filters.status" @change="applyFilters">
              <option value="">All Statuses</option>
              <option>Active</option><option>Inactive</option><option>Pending</option>
            </select>
          </div>
          <div>
            <label class="mb-1 block text-sm text-slate-300">Last Login</label>
            <select class="input w-full rounded-md border px-3 py-2 text-sm" x-model="filters.last" @change="applyFilters">
              <option value="">Any Time</option>
              <option value="24h">Last 24 Hours</option>
              <option value="7d">Last 7 Days</option>
              <option value="30d">Last 30 Days</option>
            </select>
          </div>
          <div class="flex items-end">
            <button class="btn w-full rounded-md px-4 py-2 text-sm" @click="clearFilters">Clear Filters</button>
          </div>
        </div>
      </div>

      <!-- Bulk actions -->
      <div class="mb-4 flex flex-wrap items-center gap-3" x-show="!isStatic">
        <label class="inline-flex items-center gap-2 text-sm">
          <input type="checkbox" class="h-4 w-4 rounded border-slate-700 bg-[#0f1625] text-indigo-500 focus:ring-indigo-500" @change="toggleAll($event)">
          Select all
        </label>
        <select class="input rounded-md border px-3 py-2 text-sm" x-model="bulkAction">
          <option value="">Bulk Actions</option>
          <option value="activate">Activate</option>
          <option value="deactivate">Deactivate</option>
          <option value="delete">Delete</option>
          <option value="export">Export Selected</option>
        </select>
        <button class="btn rounded-md px-3 py-2 text-sm" @click="applyBulk">Apply</button>
      </div>

      <!-- Table -->
      <div class="overflow-hidden rounded-lg border border-slate-800">
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-[#0f1625] text-slate-300">
              <tr>
                <th class="py-3.5 pl-6 pr-3 text-left font-semibold">Name</th>
                <th class="px-3 py-3.5 text-left font-semibold">Email</th>
                <th class="px-3 py-3.5 text-left font-semibold">Role</th>
                <th class="px-3 py-3.5 text-left font-semibold">Status</th>
                <th class="px-3 py-3.5 text-left font-semibold">Last Login</th>
                <th class="py-3.5 pl-3 pr-6 text-right font-semibold">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-800 bg-[#141c2b]">
              <template x-for="(u, idx) in filtered" :key="u.id">
                <tr>
                  <td class="whitespace-nowrap py-4 pl-6 pr-3">
                    <div class="flex items-center gap-4">
                      <input x-show="!isStatic" type="checkbox" class="h-4 w-4 rounded border-slate-700 bg-[#0f1625] text-indigo-500" :value="u.id" x-model="selected">
                      <img class="h-10 w-10 rounded-full" :src="u.avatar || 'http://static.photos/people/200x200/1'" alt="">
                      <div>
                        <div class="font-medium" x-text="u.name"></div>
                        <div class="text-slate-400" x-text="'ID: ' + u.id"></div>
                      </div>
                    </div>
                  </td>
                  <td class="px-3 py-4 text-slate-300" x-text="u.email"></td>
                  <td class="px-3 py-4">
                    <span class="inline-flex items-center rounded-full border border-indigo-400/40 bg-indigo-400/10 px-2.5 py-0.5 text-xs font-medium text-indigo-300" x-text="u.role"></span>
                  </td>
                  <td class="px-3 py-4">
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                          :class="u.status==='Active' ? 'bg-emerald-400/10 text-emerald-300' : (u.status==='Inactive' ? 'bg-slate-400/10 text-slate-300' : 'bg-amber-400/10 text-amber-300')"
                          x-text="u.status"></span>
                  </td>
                  <td class="px-3 py-4 text-slate-300" x-text="displayLast(u.lastLogin)"></td>
                  <td class="py-4 pl-3 pr-6">
                    <div class="flex justify-end gap-2" x-show="!isStatic">
                      <button class="text-indigo-400 hover:text-indigo-300" @click="openForm(u, idx)">Edit</button>
                      <button class="text-slate-400 hover:text-slate-300" @click="view(u)">View</button>
                      <button class="text-rose-400 hover:text-rose-300" @click="remove(idx)">Delete</button>
                    </div>
                    <div class="text-slate-400 text-right" x-show="isStatic">View</div>
                  </td>
                </tr>
              </template>
              <tr x-show="filtered.length===0">
                <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-400">No users match the filters.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal -->
      <div x-cloak x-show="showForm" class="fixed inset-0 z-30 grid place-items-center bg-black/60 p-4" @keydown.escape.window="closeForm()">
        <div class="w-full max-w-xl rounded-2xl border border-slate-800 bg-[#0f1625] p-6 shadow-2xl" @click.outside="closeForm()">
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold" x-text="isEditing ? 'Edit User' : 'Add User'"></h2>
            <button class="rounded-md p-2 hover:bg-[#141c2b]" @click="closeForm()">✕</button>
          </div>

          <form @submit.prevent="isEditing ? update() : add()" class="grid grid-cols-1 gap-4">
            <div>
              <label class="mb-1 block text-sm text-slate-400">Name</label>
              <input class="input w-full rounded-lg border px-3 py-2 text-sm" x-model.trim="form.name" required>
            </div>
            <div>
              <label class="mb-1 block text-sm text-slate-400">Email</label>
              <input type="email" class="input w-full rounded-lg border px-3 py-2 text-sm" x-model.trim="form.email" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="mb-1 block text-sm text-slate-400">Role</label>
                <select class="input w-full rounded-lg border px-3 py-2 text-sm" x-model="form.role" required>
                  <option>Admin</option><option>Dispatcher</option><option>Driver</option><option>Customer</option>
                </select>
              </div>
              <div>
                <label class="mb-1 block text-sm text-slate-400">Status</label>
                <select class="input w-full rounded-lg border px-3 py-2 text-sm" x-model="form.status">
                  <option>Active</option><option>Inactive</option><option>Pending</option>
                </select>
              </div>
            </div>
            <div>
              <label class="mb-1 block text-sm text-slate-400">Avatar URL (optional)</label>
              <input class="input w-full rounded-lg border px-3 py-2 text-sm" x-model.trim="form.avatar" placeholder="https://…">
            </div>
            <div class="mt-2 flex justify-end gap-2">
              <button type="button" class="rounded-lg px-4 py-2 text-sm hover:bg-[#141c2b]" @click="closeForm()">Cancel</button>
              <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500" x-text="isEditing ? 'Save changes' : 'Add user'"></button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
</div>

<script>
function usersPage(){
  return {
    /* context & mutability */
     contextRole: 'Customer',  // start on Admin
    isStatic: true,         // Admin = static (read-only); Customer = CRUD

    /* datasets */
    adminData: [],          // fixed rows
    customerData: [],       // generated fake rows (per session)

    /* table state */
    all: [], filtered: [], selected: [],
    showForm:false, isEditing:false, editIndex:-1,
    bulkAction:'', q:'',
    filters:{ role:'', status:'', last:'' },

    /* form state */
    form:{ id:'', name:'', email:'', role:'Customer', status:'Active', lastLogin:'', avatar:'' },

    /* ---------- lifecycle ---------- */
   init(){
  this.applyContext();
},

setContext(role){
  this.contextRole = role;
  this.applyContext();
},

async applyContext(){
  this.isStatic = (this.contextRole === 'Admin'); // still controls CRUD visibility
  this.filters = { role: this.isStatic ? '' : 'Customer', status:'', last:'' };
  this.q = ''; this.selected = [];

  const res = await fetch(`/admin/users/data?context=${encodeURIComponent(this.contextRole)}`);
  this.all = await res.json();
  this.applyFilters();
},


    /* ---------- fake data ---------- */
    genFakeCustomers(n){
      const firsts = ['Alya','Isaac','Kana','Hafiz','Herman','Stuart','Darwish','Hafizah','Syuhada','Haikal','Mia','Miyu','Kaito','Aiman','Nadia'];
      const lasts  = ['Iffah','Lee','Tan','Gale','Muiz','Rahman','Azmi','Salleh','Hashim','Yusof','Kamal','Zain','Hisyam','Rosli','Said'];
      const statuses = ['Active','Inactive','Pending'];
      const arr = [];
      for(let i=0;i<n;i++){
        const f = firsts[Math.floor(Math.random()*firsts.length)];
        const l = lasts[Math.floor(Math.random()*lasts.length)];
        const name = `${f} ${l}`;
        const idNum = (100 + i).toString();
        const email = `${f}.${l}`.toLowerCase().replace(/[^a-z]/g,'.') + '@example.com';
        const status = statuses[Math.floor(Math.random()*statuses.length)];
        const lastLogin = [isoMinutes(5+Math.random()*55), isoHours(1+Math.random()*22), isoDays(1+Math.random()*5)][Math.floor(Math.random()*3)];
        arr.push({ id:`CU-${idNum}`, name, email, role:'Customer', status, lastLogin, avatar:'' });
      }
      return arr;
    },

    /* ---------- persistence (intentionally disabled) ---------- */
    persist(){ /* no-op: keep Admin static & Customer fake */ },

    /* ---------- search/filter ---------- */
    applyFilters(){
      const now = Date.now();
      const lim = this.filters.last==='24h'? 24*3600e3 :
                  this.filters.last==='7d' ? 7*24*3600e3 :
                  this.filters.last==='30d'? 30*24*3600e3 : null;
      const q = this.q.trim().toLowerCase();
      this.filtered = this.all.filter(u=>{
        const r = this.filters.role ? u.role===this.filters.role : true;
        const s = this.filters.status ? u.status===this.filters.status : true;
        const t = lim ? (now - new Date(u.lastLogin).getTime()) <= lim : true;
        const m = q ? (u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q)) : true;
        return r && s && t && m;
      });
    },
    clearFilters(){ this.filters={role:(this.contextRole==='Customer'?'Customer':''),status:'',last:''}; this.q=''; this.applyFilters(); },

    /* ---------- CRUD ---------- */
    openForm(row=null, idx=-1){
      if(this.isStatic) return;
      this.showForm = true;
      if(row){ this.isEditing=true; this.editIndex=idx; this.form = {...row}; }
      else {
        this.isEditing=false; this.editIndex=-1;
        const role = (this.contextRole==='Customer') ? 'Customer' : 'Admin';
        this.form = { id:this.nextId(role), name:'', email:'', role, status:'Active', lastLogin:new Date().toISOString(), avatar:'' };
      }
    },
    closeForm(){ this.showForm=false; },
    nextId(role){
      const prefix = role==='Customer' ? 'CU-' : 'FL-';
      const nums = this.all.map(u=>parseInt((u.id||'').replace(/[^0-9]/g,'')||0,10));
      const next = (Math.max(0,...nums)+1).toString().padStart(3,'0');
      return prefix + next;
    },
    add(){ if(this.isStatic) return; this.all.unshift({...this.form}); this.persist(); this.applyFilters(); this.showForm=false; },
    update(){
      if(this.isStatic) return;
      if(this.editIndex>-1){
        this.all.splice(this.editIndex,1,{...this.form});
        this.persist(); this.applyFilters(); this.showForm=false;
      }
    },
    remove(idx){
      if(this.isStatic) return;
      if(!confirm('Delete this user?')) return;
      const id = this.filtered[idx].id;
      const gi = this.all.findIndex(u=>u.id===id);
      if(gi>-1){ this.all.splice(gi,1); this.persist(); this.applyFilters(); this.selected = this.selected.filter(x=>x!==id); }
    },
    view(u){ alert(`User: ${u.name}\nEmail: ${u.email}\nRole: ${u.role}\nStatus: ${u.status}`); },

    toggleAll(e){
      if(this.isStatic){ this.selected=[]; e.target.checked=false; return; }
      this.selected = e.target.checked ? this.filtered.map(u=>u.id) : [];
    },
    applyBulk(){
      if(this.isStatic) return;
      if(!this.bulkAction) return;
      if(this.bulkAction==='export'){ this.exportCSV(true); return; }
      const ids = new Set(this.selected);
      if(this.bulkAction==='delete'){
        if(!confirm(`Delete ${ids.size} selected?`)) return;
        this.all = this.all.filter(u=>!ids.has(u.id));
      } else if(this.bulkAction==='activate' || this.bulkAction==='deactivate'){
        const status = this.bulkAction==='activate' ? 'Active' : 'Inactive';
        this.all = this.all.map(u=> ids.has(u.id) ? {...u, status} : u);
      }
      this.persist(); this.applyFilters(); this.selected=[];
    },

    /* ---------- import/export (Customer only) ---------- */
    exportCSV(onlySelected){
      const header = ['ID','Name','Email','Role','Status','LastLogin'];
      const list = onlySelected ? this.all.filter(u=>this.selected.includes(u.id)) : this.all;
      const rows = [header, ...list.map(u=>[u.id,u.name,u.email,u.role,u.status,u.lastLogin])];
      const csv = rows.map(r=>r.map(v=>`"${String(v??'').replaceAll('"','""')}"`).join(',')).join('\n');
      const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
      const a = document.createElement('a');
      a.href = URL.createObjectURL(blob);
      a.download = `users-${onlySelected?'selected-':''}${new Date().toISOString().slice(0,10)}.csv`;
      a.click(); URL.revokeObjectURL(a.href);
    },
    handleImport(e){
      if(this.isStatic) { e.target.value=''; return; }
      const f = e.target.files?.[0]; if(!f) return;
      const r = new FileReader();
      r.onload = ()=>{ try{ this.importCSV(r.result); } catch(err){ alert('Import failed: '+err.message); } e.target.value=''; };
      r.readAsText(f);
    },
    importCSV(text){
      const rows = this.parseCSV(text);
      if(!rows.length) throw new Error('Empty file');
      const header = rows[0].map(h=>h.trim());
      const req = ['ID','Name','Email','Role','Status','LastLogin'];
      const idx = Object.fromEntries(req.map(k=>[k, header.findIndex(h=>h.toLowerCase()===k.toLowerCase())]));
      if(req.some(k=>idx[k]===-1)) throw new Error('Expected headers: '+req.join(', '));

      const incoming = [];
      for(let i=1;i<rows.length;i++){
        const r = rows[i]; if(r.every(v=>!String(v).trim())) continue;
        const u = {
          id:        r[idx.ID]        || '',
          name:      r[idx.Name]      || '',
          email:     r[idx.Email]     || '',
          role:      r[idx.Role]      || 'Customer',
          status:    r[idx.Status]    || 'Active',
          lastLogin: r[idx.LastLogin] || new Date().toISOString(),
          avatar: ''
        };
        if(!u.id) u.id = this.nextId(u.role);
        incoming.push(u);
      }
      if(!incoming.length) throw new Error('No data rows found');

      if(confirm('Import: OK = Replace all rows,  Cancel = Append/Upsert')){
        this.all = incoming;
      } else {
        const map = new Map(this.all.map(u=>[u.id,u]));
        incoming.forEach(u=>map.set(u.id,u));
        this.all = Array.from(map.values());
      }
      this.persist(); this.applyFilters();
      alert('Import complete: '+incoming.length+' row(s).');
    },
    parseCSV(text){
      const out=[[]]; let i=0, field='', inQ=false;
      while(i<text.length){
        const c=text[i];
        if(inQ){
          if(c==='\"' && text[i+1]==='\"'){ field+='\"'; i+=2; continue; }
          if(c==='\"'){ inQ=false; i++; continue; }
          field+=c; i++; continue;
        } else {
          if(c==='\"'){ inQ=true; i++; continue; }
          if(c===','){ out[out.length-1].push(field); field=''; i++; continue; }
          if(c==='\n'){ out[out.length-1].push(field); field=''; out.push([]); i++; continue; }
          if(c==='\r'){ i++; continue; }
          field+=c; i++; continue;
        }
      }
      out[out.length-1].push(field);
      if(out.length && out[out.length-1].every(v=>v==='')) out.pop();
      return out;
    },

    /* ---------- formatting ---------- */
    displayLast(iso){
      const ms = Date.now() - new Date(iso).getTime();
      const m = Math.round(ms/60000), h=Math.round(ms/3600000), d=Math.round(ms/86400000);
      if(ms<3600000) return `${m} mins ago`;
      if(ms<86400000) return `${h} hours ago`;
      return `${d} days ago`;
    },
  }
}
function isoDays(d){ return new Date(Date.now()-d*24*3600e3).toISOString(); }
function isoHours(h){ return new Date(Date.now()-h*3600e3).toISOString(); }
function isoMinutes(m){ return new Date(Date.now()-m*60e3).toISOString(); }
fetch(`/api/users?context=${encodeURIComponent(this.contextRole)}`)
</script>
</body>
</html>
