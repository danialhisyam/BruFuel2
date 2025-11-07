// public/js/chat-multi.js
(function () {
  const qs  = (s, el=document) => el.querySelector(s);
  const qsa = (s, el=document) => Array.from(el.querySelectorAll(s));
  const ROLE   = (window.CHAT_ROLE || 'guest').toLowerCase();
  const DRIVERS = window.DRIVERS || [{ id: 'mike', name: 'Driver Mike' }];

  // Current chatId (driver id). Driver reads from window.CHAT_ID or ?driver=...
  let currentChatId = ROLE === 'driver'
    ? (window.CHAT_ID || new URLSearchParams(location.search).get('driver') || DRIVERS[0].id)
    : DRIVERS[0].id;

  // State
  let channel = null;
  let lastPresence = {}; // { [chatId_role]: timestamp }
  let timers = { ping:null, refresh:null };

  // Elements
  const msgList = qs('#messages');
  const input = qs('#chat-input');
  const sendBtn = qs('#send-btn');
  const clearBtn = qs('#clear-btn');
  const selfName = qs('#self-name');
  const partnerName = qs('#partner-name');
  const partnerStatusHeader = qs('#partner-status');
  const sidebarPresences = qsa('.driver-presence');
  const driverButtons = qsa('.driver-item');

  // Utils
  const now = () => Date.now();
  const fmt = ts => {
    const d=new Date(ts), h=d.getHours()%12||12, m=String(d.getMinutes()).padStart(2,'0');
    return `${h}:${m} ${d.getHours()>=12?'PM':'AM'}`;
  };
  const esc = s => s.replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));

  const storeKey = (chatId) => `brufuel_chat_${chatId}_v1`;
  const presenceKey = (chatId, role) => `brufuel_presence_${chatId}_${role}`;
  const chanName = (chatId) => `brufuel-chat-${chatId}`;

  const load = (chatId) => { try { return JSON.parse(localStorage.getItem(storeKey(chatId)) || '[]'); } catch { return []; } };
  const save = (chatId, arr) => localStorage.setItem(storeKey(chatId), JSON.stringify(arr));

  function append(msg){
    const mine = msg.sender === ROLE;
    const wrap = document.createElement('div');
    wrap.className = 'flex ' + (mine ? 'justify-end' : 'justify-start');
    const bubble = document.createElement('div');
    bubble.className = `max-w-xs md:max-w-md rounded-lg p-3 shadow ${mine?'bg-blue-100 text-blue-800':'bg-gray-100 text-gray-800'}`;
    bubble.innerHTML = `<p class="whitespace-pre-wrap break-words">${esc(msg.text)}</p>
                        <p class="text-xs mt-1 ${mine?'text-blue-600':'text-gray-500'}">${fmt(msg.ts)}</p>`;
    msgList.appendChild(wrap).appendChild(bubble);
    msgList.scrollTop = msgList.scrollHeight;
  }
  function renderAll(chatId){
    msgList.innerHTML = '';
    load(chatId).forEach(append);
  }
  function driverName(chatId){
    return (DRIVERS.find(d=>d.id===chatId)?.name) || 'Driver';
  }
  function setHeaderFor(chatId){
    if (partnerName) partnerName.textContent = driverName(chatId);
  }

  // Presence
  function setHeaderPresence(text, online){
    if (!partnerStatusHeader) return;
    partnerStatusHeader.textContent = text;
    partnerStatusHeader.className = 'text-xs ' + (online ? 'text-green-600' : 'text-gray-500');
  }
  function setSidebarPresence(chatId, text, online){
    sidebarPresences.forEach(span=>{
      if (span.dataset.driverId !== chatId) return;
      span.textContent = text;
      span.className = 'driver-presence ' + (online ? 'text-green-600' : 'text-gray-500');
    });
  }
  function presence(chatId, role, ts){
    const key = `${chatId}_${role}`;
    lastPresence[key] = ts;

    const otherKey = `${chatId}_${role==='admin'?'driver':'admin'}`;
    const delta = now() - (lastPresence[otherKey] || 0);
    const online = delta < 15000;

    if (chatId === currentChatId) setHeaderPresence(online ? 'Online' : `Last seen ${Math.round(delta/1000)}s ago`, online);
    setSidebarPresence(chatId, online ? 'Online' : 'Offline', online);
  }
  function ping(chatId){
    const ts = now();
    localStorage.setItem(presenceKey(chatId, ROLE), String(ts));
    channel?.postMessage({ type:'presence', chatId, role: ROLE, ts });
    presence(chatId, ROLE, ts);
  }
  function readCachedPresence(chatId){
    ['admin','driver'].forEach(r=>{
      const raw = localStorage.getItem(presenceKey(chatId, r));
      if (raw) lastPresence[`${chatId}_${r}`] = parseInt(raw,10)||0;
    });
  }

  // Messaging
  function send(text){
    text = (text||'').trim();
    if (!text) return;
    const id = (crypto.randomUUID ? crypto.randomUUID() : (Date.now()+'-'+Math.random().toString(16).slice(2)));
    const msg = { id, text, sender: ROLE, ts: now(), chatId: currentChatId };
    const arr = load(currentChatId); arr.push(msg); save(currentChatId, arr);
    append(msg);
    input.value=''; autosize(input);
    channel?.postMessage({ type:'message', chatId: currentChatId, msg });
  }

  // Channel lifecycle
  function openChannel(chatId){
    if (channel) { try { channel.close(); } catch {} }
    channel = new BroadcastChannel(chanName(chatId));
    channel.onmessage = (ev)=>{
      const d = ev.data || {};
      if (d.chatId !== currentChatId && d.type !== 'presence') return; // ignore other rooms for message/clear
      if (d.type === 'message') append(d.msg);
      if (d.type === 'clear') renderAll(currentChatId);
      if (d.type === 'presence') presence(d.chatId, d.role, d.ts);
    };
  }

  function switchChat(chatId){
    currentChatId = chatId;
    setHeaderFor(chatId);
    renderAll(chatId);
    readCachedPresence(chatId);
    openChannel(chatId);
    ping(chatId);
    highlightActive(chatId);
  }

  function highlightActive(chatId){
    driverButtons.forEach(btn=>{
      const active = btn.dataset.driverId === chatId;
      btn.classList.toggle('bg-blue-50', active);
      btn.classList.toggle('ring-1', active);
      btn.classList.toggle('ring-blue-200', active);
    });
  }

  // UI wiring
  if (selfName) selfName.textContent = ROLE === 'admin' ? 'Admin' : 'Driver';
  if (partnerName) setHeaderFor(currentChatId);

  sendBtn?.addEventListener('click', ()=>send(input.value));
  input?.addEventListener('keydown', e=>{
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(input.value); }
  });
  clearBtn?.addEventListener('click', ()=>{
    if (confirm('Clear this conversation?')) {
      save(currentChatId, []); renderAll(currentChatId);
      channel?.postMessage({ type:'clear', chatId: currentChatId });
    }
  });
  driverButtons.forEach(btn=>{
    btn.addEventListener('click', ()=>switchChat(btn.dataset.driverId));
  });

  // autosize textarea
  function autosize(el){
    if(!el) return; el.style.height='auto'; el.style.height=Math.min(el.scrollHeight, 160)+'px';
  }
  input && (input.addEventListener('input', ()=>autosize(input)), autosize(input));

  // Boot
  driverButtons.length && highlightActive(currentChatId);
  readCachedPresence(currentChatId);
  renderAll(currentChatId);
  openChannel(currentChatId);
  ping(currentChatId);

  timers.ping = setInterval(()=>ping(currentChatId), 5000);
  timers.refresh = setInterval(()=>{
    // refresh header for current room using cached timestamps
    const otherKey = `${currentChatId}_${ROLE==='admin'?'driver':'admin'}`;
    const delta = now() - (lastPresence[otherKey] || 0);
    const online = delta < 15000;
    setHeaderPresence(online ? 'Online' : `Last seen ${Math.round(delta/1000)}s ago`, online);
  }, 3000);

  window.addEventListener('beforeunload', ()=>{
    clearInterval(timers.ping); clearInterval(timers.refresh);
    try{ channel?.close(); }catch{}
  });
})();
