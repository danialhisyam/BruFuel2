<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BruFuel – Driver Chat</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Dark theme palette -->
  <style>
    :root { color-scheme: dark; }
    body  { background:#0b1220; }
    .card { background:#141c2b; border-color:#1f2937; }
  </style>
</head>
<body class="min-h-screen text-slate-100 antialiased">
  <div class="min-h-screen">

    <!-- Header -->
    <header class="card border-b">
      <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="text-xl font-bold">BruFuel</span>
          <span class="text-xs font-semibold text-white bg-blue-600 px-2 py-0.5 rounded">DRIVER</span>
        </div>
        <div class="flex items-center gap-3">
          <span class="text-sm text-slate-300">Signed in as <b id="self-name">Driver Mike</b></span>
          <!-- Driver avatar -->
          <img class="h-8 w-8 rounded-full object-cover ring-1 ring-slate-700"
               src="https://i.pravatar.cc/40?img=15" alt="Driver avatar">
        </div>
      </div>
    </header>

    <!-- Main -->
    <main class="max-w-3xl lg:max-w-5xl mx-auto px-4 py-6">
      <section class="card rounded-lg border flex flex-col h-[calc(100vh-160px)] min-h-0">
        <!-- Chat header -->
        <div class="border-b border-slate-700 p-4 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <!-- Admin avatar -->
            <img src="https://i.pravatar.cc/80?img=5" alt="Admin"
                 class="w-10 h-10 rounded-full object-cover ring-1 ring-slate-700">
            <div>
              <h3 id="partner-name" class="font-bold text-slate-100">Admin</h3>
              <p id="partner-status" class="text-xs text-slate-400">—</p>
            </div>
          </div>
          <button class="px-3 py-1 text-sm rounded bg-slate-800 hover:bg-slate-700 text-slate-200">
            More
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

            <!-- Telegram-style airplane -->
            <button id="send-btn"
                    class="p-3 rounded-full bg-blue-600 text-white hover:bg-blue-700 grid place-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path d="M2.4 2.7a.75.75 0 0 1 .86-.16l17.5 8.05a.75.75 0 0 1 .01 1.36l-17.5 8.2a.75.75 0 0 1-1.06-.69V14.5l8.9-2.53-8.9-3.22V3.4c0-.28.16-.54.39-.7z"/>
              </svg>
            </button>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script>
    // single-room mode
    window.CHAT_ROLE = 'driver';

    // optional: autosize textarea
    document.addEventListener('DOMContentLoaded', () => {
      const ta = document.getElementById('chat-input');
      function autosize(){ ta.style.height='auto'; ta.style.height=Math.min(ta.scrollHeight,160)+'px'; }
      ta.addEventListener('input', autosize);
      autosize();
    });
  </script>

  <!-- Use the single-room script -->
  <script src="{{ asset('js/chat.js') }}?v={{ filemtime(public_path('js/chat.js')) }}"></script>
</body>
</html>
