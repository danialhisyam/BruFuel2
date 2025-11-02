<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BruFuel – Admin Chat</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Dark theme palette -->
  <style>
    :root { color-scheme: dark; }
    body     { background:#0b1220; }
    .sidebar { background:#0f1625; }
    .card    { background:#141c2b; border-color:#1f2937; }
  </style>
</head>
<body class="min-h-screen text-slate-100 antialiased">
  <div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="sidebar w-64 p-4 flex flex-col">
      <h2 class="text-lg font-semibold mb-4">Admin Controls</h2>

      <nav class="space-y-2">
        <a class="flex items-center gap-2 p-2 rounded-lg bg-blue-600/20 text-blue-300">
          <!-- feather message-square -->
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
          </svg>
          <span>Messages</span>
        </a>
      </nav>

      <div class="mt-6">
        <h3 class="font-medium text-gray-300 mb-2">Active Drivers</h3>
        <div class="space-y-2">
          <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/5 cursor-pointer">
            <!-- Real avatar instead of icon -->
            <img src="https://i.pravatar.cc/64?img=15" alt="Driver Mike"
                 class="w-8 h-8 rounded-full object-cover ring-1 ring-slate-700" />
            <div>
              <p class="text-sm font-medium text-slate-200">Driver Mike</p>
              <p class="text-xs text-green-400">Online</p>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Chat Card -->
    <section class="card flex-1 flex flex-col border rounded-lg m-4 h-[calc(100vh-2rem)] min-h-0">
      <!-- Header -->
      <div class="border-b border-slate-700 p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <!-- Driver avatar in header -->
          <img src="https://i.pravatar.cc/80?img=15" alt="Driver"
               class="w-10 h-10 rounded-full object-cover ring-1 ring-slate-700">
          <div>
            <h3 id="partner-name" class="font-bold text-slate-100">Driver Mike</h3>
            <p id="partner-status" class="text-xs text-slate-400">—</p>
          </div>
        </div>
        <button id="clear-btn"
                class="px-3 py-1 text-sm rounded bg-slate-800 hover:bg-slate-700 text-slate-200">
          Clear
        </button>
      </div>

      <!-- Messages -->
      <div id="messages" class="flex-1 min-h-0 p-4 overflow-y-auto space-y-4"></div>

      <!-- Composer -->
      <div class="border-t border-slate-700 p-3">
        <div class="flex items-end gap-2">
          <textarea id="chat-input" rows="1" placeholder="Type a message..."
            class="flex-1 border border-slate-700 bg-slate-900 text-slate-100 rounded-xl px-4 py-2
                   focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none min-h-[44px] max-h-40"></textarea>

          <!-- Telegram-style airplane (solid, visible on dark) -->
          <button id="send-btn"
                  class="p-3 rounded-full bg-blue-600 text-white hover:bg-blue-700 grid place-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                 fill="currentColor" class="w-5 h-5">
              <path d="M2.4 2.7a.75.75 0 0 1 .86-.16l17.5 8.05a.75.75 0 0 1 .01 1.36l-17.5 8.2a.75.75 0 0 1-1.06-.69V14.5l8.9-2.53-8.9-3.22V3.4c0-.28.16-.54.39-.7z"/>
            </svg>
          </button>
        </div>
      </div>
    </section>
  </div>

  <script>
    // single-room mode
    window.CHAT_ROLE = 'admin';

    // (optional) autosize the textarea just like in our earlier suggestion
    document.addEventListener('DOMContentLoaded', () => {
      const ta = document.getElementById('chat-input');
      function autosize() {
        ta.style.height = 'auto';
        ta.style.height = Math.min(ta.scrollHeight, 160) + 'px';
      }
      ta.addEventListener('input', autosize);
      autosize();
    });
  </script>

  <!-- Use the single-room script -->
  <script src="{{ asset('js/chat.js') }}?v={{ filemtime(public_path('js/chat.js')) }}"></script>
</body>
</html>
