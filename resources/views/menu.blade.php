<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BruFuel Dashboard</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;650;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    * { user-select: none; -webkit-user-drag: none; user-drag: none; }
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      background: #000919;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body>

  <!--------------------------------------------------------------------------
  | SCRIPT
  |-------------------------------------------------------------------------->

  <script>
    function autoScale() {
      const frame = document.getElementById('frame');
      const scaleW = window.innerWidth / 430;
      const scaleH = window.innerHeight / 932;
      const scale = Math.min(scaleW, scaleH);
      frame.style.transform = `translate(-50%, -50%) scale(${scale})`;
      frame.style.position = 'absolute';
      frame.style.left = '50%';
      frame.style.top = '50%';
    }
    window.addEventListener('resize', autoScale);
    window.addEventListener('load', autoScale);
  </script>

  <!--------------------------------------------------------------------------
  | MAIN FRAME
  |-------------------------------------------------------------------------->

  <div id="frame" style="position:relative;width:430px;height:932px;background:#000919;transform-origin:center center;">
    <div style="width:501px;height:993px;left:-42px;top:0;position:absolute;background:#000919;box-shadow:0 4px 4px rgba(0,0,0,0.25)"></div>
    <div style="position:absolute;top:155px;left:0;width:100%;height:calc(932px - 155px + 150px);background:rgba(217,217,217,0.74);opacity:0.07;border-radius:41px;bottom:-150px;"></div>

    <!-- Dashboard button -->
    <img src="{{ asset('dimages/dashboardbutton.png') }}" alt="Dashboard Button" draggable="false"
      style="width:192px;height:52px;left:20px;top:78px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
      onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
      onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'" onclick="window.location.href='{{ route('home') }}'">

    <!-- Login button -->
    <img src="{{ asset('dimages/loginbutton.png') }}" alt="Login Button" draggable="false"
      style="width:30px;height:35px;left:371.85px;top:89.97px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
      onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
      onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'">

    <!--------------------------------------------------------------------------
    | TABS
    |-------------------------------------------------------------------------->

    <!-- Home Tab -->
    <img src="{{ asset('himages/homebutton2.png') }}" alt="Home Button" draggable="false"
      style="width:110px;height:50px;left:30px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
      onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
      onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'"
      onclick="window.location.href='{{ route('home') }}'">

    <!-- History Tab -->
    <img src="{{ asset('dimages/historybutton.png') }}" alt="History Button" draggable="false"
      style="width:110px;height:50px;left:160px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
      onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
      onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'"
      onclick="window.location.href='{{ route('history') }}'">

    <!-- Menu Tab -->
    <img src="{{ asset('mimages/menubutton2.png') }}" alt="More Button" draggable="false"
      style="width:110px;height:50px;left:290px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
      onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
      onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'"
      onclick="window.location.href='{{ route('menu') }}'">

        <!-- My Profile -->
        <div style="position:absolute;left:24px;top:260px;cursor:pointer;transition:transform 0.15s ease;"
        onmousedown="this.style.transform='scale(1.03)'"
        onmouseup="this.style.transform='scale(1)'"
        onmouseleave="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.03)'"
        ontouchend="this.style.transform='scale(1)'">
        <div class="Rectangle43" style="width:383px;height:47px;background:rgba(217,217,217,0.13);border-radius:15px;"></div>
        <div class="MyProfile" style="position:absolute;left:60px;top:13px;color:white;font-size:15px;font-family:Poppins;font-weight:600;">My Profile</div>
        <img src="{{ asset('mimages/Profile.png') }}" alt="icon" width="19" height="19" style="position:absolute;left:20px;top:13px;">
        </div>

        <!-- My Payments -->
        <div style="position:absolute;left:24px;top:320px;cursor:pointer;transition:transform 0.15s ease;"
        onmousedown="this.style.transform='scale(1.03)'"
        onmouseup="this.style.transform='scale(1)'"
        onmouseleave="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.03)'"
        ontouchend="this.style.transform='scale(1)'">
        <div class="Rectangle44" style="width:383px;height:47px;background:rgba(217,217,217,0.13);border-radius:15px;"></div>
        <div class="MyPayments" style="position:absolute;left:60px;top:13px;color:white;font-size:15px;font-family:Poppins;font-weight:600;">My Payments</div>
        <img src="{{ asset('mimages/Payments.png') }}" alt="icon" width="20" height="20" style="position:absolute;left:20px;top:13px;">
        </div>

        <!-- General -->
        <div style="position:absolute;left:24px;top:380px;cursor:pointer;transition:transform 0.15s ease;"
        onmousedown="this.style.transform='scale(1.03)'"
        onmouseup="this.style.transform='scale(1)'"
        onmouseleave="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.03)'"
        ontouchend="this.style.transform='scale(1)'">
        <div class="Rectangle47" style="width:383px;height:47px;background:rgba(217,217,217,0.13);border-radius:15px;"></div>
        <div class="General" style="position:absolute;left:60px;top:13px;color:white;font-size:15px;font-family:Poppins;font-weight:600;">General</div>
        <img src="{{ asset('mimages/General.png') }}" alt="icon" width="20" height="20" style="position:absolute;left:20px;top:13px;">
        </div>

        <!-- Help FAQ -->
        <div style="position:absolute;left:24px;top:440px;cursor:pointer;transition:transform 0.15s ease;"
        onmousedown="this.style.transform='scale(1.03)'"
        onmouseup="this.style.transform='scale(1)'"
        onmouseleave="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.03)'"
        ontouchend="this.style.transform='scale(1)'">
        <div class="Rectangle48" style="width:383px;height:47px;background:rgba(217,217,217,0.13);border-radius:15px;"></div>
        <div class="HelpFaq" style="position:absolute;left:60px;top:13px;color:white;font-size:15px;font-family:Poppins;font-weight:600;">Help FAQ</div>
        <img src="{{ asset('mimages/FAQ.png') }}" alt="icon" width="20" height="20" style="position:absolute;left:20px;top:13px;">
        </div>

        <!-- Contact Customer Support -->
        <div style="position:absolute;left:24px;top:500px;cursor:pointer;transition:transform 0.15s ease;"
        onmousedown="this.style.transform='scale(1.03)'"
        onmouseup="this.style.transform='scale(1)'"
        onmouseleave="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.03)'"
        ontouchend="this.style.transform='scale(1)'">
        <div class="Rectangle49" style="width:383px;height:47px;background:rgba(217,217,217,0.13);border-radius:15px;"></div>
        <div class="ContactCustomerSupport" style="position:absolute;left:60px;top:13px;color:white;font-size:15px;font-family:Poppins;font-weight:600;">Contact Customer Support</div>
        <img src="{{ asset('mimages/CCS.png') }}" alt="icon" width="20" height="20" style="position:absolute;left:20px;top:13px;">
        </div>

        <!-- Report -->
        <div style="position:absolute;left:24px;top:560px;cursor:pointer;transition:transform 0.15s ease;"
        onmousedown="this.style.transform='scale(1.03)'"
        onmouseup="this.style.transform='scale(1)'"
        onmouseleave="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.03)'"
        ontouchend="this.style.transform='scale(1)'">
        <div class="Rectangle51" style="width:383px;height:47px;background:rgba(217,217,217,0.13);border-radius:15px;"></div>
        <div class="Report" style="position:absolute;left:60px;top:13px;color:white;font-size:15px;font-family:Poppins;font-weight:600;">Report</div>
        <img src="{{ asset('mimages/report.png') }}" alt="icon" width="20" height="20" style="position:absolute;left:20px;top:13px;">
        </div>
  </div>

  </body>
</html>