<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome — BruFuel</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
      background: url('{{ asset('brufuel.png') }}') center center / cover no-repeat;
      color: #fff;
    }

    .overlay {
      position: absolute;
      inset: 0;
      background: rgba(0, 9, 25, 0.6);
      z-index: 0;
    }

    .content {
      position: relative;
      z-index: 1;
      text-align: center;
      animation: fadeIn 2s ease-out forwards;
    }

    .logo {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 0 40px rgba(255, 215, 0, 0.7);
      animation: pulse 2.5s ease-in-out infinite;
    }

    h1 {
      margin-top: 30px;
      font-size: 30px;
      font-weight: 700;
      color: white;
      opacity: 0;
      animation: slideUp 1.5s ease forwards 1.2s;
    }

    p {
      margin-top: 8px;
      font-size: 16px;
      color: #FFD700;
      font-weight: 500;
      opacity: 0;
      animation: slideUp 1.5s ease forwards 2s;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(0.97); filter: drop-shadow(0 0 12px rgba(255,215,0,0.4)); }
      50% { transform: scale(1.03); filter: drop-shadow(0 0 30px rgba(255,215,0,1)); }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .fade-out {
      animation: fadeOut 1s ease forwards;
    }

    @keyframes fadeOut {
      to { opacity: 0; transform: scale(1.05); }
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <div class="content">
    <img src="{{ asset('images/Logook.png') }}" alt="BruFuel Logo" class="logo">
    <h1>Welcome to BruFuel</h1>
    <p>We Deliver At All Cost</p>
  </div>

  <script>
    // fade out smoothly and redirect
    setTimeout(() => document.body.classList.add('fade-out'), 3800);
    setTimeout(() => window.location.href = "{{ route('home') }}", 4500);
  </script>
</body>
</html>
