// public/js/chat.js
(function () {
  const qs = (sel, el = document) => el.querySelector(sel);
  const qsa = (sel, el = document) => Array.from(el.querySelectorAll(sel));

  const ROLE = (window.CHAT_ROLE || 'guest').toLowerCase();
  const OTHER = ROLE === 'admin' ? 'driver' : 'admin';
  const STORE_KEY = 'brufuel_chat_messages_v1';
  const PRESENCE_KEY = 'brufuel_presence_';

  if (typeof BroadcastChannel === 'undefined') {
    console.error('BroadcastChannel not supported. Use same modern browser.');
    return;
  }
  const channel = new BroadcastChannel('brufuel-chat');

  const msgList = qs('#messages');
  const input = qs('#chat-input');
  const sendBtn = qs('#send-btn');
  const clearBtn = qs('#clear-btn');
  const partnerName = qs('#partner-name');
  const partnerStatusEls = qsa('#partner-status, #partner-status-side'); // <- handles duplicate ids safely
  const selfName = qs('#self-name');

  if (!msgList || !input || !sendBtn) {
    console.error('Chat markup missing required elements.');
    return;
  }

  let lastPresence = { admin: 0, driver: 0 };
  let timers = {};

  const now = () => Date.now();
  const fmt = (ts) => {
    const d = new Date(ts);
    const h = d.getHours() % 12 || 12;
    const m = String(d.getMinutes()).padStart(2, '0');
    return `${h}:${m} ${d.getHours() >= 12 ? 'PM' : 'AM'}`;
  };
  const esc = (s) => s.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));
  const load = () => { try { return JSON.parse(localStorage.getItem(STORE_KEY) || '[]'); } catch { return []; } };
  const save = (v) => localStorage.setItem(STORE_KEY, JSON.stringify(v));

  function append(msg) {
    const mine = msg.sender === ROLE;
    const wrap = document.createElement('div');
    wrap.className = 'flex ' + (mine ? 'justify-end' : 'justify-start');
    const bubble = document.createElement('div');
    bubble.className = `max-w-xs md:max-w-md rounded-lg p-3 shadow ${mine ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'}`;
    bubble.innerHTML = `<p class="whitespace-pre-wrap break-words">${esc(msg.text)}</p>
                        <p class="text-xs mt-1 ${mine ? 'text-blue-600' : 'text-gray-500'}">${fmt(msg.ts)}</p>`;
    wrap.appendChild(bubble);
    msgList.appendChild(wrap);
    msgList.scrollTop = msgList.scrollHeight;
  }

  function renderAll() {
    msgList.innerHTML = '';
    load().forEach(append);
  }

  function send(text) {
    text = (text || '').trim();
    if (!text) return;
    const id = (crypto.randomUUID ? crypto.randomUUID() : (Date.now() + '-' + Math.random().toString(16).slice(2)));
    const msg = { id, text, sender: ROLE, ts: now() };
    const arr = load(); arr.push(msg); save(arr);
    append(msg);
    input.value = '';
    channel.postMessage({ type: 'message', msg });
  }

  function setPartnerStatus(text, online) {
    partnerStatusEls.forEach(el => {
      if (!el) return;
      el.textContent = text;
      el.className = 'text-xs ' + (online ? 'text-green-600' : 'text-gray-500');
    });
  }

  function presence(role, ts) {
    lastPresence[role] = ts;
    const delta = now() - lastPresence[OTHER];
    const online = delta < 15000;
    setPartnerStatus(online ? 'Online' : `Last seen ${Math.round(delta/1000)}s ago`, online);
  }

  function ping() {
    const ts = now();
    localStorage.setItem(PRESENCE_KEY + ROLE, String(ts));
    channel.postMessage({ type: 'presence', role: ROLE, ts });
    presence(ROLE, ts);
  }

  // init names
  if (selfName) selfName.textContent = ROLE === 'admin' ? 'Admin' : 'Driver';
  if (partnerName) partnerName.textContent = OTHER === 'admin' ? 'Admin' : 'Driver';

  // read cached presence
  ['admin', 'driver'].forEach(r => {
    const raw = localStorage.getItem(PRESENCE_KEY + r);
    if (raw) lastPresence[r] = parseInt(raw, 10) || 0;
  });

  // events
  sendBtn.addEventListener('click', () => send(input.value));
  input.addEventListener('keydown', e => { if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(input.value); } });
  clearBtn?.addEventListener('click', () => { if (confirm('Clear conversation for both sides?')) { save([]); renderAll(); channel.postMessage({ type: 'clear' }); } });

  channel.onmessage = (ev) => {
    const d = ev.data || {};
    if (d.type === 'message') append(d.msg);
    if (d.type === 'clear') renderAll();
    if (d.type === 'presence') presence(d.role, d.ts);
  };

  // start
  renderAll(); ping();
  timers.ping = setInterval(ping, 5000);
  timers.refresh = setInterval(() => presence(OTHER, lastPresence[OTHER]), 3000);
  window.addEventListener('beforeunload', () => { clearInterval(timers.ping); clearInterval(timers.refresh); });
})();
