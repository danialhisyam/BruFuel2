<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
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
    <section class="overflow-y-auto p-3" x-data="driversPage()" x-init="init()">

      <!-- Header & actions -->
      <div class="sticky top-0 z-20 border-b border-slate-800/80 backdrop-blur supports-[backdrop-filter]:bg-[#0b1220]/70">
        <div class="mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold">Drivers</h1>
            <p class="text-sm text-slate-400">Manage your fleet drivers and their information.</p>
          </div>
          <div class="flex items-center gap-2">
            <button @click="openForm()" class="btn rounded-lg px-4 py-2 text-sm font-medium">Add Driver</button>

            <!-- Import (CSV) -->
            <input type="file" accept=".csv" class="hidden" x-ref="file" @change="handleImport($event)">
            <button @click="$refs.file.click()" class="btn rounded-lg px-4 py-2 text-sm font-medium">Import</button>

            <!-- Export -->
            <div class="relative" x-data="{open:false}">
              <button @click="open=!open" class="btn rounded-lg px-4 py-2 text-sm font-medium">Export ▾</button>
              <div x-cloak x-show="open" @click.outside="open=false" class="absolute right-0 mt-2 w-48 rounded-lg border border-slate-800 bg-[#0f1625] p-1 shadow-xl">
                <button @click="exportCSV(false); open=false" class="w-full rounded-md px-3 py-2 text-left text-sm hover:bg-[#141c2b]">All rows (CSV)</button>
                <button @click="exportCSV(true); open=false"  class="w-full rounded-md px-3 py-2 text-left text-sm hover:bg-[#141c2b]">Selected only (CSV)</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="mx-auto max-w-7xl px-4 py-6">
        <div class="grid gap-3 md:grid-cols-4">
          <div>
            <label class="mb-1 block text-sm text-slate-400">Status</label>
            <select class="input w-full rounded-lg border px-3 py-2 text-sm" x-model="filters.status">
              <option value="">All Status</option>
              <option>Active</option>
              <option>Inactive</option>
            </select>
          </div>
          <div>
            <label class="mb-1 block text-sm text-slate-400">License Type</label>
            <select class="input w-full rounded-lg border px-3 py-2 text-sm" x-model="filters.license">
              <option value="">All Types</option>
              <option>Class A</option>
              <option>Class B</option>
              <option>Class C</option>
            </select>
          </div>
          <div>
            <label class="mb-1 block text-sm text-slate-400">Expiry Before</label>
            <input type="date" class="input w-full rounded-lg border px-3 py-2 text-sm" x-model="filters.expBefore">
          </div>
          <div class="flex items-end">
            <button @click="applyFilters()" class="btn w-full rounded-lg px-4 py-2 text-sm font-medium">Apply Filters</button>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="mx-auto max-w-7xl px-4 pb-24">
        <div class="overflow-hidden rounded-xl border border-slate-800/80">
          <table class="w-full text-left">
            <thead class="bg-[#0f1625] text-xs uppercase text-slate-400">
            <tr>
              <th class="px-5 py-3 w-10"><input type="checkbox" @change="toggleAll($event)"></th>
              <th class="px-5 py-3">Driver</th>
              <th class="px-5 py-3">License</th>
              <th class="px-5 py-3">Contact</th>
              <th class="px-5 py-3">Status</th>
              <th class="px-5 py-3 text-right">Actions</th>
            </tr>
            </thead>
            <tbody>
            <template x-for="(d, idx) in filtered" :key="d.id">
              <tr class="border-t border-slate-800/70 hover:bg-[#0f1625]">
                <td class="px-5 py-4 align-top">
                  <input type="checkbox" :value="d.id" x-model="selected">
                </td>
                <td class="px-5 py-4">
                  <div class="flex items-center gap-3">
                    <img :src="d.avatar || ('https://api.dicebear.com/9.x/initials/svg?seed=' + encodeURIComponent(d.name))" alt="avatar" class="h-10 w-10 rounded-full object-cover">
                    <div>
                      <div class="font-medium" x-text="d.name"></div>
                      <div class="text-xs text-slate-400" x-text="'ID: ' + d.id"></div>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-4 text-sm">
                  <div x-text="d.license"></div>
                  <div class="text-xs text-slate-400" x-text="'Exp: ' + d.expiry"></div>
                </td>
                <td class="px-5 py-4 text-sm">
                  <div class="truncate max-w-[260px]" x-text="d.email"></div>
                  <div class="text-xs text-slate-400" x-text="d.phone"></div>
                </td>
                <td class="px-5 py-4">
                  <span class="chip inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs"
                        :class="d.status==='Active' ? 'text-green-400' : 'text-amber-300'"
                        x-text="d.status"></span>
                </td>
                <td class="px-5 py-4 text-right">
                  <div class="inline-flex gap-2">
                    <button class="rounded-md bg-slate-700/60 px-3 py-1 text-xs hover:bg-slate-700" @click="openForm(d, idx)">Edit</button>
                    <button class="rounded-md bg-red-600/80 px-3 py-1 text-xs hover:bg-red-600" @click="remove(idx)">Delete</button>
                  </div>
                </td>
              </tr>
            </template>
            <tr x-show="filtered.length===0">
              <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-400">No drivers match the filters.</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal -->
      <div x-cloak x-show="showForm" class="fixed inset-0 z-30 grid place-items-center bg-black/60 p-4" @keydown.escape.window="closeForm()">
        <div class="w-full max-w-2xl rounded-2xl border border-slate-800 bg-[#0f1625] p-6 shadow-2xl" @click.outside="closeForm()">
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold" x-text="isEditing ? 'Edit Driver' : 'Add Driver'"></h2>
            <button class="rounded-md p-2 hover:bg-[#141c2b]" @click="closeForm()">✕</button>
          </div>

          <form @submit.prevent="isEditing ? update() : add()" class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
              <label class="mb-1 block text-sm text-slate-400">Name</label>
              <input class="input w-full rounded-lg border px-3 py-2 text-sm" x-model.trim="form.name" required>
            </div>
            <div>
              <label class="mb-1 block text-sm text-slate-400">Email</label>
              <input type="email" class="input w-full rounded-lg border px-3 py-2 text-sm" x-model.trim="form.email" required>
            </div>
            <div>
              <label class="mb-1 block text-sm text-slate-400">Phone</label>
              <input class="input w-full rounded-lg border px-3 py-2 text-sm" x-model.trim="form.phone">
            </div>
            <div>
              <label class="mb-1 block text-sm text-slate-400">License</label>
              <select class="input w-full rounded-lg border px-3 py-2 text-sm" x-model="form.license" required>
                <option value="" disabled>Select class</option>
                <option>Class A</option>
                <option>Class B</option>
                <option>Class C</option>
              </select>
            </div>
            <div>
              <label class="mb-1 block text-sm text-slate-400">Expiry</label>
              <input type="date" class="input w-full rounded-lg border px-3 py-2 text-sm" x-model="form.expiry" required>
            </div>
            <div>
              <label class="mb-1 block text-sm text-slate-400">Status</label>
              <select class="input w-full rounded-lg border px-3 py-2 text-sm" x-model="form.status">
                <option>Active</option>
                <option>Inactive</option>
              </select>
            </div>
            <div class="md:col-span-2">
              <label class="mb-1 block text-sm text-slate-400">Avatar URL (optional)</label>
              <input class="input w-full rounded-lg border px-3 py-2 text-sm" placeholder="https://…" x-model.trim="form.avatar">
              <p class="mt-1 text-xs text-slate-500">No upload server here; paste a URL or leave blank.</p>
            </div>
            <div class="md:col-span-2 mt-2 flex justify-end gap-2">
              <button type="button" class="rounded-lg px-4 py-2 text-sm hover:bg-[#141c2b]" @click="closeForm()">Cancel</button>
              <button type="submit" class="btn rounded-lg px-4 py-2 text-sm font-medium" x-text="isEditing ? 'Save changes' : 'Add driver'"></button>
            </div>
          </form>
        </div>
      </div>

    </section>
  </main>
