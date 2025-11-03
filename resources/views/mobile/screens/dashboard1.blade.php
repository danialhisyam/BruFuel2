<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brufuel Dashboard</title>

    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
  </head>

  <body>
<div data-layer="Test Area" class="TestArea" style="width: 430px; height: 932px; position: relative; background: white; overflow: hidden">
  <div data-layer="Background" class="Background" style="width: 501px; height: 993px; left: -42px; top: 0px; position: absolute; background: #000919; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)"></div>
  <div data-layer="Rectangle 22" class="Rectangle22" style="width: 430px; height: 819px; left: 0px; top: 155px; position: absolute; opacity: 0.07; background: rgba(217, 217, 217, 0.74); border-radius: 41px"></div>

<!-- ✅ NAVIGATION BUTTONS (unchanged visually) -->
<!-- History Button -->
<button onclick="console.log('History button tapped'); activateTab('history')" 
style="background: none; border: none; padding: 0; position: absolute; left: 224px; top: 180px; width: 80px; height: 50px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent; z-index: 10;"
onmousedown="this.style.transform='scale(1.2)'"
onmouseup="this.style.transform='scale(1)'"
ontouchstart="this.style.transform='scale(1.2)'"
onmouseleave="this.style.transform='scale(1)'"
ontouchcancel="this.style.transform='scale(1)'"
ontouchend="this.style.transform='scale(1)'">
  <img data-layer="image 15" class="Image15" src="{{ asset('images/historybutton.png') }}" alt="History Button" draggable="false" style="width: 100%; height: 100%; display: block;"/>
</button>

<!-- Home Button -->
<button onclick="console.log('Home button tapped'); activateTab('dashboard')" 
style="background: none; border: none; padding: 0; position: absolute; left: 21px; top: 80px; width: 191px; height: 48px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent; z-index: 10;"
onmousedown="this.style.transform='scale(1.2)'"
onmouseup="this.style.transform='scale(1)'"
ontouchstart="this.style.transform='scale(1.2)'"
onmouseleave="this.style.transform='scale(1)'"
ontouchcancel="this.style.transform='scale(1)'"
ontouchend="this.style.transform='scale(1)'">
  <img data-layer="image 17" class="Image17" src="{{ asset('images/homebutton.png') }}" alt="Home Button" draggable="false" style="width: 100%; height: 100%; display: block;"/>
</button>

<!-- Deal Button -->
<button onclick="console.log('Deal button tapped'); activateTab('deals')" 
style="background: none; border: none; padding: 0; position: absolute; left: 126px; top: 180px; width: 80px; height: 50px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent; z-index: 10;"
onmousedown="this.style.transform='scale(1.2)'"
onmouseup="this.style.transform='scale(1)'"
ontouchstart="this.style.transform='scale(1.2)'"
onmouseleave="this.style.transform='scale(1)'"
ontouchcancel="this.style.transform='scale(1)'"
ontouchend="this.style.transform='scale(1)'">
  <img data-layer="image 14" class="Image14" src="{{ asset('images/dealbutton.png') }}" alt="Deal Button" draggable="false" style="width: 100%; height: 100%; display: block;"/>
</button>

<!-- Dashboard Button -->
<button onclick="console.log('Dashboard button tapped'); activateTab('dashboard')" 
style="background: none; border: none; padding: 0; position: absolute; left: 28px; top: 180px; width: 80px; height: 50px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent; z-index: 10;"
onmousedown="this.style.transform='scale(1.2)'"
onmouseup="this.style.transform='scale(1)'"
ontouchstart="this.style.transform='scale(1.2)'"
onmouseleave="this.style.transform='scale(1)'"
ontouchcancel="this.style.transform='scale(1)'"
ontouchend="this.style.transform='scale(1)'">
  <img data-layer="image 23" class="Image23" src="{{ asset('images/dashboardbutton2.png') }}" alt="Dashboard Button" draggable="false" style="width: 100%; height: 100%; display: block;">
</button>

