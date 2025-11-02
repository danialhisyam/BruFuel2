<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>BruFuel • Admin</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Polyline arrows -->
  <script src="https://unpkg.com/leaflet-polylinedecorator@1.7.0/dist/leaflet.polylineDecorator.min.js"></script>

  <style>
    :root { color-scheme: dark; }
    body { background:#0b1220; }
    .sidebar { background:#0f1625; }
    .card { background:#141c2b; border-color:#1f2937; }
    .leaflet-container { background:#0b1220; }
  </style>
</head>

<body class="min-h-screen text-slate-100 antialiased">
  <div class="flex min-h-screen">
    
  <!-- SIDEBAR -->
    <aside class="sidebar w-64 shrink-0 border-r border-slate-800 flex flex-col">
      <div class="flex items-center gap-3 px-5 py-5">
        <div class="grid h-12 w-12 place-items-center rounded-xl bg-white/10">
          <img src="/AdminPics/whiteshell.png" class="h-11 w-12 object-cover" alt="Shell Icon">
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
            <a class="flex items-center gap-3 rounded-lg px-3 py-2 bg-indigo-500/15 text-white"  href="/admin/orders">
              <span class="inline-block h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
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
              payments
            </a>
          </li>
        </ul>
        <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5" href="/testing/testing">
              <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>
              Test
            </a>
          </li>
        </ul>

      </nav>

      <div class="mt-auto p-4">
        <div class="flex items-center gap-3 rounded-xl border border-slate-800 bg-[#0b1220] p-3">
          <div class="grid h-9 w-9 place-items-center rounded-full bg-white/10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z"/><path d="M12 14c-5 0-9 2.5-9 5v1h18v-1c0-2.5-4-5-9-5z"/></svg>
          </div>
          <div class="text-sm">
            <p class="font-medium">Admin User</p>
            <p class="text-slate-400">Administration</p>
          </div>
        </div>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1">
      <header class="border-b border-slate-800">
        <div class="w-full px-5 py-4 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <span class="text-xl font-bold">BruFuel</span>
            <span class="text-xs font-semibold text-slate-900 bg-amber-400/90 px-2 py-0.5 rounded">ADMIN</span>
          </div>
        </div>
      </header>

      <div class="p-6">
        <header class="flex items-center justify-between mb-5">
          <div class="flex items-center gap-3">
            <h1 class="text-xl font-semibold">Driver Monitoring</h1>
            <span class="text-sm px-3 py-1 rounded bg-amber-400/20 text-amber-200 border border-amber-400/30 font-medium">Live</span>
          </div>
        </header>

        <section class="grid grid-cols-1 lg:grid-cols-12 gap-5">
          <div class="lg:col-span-12 card rounded-2xl border shadow-soft">
            <div class="flex items-center justify-between p-4 border-b border-slate-700/60">
              <div class="font-medium">Live Map</div>
              <div class="text-xs text-slate-400">Bandar Seri Begawan</div>
            </div>
            <div id="map" class="h-[560px] rounded-b-2xl"></div>
          </div>
        </section>

        <section class="mt-6 card rounded-2xl border shadow-soft overflow-hidden">
          <div class="p-4 border-b border-slate-700/60 flex items-center justify-between">
            <div class="font-medium">Drivers</div>
            <div class="text-xs text-slate-400" id="driverCount"></div>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="bg-slate-900/50 text-slate-300">
                <tr>
                  <th class="text-left px-4 py-3">Driver</th>
                  <th class="text-left px-4 py-3">Vehicle</th>
                  <th class="text-left px-4 py-3">Status</th>
                  <th class="text-left px-4 py-3">Last Ping</th>
                  <th class="text-left px-4 py-3">Current Job</th>
                  <th class="text-left px-4 py-3">ETA</th>
                  <th class="text-left px-4 py-3">Actions</th>
                </tr>
              </thead>
              <tbody id="driverTableBody" class="divide-y divide-slate-800/70"></tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  </div>

  <!-- FLOATING PANEL (draggable) -->
<div id="drawer" class="fixed top-16 left-16 hidden z-[1000]">
  <div id="drawerCard" class="card rounded-2xl border shadow-soft w-[420px] bg-[#141c2b]">
    <div id="drawerHeader"
         class="p-4 border-b border-slate-700/60 flex items-center justify-between cursor-move select-none">
      <div class="font-medium">Driver Detail</div>
      <button id="drawerClose" class="text-slate-400 hover:text-slate-200">✕</button>
    </div>
    <div id="drawerBody" class="p-4 text-sm"></div>
  </div>
</div>



  <script>
// ---------------- Draggable Drawer ----------------
(function(){
  const drawer = document.getElementById('drawer');
  const header = document.getElementById('drawerHeader');
  let dragging = false, startX = 0, startY = 0, startLeft = 0, startTop = 0;

  // Ensure the drawer has explicit pixel positions (not Tailwind classes) once shown
  function ensurePixelPosition(){
    const style = getComputedStyle(drawer);
    if (style.left.endsWith('%') || style.top.endsWith('%')) {
      drawer.style.left = drawer.offsetLeft + 'px';
      drawer.style.top  = drawer.offsetTop  + 'px';
    }
  }

  header.addEventListener('mousedown', (e) => {
    dragging = true;
    ensurePixelPosition();
    startX = e.clientX;
    startY = e.clientY;
    // parseInt strips 'px'
    startLeft = parseInt(getComputedStyle(drawer).left, 10) || 0;
    startTop  = parseInt(getComputedStyle(drawer).top, 10)  || 0;

    // Improve drag feel
    document.body.classList.add('select-none');
  });

  document.addEventListener('mousemove', (e) => {
    if (!dragging) return;
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;

    // Keep inside viewport
    const vw = window.innerWidth;
    const vh = window.innerHeight;
    const rect = drawer.getBoundingClientRect();
    let nextLeft = startLeft + dx;
    let nextTop  = startTop  + dy;

    const margin = 8;
    nextLeft = Math.min(Math.max(nextLeft, margin), vw - rect.width - margin);
    nextTop  = Math.min(Math.max(nextTop,  margin), vh - rect.height - margin);

    drawer.style.left = nextLeft + 'px';
    drawer.style.top  = nextTop  + 'px';
  });

  document.addEventListener('mouseup', () => {
    if (!dragging) return;
    dragging = false;
    document.body.classList.remove('select-none');
  });

  // Touch support
  header.addEventListener('touchstart', (e) => {
    const t = e.touches[0];
    dragging = true;
    ensurePixelPosition();
    startX = t.clientX; startY = t.clientY;
    startLeft = parseInt(getComputedStyle(drawer).left, 10) || 0;
    startTop  = parseInt(getComputedStyle(drawer).top, 10)  || 0;
  }, {passive:true});

  document.addEventListener('touchmove', (e) => {
    if (!dragging) return;
    const t = e.touches[0];
    const dx = t.clientX - startX;
    const dy = t.clientY - startY;

    const vw = window.innerWidth;
    const vh = window.innerHeight;
    const rect = drawer.getBoundingClientRect();
    let nextLeft = startLeft + dx;
    let nextTop  = startTop  + dy;

    const margin = 8;
    nextLeft = Math.min(Math.max(nextLeft, margin), vw - rect.width - margin);
    nextTop  = Math.min(Math.max(nextTop,  margin), vh - rect.height - margin);

    drawer.style.left = `${nextLeft}px`;
    drawer.style.top  = `${nextTop}px`;
  }, {passive:true});

  document.addEventListener('touchend', () => { dragging = false; });

  // Bring to front when opened
  window.bringDrawerToFront = () => {
    const base = 1000;
    const next = (window.__zCounter = (window.__zCounter || base) + 1);
    drawer.style.zIndex = String(next);
  };
})();

    const drivers = [
      { id:'DEF-9876', name:'Mary', phone:'+6737201634', vehicle:'Honda City', status:'ondelivery', lastPingMin:2, coords:[4.8906,114.9275], job:{ code:'ORD-1203', etaMin:6, dropoff:[4.9295,114.9179] }},
      { id:'ABC-1234', name:'John', phone:'+6738822000', vehicle:'Toyota Vios', status:'ondelivery', lastPingMin:1, coords:[4.9036,114.9399], job:{ code:'ORD-1204', etaMin:9, dropoff:[4.9454,114.9578] }},
      { id:'XYZ-5522', name:'Aisyah', phone:'+673881122', vehicle:'Perodua Bezza', status:'ondelivery', lastPingMin:5, coords:[4.9059,114.9332], job:{ code:'ORD-1205', etaMin:12, dropoff:[4.8931,114.9032] }},
      { id:'JKL-7744', name:'Hafiz', phone:'+673881199', vehicle:'Proton Saga', status:'offline', lastPingMin:40, coords:[4.8679,114.8297], job:null }
    ];

    const STATUS = {
      ondelivery:{ label:'On Delivery', chip:'text-blue-300 bg-blue-500/10 border-blue-500/20' },
      offline:{ label:'Offline', chip:'text-slate-300 bg-slate-600/10 border-slate-500/20' }
    };

    const ROUTE_COLOR = { 'DEF-9876':'#3b82f6', 'ABC-1234':'#06b6d4', 'XYZ-5522':'#8b5cf6' };
    const OSRM_PROVIDERS = [
      'https://router.project-osrm.org',
      'https://routing.openstreetmap.de/routed-car',
      'https://osrm.demo.project-osrm.org'
    ];

    let map; let markers = {}; let routeLayers = {};

    function callDriver(phone){ const formatted = phone.replace(/\D/g,''); window.location.href = `tel:${formatted}`; }
    function msgDriver(name, phone){ window.location.href = "/testing/admin"; }

    function fitToDrivers(list = drivers){ if (!list.length) return; const b = L.latLngBounds(list.map(d => d.coords)); map.fitBounds(b.pad(0.2)); }

    async function fetchRouteGeoJSON(startLatLng, endLatLng){
      const [sLat, sLng] = startLatLng, [eLat, eLng] = endLatLng;
      const qs = 'overview=full&geometries=geojson';
      for (const base of OSRM_PROVIDERS){
        try{
          const res = await fetch(`${base}/route/v1/driving/${sLng},${sLat};${eLng},${eLat}?${qs}`);
          if(!res.ok) continue;
          const json = await res.json();
          if(json.code === 'Ok' && json.routes[0]) return json.routes[0].geometry.coordinates.map(([lng,lat]) => [lat,lng]);
        }catch{}
      }
      return null;
    }

    async function buildRoute(d){
      if(!d || !d.job || !d.job.dropoff) return;
      const color = ROUTE_COLOR[d.id] || '#3b82f6';
      const group = L.layerGroup().addTo(map);
      routeLayers[d.id] = { group };

      const dest = L.marker(d.job.dropoff,{icon:L.divIcon({html:`<div style="background:${color};width:16px;height:16px;border-radius:9999px;box-shadow:0 0 0 4px rgba(0,0,0,.35)"></div>`})}).addTo(group);
      routeLayers[d.id].destMarker = dest;

      const coords = await fetchRouteGeoJSON(d.coords, d.job.dropoff);
      if(coords){
        const poly = L.polyline(coords,{color,weight:7,opacity:0.9,className:'cursor-pointer'}).addTo(group);
        const deco = L.polylineDecorator(poly,{patterns:[{offset:25,repeat:60,symbol:L.Symbol.arrowHead({pixelSize:10,pathOptions:{color,opacity:0.95}})}]}).addTo(group);
        routeLayers[d.id].polyline = poly; routeLayers[d.id].deco = deco;
        poly.on('click',()=>{openDrawer(d); map.fitBounds(poly.getBounds(),{padding:[24,24]});});
      }
    }

    function toggleRoute(d){ if(routeLayers[d.id]){ clearRoute(d.id); renderTable(drivers); } else { buildRoute(d); renderTable(drivers); } }
    function clearRoute(id){ const rl=routeLayers[id]; if(!rl)return; Object.values(rl).forEach(l=>l.remove&&l.remove()); delete routeLayers[id]; }

    function renderMarkers(list){ Object.values(markers).forEach(m=>map.removeLayer(m)); markers={}; list.forEach(d=>{ const m=L.marker(d.coords).addTo(map).bindTooltip(`${d.name} • ${STATUS[d.status].label}`); m.on('click',()=>openDrawer(d)); markers[d.id]=m; }); }
    function renderTable(list){
      document.getElementById('driverCount').textContent=`${list.length} drivers`;
      document.getElementById('driverTableBody').innerHTML=list.map(d=>{
        const eta=d.job?.etaMin?d.job.etaMin+" min":"-";
        const routeBtn=d.status==='ondelivery'?`<button onclick="toggleRoute(drivers.find(x=>x.id==='${d.id}'))" class="ml-2 px-2.5 py-1.5 text-xs rounded-lg bg-amber-500/20 text-amber-300 border border-amber-500/30">${routeLayers[d.id]?'Hide Route':'Show Route'}</button>`:'';
        return `<tr class="hover:bg-slate-900/30"><td class="px-4 py-3">${d.name}</td><td class="px-4 py-3">${d.vehicle}</td><td class="px-4 py-3"><span class="text-[10px] px-2 py-0.5 rounded border ${STATUS[d.status].chip}">${STATUS[d.status].label}</span></td><td class="px-4 py-3">${d.lastPingMin} min ago</td><td class="px-4 py-3">${d.job?d.job.code:'-'}</td><td class="px-4 py-3">${eta}</td><td class="px-4 py-3"><button onclick="callDriver('${d.phone}')" class="px-2.5 py-1.5 text-xs rounded-lg bg-slate-800 border border-slate-700">Call</button><button onclick="msgDriver('${d.name}','${d.phone}')" class="ml-2 px-2.5 py-1.5 text-xs rounded-lg bg-blue-600">Message</button>${routeBtn}</td></tr>`;
      }).join('');
    }

    function openDrawer(d){
      const body=document.getElementById('drawerBody');
      const routeBtn=d.status==='ondelivery'?`<button onclick="toggleRoute(drivers.find(x=>x.id==='${d.id}'))" class="px-3 py-2 text-sm rounded-lg bg-amber-500/20 text-amber-300 border">${routeLayers[d.id]?'Hide Route':'Show Route'}</button>`:'';
      body.innerHTML=`<div class="font-medium text-base">${d.name}</div><div class="text-xs text-slate-400">${d.vehicle} • ID ${d.id}</div><div class="mt-3">Status: ${STATUS[d.status].label}</div><div class="mt-2">Last Ping: ${d.lastPingMin} min ago</div><div class="mt-2">Job: ${d.job?d.job.code:'-'}</div><div class="mt-4 flex gap-2"><button onclick="callDriver('${d.phone}')" class="px-3 py-2 text-sm rounded-lg bg-slate-800 border">Call Driver</button><button onclick="msgDriver('${d.name}','${d.phone}')" class="px-3 py-2 text-sm rounded-lg bg-blue-600">Message Driver</button>${routeBtn}</div>`;
      document.getElementById('drawer').classList.remove('hidden');
    }

    document.getElementById('drawerClose').addEventListener('click',()=>{document.getElementById('drawer').classList.add('hidden');});

    function initMap(){ map=L.map('map').setView([4.905,114.940],12); L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map); renderMarkers(drivers); renderTable(drivers); fitToDrivers(); }
    window.addEventListener('load',initMap);

    setInterval(()=>{drivers.forEach(d=>{if(d.status!=='offline')d.lastPingMin++;});renderTable(drivers);},6000);
  </script>
</body>
</html>
