<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ config('app.name', 'Laravel Checkout') }}</title>

  {{-- Tailwind CSS --}}
  @vite('resources/css/app.css')

  {{-- Livewire Styles --}}
  @livewireStyles

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #0A0F1D !important;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      color: #fff;
    }

    /* Make the app frame look like a phone */
    .app-frame {
      width: 430px;
      height: 932px;
      background-color: #0A0F1D !important;
      border-radius: 2rem;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
      overflow-y: auto;
      position: relative;
    }

    header, footer {
      background-color: transparent;
    }

    main {
      padding: 1.5rem;
    }

    /* Smooth scroll inside frame */
    .app-frame::-webkit-scrollbar {
      display: none;
    }
  </style>
</head>

<body>
  <div class="app-frame">
    {{-- Optional Navbar --}}
    <header class="text-center text-blue-400 font-semibold text-lg py-4 border-b border-[#1a2235]">
      Payment Checkout
    </header>

    {{-- Main content slot --}}
    <main>
      {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="text-center text-xs text-gray-500 border-t border-[#1a2235] py-3">
      © {{ date('Y') }} Laravel Checkout UI
    </footer>
  </div>

  @livewireScripts
</body>
</html>