<!-- More Button -->
<button onclick="console.log('More button tapped'); activateTab('more')" 
style="background: none; border: none; padding: 0; position: absolute; left: 322px; top: 180px; width: 80px; height: 50px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent; z-index: 10;"
onmousedown="this.style.transform='scale(1.2)'"
onmouseup="this.style.transform='scale(1)'"
ontouchstart="this.style.transform='scale(1.2)'"
onmouseleave="this.style.transform='scale(1)'"
ontouchcancel="this.style.transform='scale(1)'"
ontouchend="this.style.transform='scale(1)'">
  <img data-layer="image 16" class="Image16" src="{{ asset('images/morebutton.png') }}" alt="More Button" draggable="false" style="width: 100%; height: 100%; display: block;"/>
</button>

<!-- ✅ Login Button -->
<button onclick="openPopup3()" 
style="background: none; border: none; padding: 0; position: absolute; left: 371.85px; top: 89.97px; width: 31px; height: 36px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent; z-index: 10;"
onmousedown="this.style.transform='scale(1.2)'"
onmouseup="this.style.transform='scale(1)'"
ontouchstart="this.style.transform='scale(1.2)'"
ontouchend="this.style.transform='scale(1)'">
  <img src="{{ asset('images/loginbutton.png') }}" alt="Login Button" draggable="false" style="width: 100%; height: 100%; display: block;"/>
</button>

<!-- ✅ DEALS TAB -->
<div id="dealsTab" class="tab" style="display:none;">
  <!-- Scrollable container -->
  <div style="
    position: absolute; 
    top: 262px; 
    left: 0; 
    width: 430px; 
    height: 608px; /* 870 - 262 = 608px visible area */
    overflow-y: auto; 
    overflow-x: hidden; 
    -webkit-overflow-scrolling: touch; /* elastic scroll for all mobile browsers */
    scrollbar-width: none; 
    -ms-overflow-style: none;
  ">
    <style>
      div::-webkit-scrollbar { display: none; }
    </style>

    <!-- Scrollable content -->
    <div style="position: relative; height: 1000px;">

      <!-- First Delivery Discount -->
      <button 
        onclick="openPopup()"
        style="background: none; border: none; padding: 0; position: absolute; left: 20px; top: 0px; width: 389px; height: 143px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
        onmousedown="this.style.transform='scale(1.05)'"
        onmouseup="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.05)'"
        ontouchend="this.style.transform='scale(1)'">
        <img data-layer="image 24" class="Image24" src="{{ asset('images/firstdeliverydiscount.png') }}" alt="First Delivery Discount" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
      </button>

      <!-- Refer & Save -->
      <button 
        onclick="openPopup()"
        style="background: none; border: none; padding: 0; position: absolute; left: 20px; top: 160px; width: 389px; height: 143px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
        onmousedown="this.style.transform='scale(1.05)'"
        onmouseup="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.05)'"
        ontouchend="this.style.transform='scale(1)'">
        <img data-layer="image 30" class="Image30" src="{{ asset('images/refer&save.png') }}" alt="Refer & Save" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
      </button>

      <!-- Early Bird Fuel -->
      <button 
        onclick="openPopup()"
        style="background: none; border: none; padding: 0; position: absolute; left: 20px; top: 320px; width: 389px; height: 143px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
        onmousedown="this.style.transform='scale(1.05)'"
        onmouseup="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.05)'"
        ontouchend="this.style.transform='scale(1)'">
        <img data-layer="image 29" class="Image29" src="{{ asset('images/earlybirdfuel.png') }}" alt="Early Bird Fuel" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
      </button>

      <!-- Diesel Special -->
      <button 
        onclick="openPopup()"
        style="background: none; border: none; padding: 0; position: absolute; left: 20px; top: 480px; width: 389px; height: 143px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
        onmousedown="this.style.transform='scale(1.05)'"
        onmouseup="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.05)'"
        ontouchend="this.style.transform='scale(1)'">
        <img data-layer="image 28" class="Image28" src="{{ asset('images/dieselspecial.png') }}" alt="Diesel Special" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
      </button>

      <!-- Frequent Filler -->
      <button 
        onclick="openPopup()"
        style="background: none; border: none; padding: 0; position: absolute; left: 20px; top: 640px; width: 389px; height: 143px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
        onmousedown="this.style.transform='scale(1.05)'"
        onmouseup="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.05)'"
        ontouchend="this.style.transform='scale(1)'">
        <img data-layer="image 27" class="Image27" src="{{ asset('images/frequentfiller.png') }}" alt="Frequent Filler" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
      </button>

      <!-- Holiday Fuel Special -->
      <button 
        onclick="openPopup()"
        style="background: none; border: none; padding: 0; position: absolute; left: 20px; top: 800px; width: 389px; height: 143px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
        onmousedown="this.style.transform='scale(1.1)'"
        onmouseup="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.1)'"
        ontouchend="this.style.transform='scale(1)'">
        <img data-layer="image 26" class="Image26" src="{{ asset('images/holidayfuelspecial.png') }}" alt="Holiday Fuel Special" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
      </button>

    </div>
  </div>