</div>

<script>
function driversPage(){
  return {
    // state
    all: [],
    filtered: [],
    selected: [],
    showForm: false,
    isEditing: false,
    editIndex: -1,
    filters: { status:'', license:'', expBefore:'' },
    form: { id:'', name:'', email:'', phone:'', license:'', expiry:'', status:'Active', avatar:'' },

    init(){
      // seed if empty
      const seed = [
        {id:'DRV-001', name:'John Smith',   email:'john.smith@example.com',   phone:'(555) 123-4567', license:'Class A', expiry:'2025-12-01', status:'Active',   avatar:''},
        {id:'DRV-002', name:'Sarah Johnson',email:'sarah.j@example.com',      phone:'(555) 987-6543', license:'Class B', expiry:'2024-06-15', status:'Active',   avatar:''},
        {id:'DRV-003', name:'Michael Brown',email:'michael.b@example.com',    phone:'(555) 456-7890', license:'Class C', expiry:'2023-03-10', status:'Inactive', avatar:''},
        {id:'DRV-004', name:'Emily Davis',  email:'emily.d@example.com',      phone:'(555) 789-0123', license:'Class A', expiry:'2026-09-20', status:'Active',   avatar:''},
      ];
      const stored = JSON.parse(localStorage.getItem('brufuel.drivers')||'null');
      this.all = Array.isArray(stored) && stored.length ? stored : seed;
      this.applyFilters();
    },

    persist(){ localStorage.setItem('brufuel.drivers', JSON.stringify(this.all)); },

    applyFilters(){
      this.filtered = this.all.filter(d=>{
        const s = this.filters.status ? d.status===this.filters.status : true;
        const l = this.filters.license ? d.license===this.filters.license : true;
        const e = this.filters.expBefore ? (new Date(d.expiry) <= new Date(this.filters.expBefore)) : true;
        return s && l && e;
      });
    },

    openForm(row=null, idx=-1){
      this.showForm = true;
      if(row){
        this.isEditing = true; this.editIndex = idx;
        this.form = JSON.parse(JSON.stringify(row));
      } else {
        this.isEditing = false; this.editIndex = -1;
        this.form = { id:this.nextId(), name:'', email:'', phone:'', license:'', expiry:'', status:'Active', avatar:'' };
      }
    },
    closeForm(){ this.showForm=false; },

    nextId(){
      const nums = this.all.map(d=>parseInt((d.id||'').replace(/[^0-9]/g,'')||0,10));
      const n = (Math.max(0, ...nums) + 1).toString().padStart(3,'0');
      return `DRV-${n}`;
    },

    add(){
      if(!this.form.id) this.form.id = this.nextId();
      this.all.unshift({...this.form});
      this.persist();
      this.applyFilters();
      this.showForm=false;
    },

    update(){
      if(this.editIndex>-1){
        this.all.splice(this.editIndex,1,{...this.form});
        this.persist();
        this.applyFilters();
        this.showForm=false;
      }
    },

    remove(idx){
      if(!confirm('Delete this driver?')) return;
      const globalIndex = this.all.findIndex(d=>d.id===this.filtered[idx].id);
      if(globalIndex>-1){
        this.all.splice(globalIndex,1);
        this.persist();
        this.applyFilters();
        this.selected = this.selected.filter(id=>id!==this.filtered[idx].id);
      }
    },

    toggleAll(e){
      if(e.target.checked){ this.selected = this.filtered.map(d=>d.id); }
      else { this.selected = []; }
    },

    exportCSV(onlySelected){
      const rows = [['ID','Name','Email','Phone','License','Expiry','Status']];
      const list = onlySelected ? this.all.filter(d=>this.selected.includes(d.id)) : this.all;
      list.forEach(d=> rows.push([d.id,d.name,d.email,d.phone,d.license,d.expiry,d.status]));
      const csv = rows.map(r=> r.map(v=>`"${String(v).replaceAll('"','""')}"`).join(',')).join('\n');
      const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
      const a = document.createElement('a');
      a.href = URL.createObjectURL(blob);
      a.download = `drivers-${onlySelected?'selected-':''}${new Date().toISOString().slice(0,10)}.csv`;
      a.click();
      URL.revokeObjectURL(a.href);
    },

    // === Import (CSV) ===
    handleImport(e){
      const file = e.target.files && e.target.files[0];
      if(!file) return;
      const reader = new FileReader();
      reader.onload = () => {
        try { this.importCSV(reader.result); }
        catch(err){ alert('Import failed: ' + err.message); }
        e.target.value = '';
      };
      reader.readAsText(file);
    },

    importCSV(text){
      const rows = this.parseCSV(text);
      if(!rows.length) throw new Error('Empty file');

      const header = rows[0].map(h => h.trim());
      const required = ['ID','Name','Email','Phone','License','Expiry','Status'];
      const idx = Object.fromEntries(required.map(k => [k, header.findIndex(h => h.toLowerCase() === k.toLowerCase())]));
      if (required.some(k => idx[k] === -1)) {
        throw new Error('Expected headers: ' + required.join(', '));
      }

      const incoming = [];
      for (let i = 1; i < rows.length; i++) {
        const r = rows[i];
        if (r.every(v => !String(v).trim())) continue;
        const rec = {
          id:      r[idx.ID]      || '',
          name:    r[idx.Name]    || '',
          email:   r[idx.Email]   || '',
          phone:   r[idx.Phone]   || '',
          license: r[idx.License] || '',
          expiry:  r[idx.Expiry]  || '',
          status:  r[idx.Status]  || 'Active',
          avatar:  ''
        };
        if (!rec.id) rec.id = this.nextId();
        incoming.push(rec);
      }
      if (!incoming.length) throw new Error('No data rows found');

      const replace = confirm('Import: OK = Replace all drivers with file data,  Cancel = Append / upsert');
      if (replace) {
        this.all = incoming;
      } else {
        // upsert by ID
        const byId = new Map(this.all.map(d => [d.id, d]));
        incoming.forEach(n => byId.set(n.id, n));
        this.all = Array.from(byId.values());
      }
      this.persist();
      this.applyFilters();
      alert('Import complete: ' + incoming.length + ' row(s).');
    },

    parseCSV(text){
      const out = [[]];
      let i = 0, field = '', inQuotes = false;
      while (i < text.length) {
        const c = text[i];
        if (inQuotes) {
          if (c === '"' && text[i+1] === '"') { field += '"'; i += 2; continue; }
          if (c === '"') { inQuotes = false; i++; continue; }
          field += c; i++; continue;
        } else {
          if (c === '"') { inQuotes = true; i++; continue; }
          if (c === ',') { out[out.length-1].push(field); field = ''; i++; continue; }
          if (c === '\n') { out[out.length-1].push(field); field = ''; out.push([]); i++; continue; }
          if (c === '\r') { i++; continue; }
          field += c; i++; continue;
        }
      }
      out[out.length-1].push(field);
      if (out.length && out[out.length-1].every(v => v === '')) out.pop();
      return out;
    },
  }
}
</script>
</body>
</html>
