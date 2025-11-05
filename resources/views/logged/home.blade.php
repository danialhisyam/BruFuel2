<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ Auth::user()->name }} - BruFuel Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: #000919;
      color: white;
      font-family: 'Poppins', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
    }
    .card {
      background: rgba(255,255,255,0.05);
      padding: 40px 60px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    a, button {
      margin-top: 15px;
      background: #760000;
      color: white;
      border: none;
      padding: 10px 25px;
      border-radius: 33px;
      cursor: pointer;
      text-decoration: none;
      font-weight: 600;
      transition: transform 0.2s ease;
    }
    a:hover, button:hover {
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Welcome back, {{ Auth::user()->name }} 👋</h1>
    <p>Your email: {{ Auth::user()->email }}</p>

    <a href="{{ route('user.menu', ['username' => Auth::user()->name]) }}">Go to Menu</a>
    <a href="{{ route('user.history', ['username' => Auth::user()->name]) }}">View History</a>

    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

    <a href="#" 
    onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" 
    style="color:#FFE100; font-size:13px; font-family:Poppins; text-decoration:underline;">
    Logout
    </a>

    <script>
window.addEventListener("pageshow", function (event) {
  if (event.persisted) {
    window.location.reload(); // forces a fresh reload
  }
});
</script>


    </form>
  </div>
</body>
</html>