</div>



<!-- ✅ DASHBOARD TAB (default visible) -->
<div id="dashboardTab" class="tab" style="display:block;">
  <div style="position: relative; width: 430px; height: 932px; overflow-y: auto; overflow-x: hidden; scrollbar-width: none; -ms-overflow-style: none;">
    <style> div::-webkit-scrollbar { display: none; } </style>

    <div style="position: relative; height: 950px;"> 
      <img data-layer="image 20" class="Image20" style="width: 389px; height: 183px; left: 20px; top: 471.71px; position: absolute;" src="{{ asset('images/yourvehicles.png') }}" draggable="false"/>
      <img data-layer="image 21" class="Image21" style="width: 389px; height: 183px; left: 20px; top: 681.42px; position: absolute;" src="{{ asset('images/yourlocation.png') }}" draggable="false"/>
      <img data-layer="image 19" class="Image19" style="width: 389px; height: 183px; left: 20px; top: 262px; position: absolute;" src="{{ asset('images/yourdelivery.png') }}" draggable="false"/>

      <!-- Order Fuel Now -->
      <button onclick= "openPopup()"
      style="background: none; border: none; padding: 0; position: absolute; left: 124px; top: 426.84px; width: 185px; height: 36px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
      onmousedown="this.style.transform='scale(1.2)'"
      onmouseup="this.style.transform='scale(1)'"
      ontouchstart="this.style.transform='scale(1.2)'"
      ontouchend="this.style.transform='scale(1)'">
        <img data-layer="image 10" class="Image10" src="{{ asset('images/orderfuelnow.png') }}" alt="Order Fuel Now Button" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
      </button>

      <!-- Add Vehicle -->
      <button onclick="openPopup()"
      style="background: none; border: none; padding: 0; position: absolute; left: 121px; top: 636.55px; width: 185px; height: 35.5px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
      onmousedown="this.style.transform='scale(1.2)'"
      onmouseup="this.style.transform='scale(1)'"
      ontouchstart="this.style.transform='scale(1.2)'"
      ontouchend="this.style.transform='scale(1)'">
        <img data-layer="image 11" class="Image11" src="{{ asset('images/addvehicle.png') }}" alt="Add Vehicle Button" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
      </button>

      <!-- Pinpoint Now -->
      <button onclick="openPopup()"
      style="background: none; border: none; padding: 0; position: absolute; left: 122px; top: 846.26px; width: 185px; height: 35.5px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
      onmousedown="this.style.transform='scale(1.2)'"
      onmouseup="this.style.transform='scale(1)'"
      ontouchstart="this.style.transform='scale(1.2)'"
      ontouchend="this.style.transform='scale(1)'">
        <img data-layer="image 12" class="Image12" src="{{ asset('images/pinpointnow.png') }}" alt="Pinpoint Now Button" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
      </button>
    </div>
  </div>
</div>

