<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ config('app.name', 'BruFuel') }}</title>
  @vite('resources/css/app.css')
  @livewireStyles

  <!-- Poppins font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#0A0F1D] font-[Poppins] text-white min-h-screen flex justify-center items-center">
  {{ $slot }}
  @livewireScripts
</body>
</html>
