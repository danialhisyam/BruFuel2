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
        ontouchend="this.style.transform='scale(1)'" onclick="window.location.href='{{ route('signup') }}'">>

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
    <img src="{{ asset('himages/historybutton2.png') }}" alt="History Button" draggable="false"
      style="width:110px;height:50px;left:160px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
      onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
      onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'"
      onclick="window.location.href='{{ route('history') }}'">

        <!-- Background Rectangle -->
        <div data-layer="Rectangle 27" class="Rectangle27"
        style="width: 399px; height: 740px; left: 16px; top: 255px; position: absolute; background: rgba(236, 235, 235, 0.04); border-radius: 15px;">
        </div>

        <!-- Date Label -->
        <div data-layer="Date" class="Date"
        style="width: 71px; height: 24px; left: 20px; top: 270px; position: absolute; text-align: center; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 14px; font-family: Poppins; font-weight: 800; word-wrap: break-word;">Date</div>

        <!-- Amount Label -->
        <div data-layer="Amount BND$" class="AmountBnd"
        style="width: 138px; height: 24px; left: 270px; top: 270px; position: absolute; text-align: center; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 14px; font-family: Poppins; font-weight: 800; word-wrap: break-word;">Amount&nbsp;BND$</div>

        <!-- History Card -->
        <div data-layer="Rectangle 28" class="Rectangle28"
        style="width: 378px; height: 131px; left: 26px; top: 305px; position: absolute; background: #242B37; border-radius: 15px;"></div>

        <!-- Placeholder Image -->
        <img data-layer="image 42" class="Image42"
        src="{{ asset('himages/emptyhistory.png') }}"
        alt="Placeholder"
        style="width: 330px; height: 93.5px; left: 50px; top: 324px; position: absolute;">

    <!-- Menu Tab -->
    <img src="{{ asset('dimages/morebutton.png') }}" alt="More Button" draggable="false"
      style="width:110px;height:50px;left:290px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
      onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
      onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'"
      onclick="window.location.href='{{ route('menu') }}'">
  </div>

  </body>
</html>