<!-- ✅ HISTORY TAB -->
<div id="historyTab" class="tab" style="display:none; position:relative;">

  <!-- Stationary background -->
  <img 
    data-layer="image 25" 
    class="Image25" 
    src="{{ asset('images/historybackground.png') }}" 
    draggable="false"
    style="
      position: absolute; 
      left: 15px; 
      top: 246px; 
      width: 399px; 
      height: 686px;
      user-select: none;
      -webkit-user-drag: none;
      z-index: 1;
    "
  />

  <!-- Scrollable content (elastic pull area) -->
  <div style="
    position: absolute; 
    left: 26px; 
    top: 308px; 
    width: 378px; 
    height: 600px; 
    overflow-y: auto; 
    overflow-x: hidden; 
    -webkit-overflow-scrolling: touch;  /* ✅ enables elastic pull-to-refresh effect */
    scrollbar-width: none; 
    -ms-overflow-style: none;
    z-index: 2;
  ">
    <style> div::-webkit-scrollbar { display: none; } </style>

    <!-- Scrollable inner content -->
    <div style="position: relative; height: 900px;">
      <img 
        data-layer="image 24" 
        class="Image24" 
        src="{{ asset('images/historydata.png') }}" 
        draggable="false"
        style="
          position: absolute; 
          left: 0px; 
          top: 0px; 
          width: 378px; 
          height: 131px; 
          user-select: none; 
          -webkit-user-drag: none;
        "
      />
    </div>
  </div>
</div>

<!-- ✅ MORE TAB -->
<div id="moreTab" class="tab" style="display:none; position:relative;">

  <!-- My Profile Button -->
  <button 
    onclick="openPopup()"
    style="background: none; border: none; padding: 0; position: absolute; left: 24px; top: 282px; width: 383px; height: 47px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
    onmousedown="this.style.transform='scale(1.1)'"
    onmouseup="this.style.transform='scale(1)'"
    ontouchstart="this.style.transform='scale(1.1)'"
    ontouchend="this.style.transform='scale(1)'">
      <img data-layer="image 25" class="Image25" src="{{ asset('images/myprofile.png') }}" alt="My Profile" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
  </button>

  <!-- My Payments Button -->
  <button 
    onclick="console.log('My Payments button tapped')" 
    style="background: none; border: none; padding: 0; position: absolute; left: 24px; top: 346px; width: 383px; height: 47px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
    onmousedown="this.style.transform='scale(1.1)'"
    onmouseup="this.style.transform='scale(1)'"
    ontouchstart="this.style.transform='scale(1.1)'"
    ontouchend="this.style.transform='scale(1)'">
      <img data-layer="image 26" class="Image26" src="{{ asset('images/mypayments.png') }}" alt="My Payments" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
  </button>

  <!-- General Button -->
  <button 
    onclick="console.log('General button tapped')" 
    style="background: none; border: none; padding: 0; position: absolute; left: 24px; top: 408px; width: 383px; height: 47px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
    onmousedown="this.style.transform='scale(1.1)'"
    onmouseup="this.style.transform='scale(1)'"
    ontouchstart="this.style.transform='scale(1.1)'"
    ontouchend="this.style.transform='scale(1)'">
      <img data-layer="image 27" class="Image27" src="{{ asset('images/general.png') }}" alt="General" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
  </button>

  <!-- Help / FAQ Button -->
  <button 
    onclick="console.log('Help & FAQ button tapped')" 
    style="background: none; border: none; padding: 0; position: absolute; left: 24px; top: 472px; width: 383px; height: 47px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
    onmousedown="this.style.transform='scale(1.1)'"
    onmouseup="this.style.transform='scale(1)'"
    ontouchstart="this.style.transform='scale(1.1)'"
    ontouchend="this.style.transform='scale(1)'">
      <img data-layer="image 28" class="Image28" src="{{ asset('images/helpfaq.png') }}" alt="Help & FAQ" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
  </button>

  <!-- Contact Customer Support Button -->
  <button 
    onclick="console.log('Contact Customer Support button tapped')" 
    style="background: none; border: none; padding: 0; position: absolute; left: 24px; top: 536px; width: 383px; height: 47px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
    onmousedown="this.style.transform='scale(1.1)'"
    onmouseup="this.style.transform='scale(1)'"
    ontouchstart="this.style.transform='scale(1.1)'"
    ontouchend="this.style.transform='scale(1)'">
      <img data-layer="image 29" class="Image29" src="{{ asset('images/contactcustomersupport.png') }}" alt="Contact Customer Support" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
  </button>

  <!-- Report Button -->
  <button 
    onclick="console.log('Report button tapped')" 
    style="background: none; border: none; padding: 0; position: absolute; left: 24px; top: 602px; width: 383px; height: 47px; cursor: pointer; transition: transform 0.15s ease; outline: none; -webkit-tap-highlight-color: transparent;"
    onmousedown="this.style.transform='scale(1.1)'"
    onmouseup="this.style.transform='scale(1)'"
    ontouchstart="this.style.transform='scale(1.1)'"
    ontouchend="this.style.transform='scale(1)'">
      <img data-layer="image 30" class="Image30" src="{{ asset('images/report.png') }}" alt="Report" draggable="false" style="width: 100%; height: 100%; display: block; user-select: none; -webkit-user-drag: none;"/>
  </button>

