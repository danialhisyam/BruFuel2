<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ Auth::user()->name }} - Menu</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { background:#000919;color:white;font-family:'Poppins',sans-serif;text-align:center;margin-top:150px; }
    a { color:#FFE100;text-decoration:none;font-weight:600; }
  </style>
</head>
<body>
  <h1>Menu Page for {{ Auth::user()->name }}</h1>
  <p>Fuel options and special deals will go here soon!</p>
  <p><a href="{{ route('user.home', ['username' => Auth::user()->name]) }}">⬅ Back to Home</a></p>
</body>
</html>
