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
    body     { background:#0b1220; }         /* page bg (dark blue/black) */
    .sidebar { background:#0f1625; }         /* sidebar bg */
    .card    { background:#141c2b; border-color:#1f2937; } /* card/border */
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

  <!-- Nav -->
  <nav class="px-3">
    <ul class="space-y-1">
      <li>
        <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/admin/dashboard">
          <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>
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
        <a class="flex items-center gap-3 rounded-lg px-3 py-2 bg-indigo-500/15 text-white" href="/admin/payments">
          <span class="inline-block h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
          Payments
        </a>
      </li>
    </ul>
  </nav>

  <!-- Admin User card pinned bottom -->
  <div class="mt-auto p-4">
    <div class="flex items-center gap-3 rounded-xl border border-slate-800 bg-[#0b1220] p-3">
      <div class="grid h-9 w-9 place-items-center rounded-full bg-white/10">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z"/>
          <path d="M12 14c-5 0-9 2.5-9 5v1h18v-1c0-2.5-4-5-9-5z"/>
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

      <!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BruFuel • Payment Overview</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme:{ extend:{ colors:{ brand:{ bg:'#0b1220', panel:'#0f1625', card:'#141c2b', border:'#1f2937', accent:'#e5c546' } } } } };
  </script>

  <!-- Chart.js & SheetJS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.20.1/dist/xlsx.full.min.js"></script>

  <style>
    :root { color-scheme: dark; }
    body { background:#0b1220; overflow-anchor:none; }
    .card { background:#141c2b; border:1px solid #1f2937; }
    th { cursor:pointer; user-select:none; position:relative; }
    th:hover { background:#1e293b; }
    th.sorted::after { content:''; position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); border:4px solid transparent; }
    th.sorted.asc::after { border-bottom-color:#e5c546; }
    th.sorted.desc::after { border-top-color:#e5c546; }
  </style>
</head>
<body class="min-h-screen text-slate-100 antialiased">
<div class="max-w-7xl mx-auto px-4 py-6">
  <header class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-bold">Payment Overview</h1>
      <p class="text-slate-400 text-sm">Search, filter, and export your payments.</p>
    </div>
    <div class="flex gap-2">
      <button id="exportExcel" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400">EXPORT TO EXCEL</button>
      <button id="exportCSV" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500">EXPORT TO CSV</button>
    </div>
  </header>

  <!-- KPIs -->
  <section class="grid md:grid-cols-4 gap-4 mb-6">
    <div class="card rounded-2xl p-5"><p class="text-sm text-slate-400">Total Revenue</p><p id="kpiRevenue" class="text-3xl font-extrabold mt-1">–</p></div>
    <div class="card rounded-2xl p-5"><p class="text-sm text-slate-400">Total Transactions</p><p id="kpiTransactions" class="text-3xl font-extrabold mt-1">–</p></div>
    <div class="card rounded-2xl p-5"><p class="text-sm text-slate-400">Pending</p><p id="kpiPending" class="text-3xl font-extrabold mt-1 text-amber-400">–</p></div>
    <div class="card rounded-2xl p-5"><p class="text-sm text-slate-400">Failed</p><p id="kpiFailed" class="text-3xl font-extrabold mt-1 text-rose-400">–</p></div>
  </section>

  <!-- Chart + Filters -->
  <section class="grid lg:grid-cols-3 gap-6 mb-6">
    <div class="card rounded-2xl p-5 lg:col-span-1" style="height:260px">
      <div class="flex items-center justify-between mb-3">
        <h3 class="font-semibold">Revenue (B$)</h3>
        <span class="text-xs text-slate-400">Monthly</span>
      </div>
      <canvas id="revChart" style="height:100%"></canvas>
    </div>

    <div class="card rounded-2xl p-5 lg:col-span-2">
      <h3 class="font-semibold mb-4">Filters</h3>
      <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-3">
        <div>
          <label class="text-sm text-slate-400">Search</label>
          <input id="q" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900/40 px-3 py-2" placeholder="Name, Order ID, Provider…" />
        </div>
        <div>
          <label class="text-sm text-slate-400">Status</label>
          <select id="status" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900/40 px-3 py-2">
            <option value="">All</option><option>Paid</option><option>Pending</option><option>Fail</option>
          </select>
        </div>
        <div>
          <label class="text-sm text-slate-400">Provider</label>
          <select id="provider" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900/40 px-3 py-2">
            <option value="">All</option>
          </select>
        </div>
        <div class="grid grid-cols-2 gap-2">
          <div><label class="text-sm text-slate-400">From</label><input id="fromDate" type="date" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900/40 px-3 py-2"/></div>
          <div><label class="text-sm text-slate-400">To</label><input id="toDate" type="date" class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900/40 px-3 py-2"/></div>
        </div>
      </div>
      <div class="mt-3 flex gap-2">
        <button id="resetFilters" class="px-3 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-sm">Reset</button>
      </div>
        </div>
      </section>

  <!-- Table -->
  <section class="card rounded-2xl">
    <div class="p-5 border-b border-slate-700/50 flex items-center justify-between">
      <h3 class="font-semibold">Transactions</h3>
      <span id="rowCount" class="text-sm text-slate-400">–</span>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
        <thead class="bg-slate-900/40">
          <tr class="text-slate-300">
            <th data-sort="name" class="px-4 py-3 text-left">Name / Order ID</th>
            <th data-sort="date" class="px-4 py-3 text-left">Date / Time</th>
            <th data-sort="amount" class="px-4 py-3 text-right">Amount (B$)</th>
            <th data-sort="provider" class="px-4 py-3 text-left">Provider</th>
            <th data-sort="status" class="px-4 py-3 text-left">Status</th>
              </tr>
            </thead>
        <tbody id="tbody"></tbody>
          </table>
        </div>
      </section>
  </div>

<script>
let payments = [];

async function loadPayments(){
  try {
    const res = await fetch('/api/payments');
    if (!res.ok) throw new Error('API not available');
    payments = await res.json();
  } catch (e) {
    // Fallback mock data if API doesn't exist
    console.warn('Using mock payment data:', e.message);
    payments = generateMockPayments();
  }
  refreshProviderOptions();
  renderTable();
}

function generateMockPayments() {
  const names = ['John Doe', 'Jane Smith', 'Ahmad Rahman', 'Sarah Lee', 'Michael Chen', 'Emily Wong', 'David Tan', 'Lisa Kumar'];
  const providers = ['BIBD', 'Baiduri', 'TAP', 'Cash'];
  const statuses = ['Paid', 'Pending', 'Fail'];
  const data = [];
  
  for (let i = 0; i < 50; i++) {
    const date = new Date();
    date.setDate(date.getDate() - Math.floor(Math.random() * 180));
    data.push({
      id: `ORD-${1000 + i}`,
      name: names[Math.floor(Math.random() * names.length)],
      provider: providers[Math.floor(Math.random() * providers.length)],
      status: statuses[Math.floor(Math.random() * statuses.length)],
      amount: (Math.random() * 200 + 20).toFixed(2),
      date: date.toISOString()
    });
  }
  return data;
}

/* ELEMENTS */
const tbody = document.getElementById('tbody');
const kpiRevenue = document.getElementById('kpiRevenue');
const kpiTransactions = document.getElementById('kpiTransactions');
const kpiPending = document.getElementById('kpiPending');
const kpiFailed = document.getElementById('kpiFailed');
const rowCount = document.getElementById('rowCount');
const q = document.getElementById('q');
const statusSel = document.getElementById('status');
const providerSel = document.getElementById('provider');
const fromDate = document.getElementById('fromDate');
const toDate = document.getElementById('toDate');
const resetBtn = document.getElementById('resetFilters');
const exportExcelBtn = document.getElementById('exportExcel');
const exportCSVBtn = document.getElementById('exportCSV');

let sortState = { key: 'date', dir: 'desc' };

function refreshProviderOptions() {
  const providers = [...new Set(payments.map(p => p.provider))].sort();
  providerSel.innerHTML = '<option value="">All</option>' + providers.map(v => `<option value="${v}">${v}</option>`).join('');
}

function getFiltered() {
  const text = q.value.trim().toLowerCase();
  const st = statusSel.value;
  const pv = providerSel.value;
  const f = fromDate.value ? new Date(fromDate.value) : null;
  const t = toDate.value ? new Date(toDate.value) : null;

  let out = payments.filter(p => {
    if (st && p.status !== st) return false;
    if (pv && p.provider !== pv) return false;
    if (f && new Date(p.date) < new Date(f.setHours(0,0,0,0))) return false;
    if (t && new Date(p.date) > new Date(new Date(t).setHours(23,59,59,999))) return false;
    if (text && !(p.name + p.id + p.provider).toLowerCase().includes(text)) return false;
    return true;
  });

  const { key, dir } = sortState;
  out.sort((a,b)=>{
    let va=a[key], vb=b[key];
    if(key==='date'){ va=new Date(a.date); vb=new Date(b.date); }
    if(key==='amount'){ va=+a.amount; vb=+b.amount; }
    if(va<vb) return dir==='asc'?-1:1;
    if(va>vb) return dir==='asc'?1:-1;
    return 0;
  });
  return out;
}

function renderTable() {
  const rows = getFiltered();
  tbody.innerHTML = rows.map(p => `
    <tr class="border-t border-slate-700/40 hover:bg-slate-900/30">
      <td class="px-4 py-3">
        <div class="font-medium">${p.name}</div>
        <div class="text-xs text-slate-400">ID: ${p.id}</div>
      </td>
      <td class="px-4 py-3">
        <div>${fmtDate(p.date)}</div>
        <div class="text-xs text-slate-400">${fmtTime(p.date)}</div>
      </td>
      <td class="px-4 py-3 text-right font-semibold">B$${(+p.amount).toFixed(2)}</td>
      <td class="px-4 py-3">${p.provider}</td>
      <td class="px-4 py-3">${badge(p.status)}</td>
    </tr>
  `).join('');
  rowCount.textContent = `${rows.length} result${rows.length===1?'':'s'}`;
  refreshKPIs(rows);
  refreshChart(rows);
}

function fmtDate(iso){ return new Date(iso).toLocaleDateString(undefined,{month:'short',day:'2-digit',year:'numeric'}); }
function fmtTime(iso){ return new Date(iso).toLocaleTimeString(undefined,{hour:'2-digit',minute:'2-digit'}); }
function badge(s){ const c=s==='Paid'?'bg-green-500/15 text-green-400':s==='Pending'?'bg-amber-500/15 text-amber-400':'bg-rose-500/15 text-rose-400'; return `<span class="inline-flex px-2 py-1 rounded-lg text-xs ${c}">${s}</span>`; }

function refreshKPIs(rows){
  const total=rows.filter(r=>r.status==='Paid').reduce((s,r)=>s+Number(r.amount),0);
  kpiRevenue.textContent=`B$${total.toLocaleString(undefined,{minimumFractionDigits:2})}`;
  kpiTransactions.textContent=rows.length;
  kpiPending.textContent=rows.filter(r=>r.status==='Pending').length;
  kpiFailed.textContent=rows.filter(r=>r.status==='Fail').length;
}

/* Chart */
let chart;
function refreshChart(rows){
  const labels=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  const sums=Array(12).fill(0);
  rows.filter(r=>r.status==='Paid').forEach(r=>{ sums[new Date(r.date).getMonth()] += Number(r.amount); });
  if(!chart){
    chart=new Chart(document.getElementById('revChart'),{
      type:'bar',
      data:{ labels, datasets:[{ label:'Paid Revenue', data:sums, backgroundColor:'#e5c546' }] },
      options:{ animation:false, maintainAspectRatio:false, plugins:{ legend:{display:false} } }
    });
  } else { chart.data.datasets[0].data=sums; chart.update(); }
}

/* Exports */
function rowsForExport(){ return getFiltered().map(p=>({OrderID:p.id, Name:p.name, Provider:p.provider, Status:p.status, Amount_BND:p.amount, Date:fmtDate(p.date), Time:fmtTime(p.date)})); }
function toCSV(rows){ if(!rows.length)return''; const h=Object.keys(rows[0]); const esc=v=>`"${String(v??'').replaceAll('"','""')}"`; return [h.join(','),...rows.map(r=>h.map(k=>esc(r[k])).join(','))].join('\n'); }
function downloadBlob(blob,filename){ const url=URL.createObjectURL(blob); const a=document.createElement('a'); a.href=url;a.download=filename;a.click();URL.revokeObjectURL(url); }

exportCSVBtn.addEventListener('click',()=>{ const r=rowsForExport(); if(!r.length)return alert('No data'); downloadBlob(new Blob([toCSV(r)],{type:'text/csv;charset=utf-8;'}),`payments-${new Date().toISOString().slice(0,10)}.csv`); });
exportExcelBtn.addEventListener('click',()=>{ const r=rowsForExport(); if(!r.length)return alert('No data'); const ws=XLSX.utils.json_to_sheet(r); const wb=XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb,ws,'Payments'); const ab=XLSX.write(wb,{bookType:'xlsx',type:'array'}); downloadBlob(new Blob([ab],{type:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'}),`payments-${new Date().toISOString().slice(0,10)}.xlsx`); });

/* Sorting */
document.querySelectorAll('th[data-sort]').forEach(th => {
  th.addEventListener('click', () => {
    const key = th.dataset.sort;
    if (sortState.key === key) {
      sortState.dir = sortState.dir === 'asc' ? 'desc' : 'asc';
    } else {
      sortState.key = key;
      sortState.dir = 'asc';
    }
    // Update visual indicators
    document.querySelectorAll('th[data-sort]').forEach(h => h.classList.remove('sorted', 'asc', 'desc'));
    th.classList.add('sorted', sortState.dir);
    renderTable();
  });
});

// Set initial sort indicator
document.querySelector(`th[data-sort="${sortState.key}"]`)?.classList.add('sorted', sortState.dir);

/* Listeners */
[q,statusSel,providerSel,fromDate,toDate].forEach(el=>el.addEventListener('input',renderTable));
resetBtn.addEventListener('click',()=>{ q.value=''; statusSel.value=''; providerSel.value=''; fromDate.value=''; toDate.value=''; renderTable(); });

/* Init */
loadPayments();
</script>
</body>
</html>