</div>

<!-- ✅ SCRIPT SECTION -->
<script>
function switchTab(id) {
  document.querySelectorAll('.tab').forEach(tab => tab.style.display = 'none');
  const show = document.getElementById(id);
  if (show) show.style.display = 'block';
}

function activateTab(tab) {
  // reset all buttons to normal (blue)
  document.querySelector(".Image23").src = "{{ asset('images/dashboardbutton.png') }}";
  document.querySelector(".Image14").src = "{{ asset('images/dealbutton.png') }}";
  document.querySelector(".Image15").src = "{{ asset('images/historybutton.png') }}";
  document.querySelector(".Image16").src = "{{ asset('images/morebutton.png') }}";

  // set the correct one active (yellow)
  if (tab === 'dashboard') {
    document.querySelector(".Image23").src = "{{ asset('images/dashboardbutton2.png') }}";
    switchTab('dashboardTab');
  } 
  else if (tab === 'deals') {
    document.querySelector(".Image14").src = "{{ asset('images/dealbutton2.png') }}";
    switchTab('dealsTab');
  } 
  else if (tab === 'history') {
    document.querySelector(".Image15").src = "{{ asset('images/historybutton2.png') }}";
    switchTab('historyTab');
  } 
  else if (tab === 'more') {
    document.querySelector(".Image16").src = "{{ asset('images/morebutton2.png') }}";
    switchTab('moreTab');
  }
  // Ensure dashboard is active on first load
window.addEventListener('DOMContentLoaded', () => {
  activateTab('dashboard');
});

}
</script>

<!-- ✅ FIRST POPUP (No Account Yet) -->
<div id="popupOverlay"
     onclick="closePopup(event)"
     style="display:none; position:fixed; inset:0;
            background:rgba(0,0,0,0.3);
            backdrop-filter:blur(0px);
            z-index:999; justify-content:center; align-items:center;
            transition:backdrop-filter 0.3s ease, background 0.3s ease;">

  <!-- ✅ Popup container -->
  <div id="popupBox"
       style="position:relative; width:430px; height:932px; pointer-events:none;">

    <!-- Background -->
    <img src="{{ asset('images/popupbackground.png') }}"
         style="position:absolute; left:58px; top:338px; width:314px; height:341px;
                pointer-events:none; z-index:1;" draggable="false">

    <!-- ✅ Tab 1: No Account Yet -->
    <div id="tab1" style="display:block;">
      <img src="{{ asset('images/noaccountyet.png') }}"
           style="position:absolute; left:86px; top:465px; width:252px; height:111.5px;
                  pointer-events:auto; z-index:2; animation:slideUp 0.3s ease-out;"
           draggable="false">

      <!-- Continue Button -->
      <button
        onclick="swapTab('tab1','tab2'); event.stopPropagation();"
        style="background:none; border:none; padding:0; position:absolute; left:88px; top:610px;
               width:257px; height:41px; cursor:pointer; transition:transform 0.15s ease;
               outline:none; -webkit-tap-highlight-color:transparent; pointer-events:auto; z-index:3;"
        onmousedown="this.style.transform='scale(1.1)'"
        onmouseup="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.1)'"
        ontouchend="this.style.transform='scale(1)'">
        <img src="{{ asset('images/noaccountyetcontinue.png') }}"
             style="width:100%; height:100%; display:block;" draggable="false">
      </button>
    </div>

