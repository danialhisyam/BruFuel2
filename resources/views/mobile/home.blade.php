<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Mobile Home</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>

  <body class="min-h-screen bg-gray-50 text-gray-900 font-sans antialiased">
    
    {{-- Navbar partial --}}
    @include('mobile.partials.navbar')

    <!-- Main content -->
    <main class="p-4 space-y-6">
      <section>
        <h2 class="text-xl font-semibold">Welcome to Mobile Home</h2>
        <p class="text-gray-600 text-sm">
          Your Figma design starts here — fully responsive and Tailwind-ready.
        </p>
      </section>

      <section class="grid grid-cols-2 gap-4">
        <button class="p-4 text-center bg-white rounded-xl shadow hover:bg-gray-100 transition">
          <span class="block text-base font-medium">Button 1</span>
        </button>
        <button class="p-4 text-center bg-white rounded-xl shadow hover:bg-gray-100 transition">
          <span class="block text-base font-medium">Button 2</span>
        </button>
      </section>
    </main>

    <!-- Bottom navigation -->
    <nav class="fixed bottom-0 left-0 right-0 flex justify-around bg-white border-t border-gray-200 shadow-sm">
      <a href="#" class="flex flex-col items-center py-2 text-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
        </svg>
        <span class="text-xs">Home</span>
      </a>
      <a href="#" class="flex flex-col items-center py-2 text-gray-500 hover:text-blue-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span class="text-xs">Add</span>
      </a>
      <a href="#" class="flex flex-col items-center py-2 text-gray-500 hover:text-blue-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.364 4.56 9 9 0 015.121 17.804z" />
        </svg>
        <span class="text-xs">Profile</span>
      </a>
    </nav>

  </body>
</html>
