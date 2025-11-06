<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  
  @vite('resources/css/app.css')
  @livewireStyles
</head>

<body class="bg-[#0A0F1D] text-white min-h-screen flex justify-center items-center font-poppins">
  {{ $slot }}
  @livewireScripts
</body>
</html>