<!-- ✅ Tab 2: Login -->
<div id="tab2" style="display:none; position:relative;">

  <!-- 📦 Textbox dummy background -->
  <img data-layer="image 25" class="Image25"
       src="{{ asset('images/textboxdummy.png') }}"
       style="position:absolute; left:84px; top:461px;
              width:265px; height:96px; z-index:1;
                opacity:1.0;"
       draggable="false">

  <!-- Email input box -->
  <div data-layer="Rectangle 26"
       style="position:absolute; left:84px; top:461px;
              width:265px; height:45px;
              background:rgba(217,217,217,0.10);
              border-radius:15px; border:1px rgba(127,127,127,0) solid;
              z-index:2;">
  </div>

  <!-- Password input box -->
  <div data-layer="Rectangle 32"
       style="position:absolute; left:84px; top:512px;
              width:265px; height:45px;
              background:rgba(217,217,217,0.10);
              border-radius:15px; border:1px rgba(127,127,127,0) solid;
              z-index:2;">
  </div>

  <!-- “Sign Up” link button -->
  <button
    onclick="window.location.href='{{ url('register') }}'"
    style="background:none; border:none; padding:0;
           position:absolute; left:175px; top:563px;
           width:160px; height:9.5px;
           cursor:pointer; transition:transform 0.15s ease;
           outline:none; -webkit-tap-highlight-color:transparent;
           pointer-events:auto; z-index:3;"
    onmousedown="this.style.transform='scale(1.1)'"
    onmouseup="this.style.transform='scale(1)'"
    ontouchstart="this.style.transform='scale(1.1)'"
    ontouchend="this.style.transform='scale(1)'">
    <img src="{{ asset('images/noaccountyetsignup.png') }}"
         style="width:100%; height:100%; display:block;" draggable="false">
  </button>

  <!-- ✅ Login button -->
<button
  onclick="window.location.href='{{ url('/mobile/dashboardlogged') }}'"
  style="background:none; border:none; padding:0;
         position:absolute; left:88px; top:610px;
         width:257px; height:41px;
         cursor:pointer; transition:transform 0.15s ease;
         outline:none; -webkit-tap-highlight-color:transparent;
         pointer-events:auto; z-index:3;"
  onmousedown="this.style.transform='scale(1.1)'"
  onmouseup="this.style.transform='scale(1)'"
  ontouchstart="this.style.transform='scale(1.1)'"
  ontouchend="this.style.transform='scale(1)'">
  <img src="{{ asset('images/loginpopuplogin.png') }}"
       style="width:100%; height:100%; display:block;" draggable="false">
</button>

</div>


  </div>
</div>

<!-- ✅ Animations -->
<style>
@keyframes slideUp {
  from { transform: translateY(100%); opacity: 0; }
  to   { transform: translateY(0); opacity: 1; }
}
@keyframes slideDown {
  from { transform: translateY(0); opacity: 1; }
  to   { transform: translateY(100%); opacity: 0; }
}
</style>



<!-- ✅ Script -->
<script>
function openPopup() {
  const overlay = document.getElementById('popupOverlay');
  const popup = document.getElementById('popupBox');
  overlay.style.display = 'flex';
  popup.style.animation = 'slideUp 0.3s ease-out forwards';
  setTimeout(() => {
    overlay.style.backdropFilter = 'blur(5px)';
    overlay.style.background = 'rgba(0,0,0,0.5)';
  }, 10);
}

function closePopup(event) {
  if (event.target.id === 'popupOverlay') {
    const overlay = document.getElementById('popupOverlay');
    const popup = document.getElementById('popupBox');
    popup.style.animation = 'slideDown 0.3s ease-in forwards';
    overlay.style.backdropFilter = 'blur(0px)';
    overlay.style.background = 'rgba(0,0,0,0.3)';
    setTimeout(() => {
      overlay.style.display = 'none';
      popup.style.animation = '';
      document.getElementById('tab1').style.display = 'block';
      document.getElementById('tab2').style.display = 'none';
    }, 300);
  }
}

function swapTab(hideId, showId) {
  document.getElementById(hideId).style.display = 'none';
  document.getElementById(showId).style.display = 'block';
}
</script>

