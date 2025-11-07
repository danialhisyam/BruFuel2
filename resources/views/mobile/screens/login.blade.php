<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brufuel Login</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
  <div class="container">
    <div class="login-card">
      <div class="brand">
        <img src="{{ asset('images/v699_176.png') }}" alt="Brufuel Logo" class="logo">
        <h1>Brufuel</h1>
      </div>

      <form>
        <div class="input-group">
          <input type="email" placeholder="Email" required>
        </div>
        <div class="input-group">
          <input type="password" placeholder="Password" required>
        </div>
        <button type="submit" class="login-btn">LOGIN</button>
      </form>
    </div>
  </div>
</body>
</html>