<!-- ✅ POPUP 3 -->
<div id="popup3Overlay"
     onclick="closePopup3(event)"
     style="display:none; position:fixed; inset:0;
            background:rgba(0,0,0,0.3);
            backdrop-filter:blur(0px);
            z-index:999; justify-content:center; align-items:center;
            transition:backdrop-filter 0.3s ease, background 0.3s ease;">

  <!-- ✅ Popup container -->
  <div id="popup3Box"
       style="position:relative; width:430px; height:932px; pointer-events:none;">

    <!-- Background -->
    <img src="{{ asset('images/popupbackground.png') }}"
         style="position:absolute; left:58px; top:338px; width:314px; height:341px;
                pointer-events:none; z-index:1;" draggable="false">

  <button
    onclick="window.location.href='{{ url('register') }}'"
    style="background:none; border:none; padding:0;
           position:absolute; left:175px; top:563px;
           width:160px; height:9.5px;
           cursor:pointer; transition:transform 0.15s ease;
           outline:none; -webkit-tap-highlight-color:transparent;
           pointer-events:auto; z-index:3;"
    onmousedown="this.style.transform='scale(1.1)'"
    onmouseup="this.style.transform='scale(1)'"
    ontouchstart="this.style.transform='scale(1.1)'"
    ontouchend="this.style.transform='scale(1)'">
    <img src="{{ asset('images/noaccountyetsignup.png') }}"
         style="width:100%; height:100%; display:block;" draggable="false">
  </button>

    <!-- 📦 Textbox dummy background -->
    <img data-layer="image 25" class="Image25"
         src="{{ asset('images/textboxdummy.png') }}"
         style="position:absolute; left:84px; top:461px;
                width:265px; height:96px; z-index:1; opacity:1.0;"
         draggable="false">

    <!-- Email input box -->
    <div data-layer="Rectangle 26"
         style="position:absolute; left:84px; top:461px;
                width:265px; height:45px;
                background:rgba(217,217,217,0.10);
                border-radius:15px; border:1px rgba(127,127,127,0) solid;
                z-index:2;">
    </div>

    <!-- Password input box -->
    <div data-layer="Rectangle 32"
         style="position:absolute; left:84px; top:512px;
                width:265px; height:45px;
                background:rgba(217,217,217,0.10);
                border-radius:15px; border:1px rgba(127,127,127,0) solid;
                z-index:2;">
    </div>

    <!-- ✅ Login button -->
    <button
      onclick="window.location.href='{{ url('/mobile/dashboardlogged') }}'"
      style="background:none; border:none; padding:0;
             position:absolute; left:88px; top:610px;
             width:257px; height:41px;
             cursor:pointer; transition:transform 0.15s ease;
             outline:none; -webkit-tap-highlight-color:transparent;
             pointer-events:auto; z-index:3;"
      onmousedown="this.style.transform='scale(1.1)'"
      onmouseup="this.style.transform='scale(1)'"
      ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'">
      <img src="{{ asset('images/loginpopuplogin.png') }}"
           style="width:100%; height:100%; display:block;" draggable="false">
    </button>
  </div>
</div>

<!-- ✅ Animations -->
<style>
@keyframes slideUp {
  from { transform: translateY(100%); opacity: 0; }
  to   { transform: translateY(0); opacity: 1; }
}
@keyframes slideDown {
  from { transform: translateY(0); opacity: 1; }
  to   { transform: translateY(100%); opacity: 0; }
}
</style>

<!-- ✅ Script -->
<script>
function openPopup3() {
  const overlay = document.getElementById('popup3Overlay');
  const popup = document.getElementById('popup3Box');
  overlay.style.display = 'flex';
  popup.style.animation = 'slideUp 0.3s ease-out forwards';
  setTimeout(() => {
    overlay.style.backdropFilter = 'blur(5px)';
    overlay.style.background = 'rgba(0,0,0,0.5)';
  }, 10);
}

function closePopup3(event) {
  if (event.target.id === 'popup3Overlay') {
    const overlay = document.getElementById('popup3Overlay');
    const popup = document.getElementById('popup3Box');
    popup.style.animation = 'slideDown 0.3s ease-in forwards';
    overlay.style.backdropFilter = 'blur(0px)';
    overlay.style.background = 'rgba(0,0,0,0.3)';
    setTimeout(() => {
      overlay.style.display = 'none';
      popup.style.animation = '';
    }, 300);
  }
}
</script>



</body>
</html>
