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
    <img src="{{ asset('dimages/homebutton.png') }}" alt="Home Button" draggable="false"
      style="width:110px;height:50px;left:30px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
      onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
      onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'"
      onclick="window.location.href='{{ route('home') }}'">

    <!-- Delivery Status -->
    <div style="width:123px;height:26px;left:27px;top:267px;position:absolute;display:flex;justify-content:center;align-items:center;color:white;font-size:15px;font-weight:600;">Delivery Status</div>
    <div style="width:389px;height:143px;left:20px;top:301px;position:absolute;background:rgba(217,217,217,0.10);border-radius:15px;"></div>
    <img style="width:330px;height:73px;left:50px;top:337px;position:absolute;" src="{{ asset('dimages/emptyorder.png') }}">
    <button onclick="toggleLoginPopup(true)"
      style="border:none;background:none;padding:0;position:absolute;left:124px;top:426.84px;cursor:pointer;">
      <div class="w-48 h-9 bg-[#760000] rounded-[33px] flex justify-center items-center"
        style="transition:transform 0.15s ease;"
        onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
        onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
        ontouchend="this.style.transform='scale(1)'">
        <span class="text-white text-base font-semibold font-[Poppins]">ORDER FUEL NOW</span>
      </div>
    </button>

    <!-- Your vehicles -->
    <div style="width:168px;height:24px;left:30px;top:477.91px;position:absolute;display:flex;align-items:center;color:white;font-size:15px;font-weight:600;">Your vehicles</div>
    <div style="width:389px;height:145px;left:20px;top:509px;position:absolute;background:rgba(217,217,217,0.10);border-radius:15px;"></div>
    <img style="width:330px;height:57px;left:49px;top:558px;position:absolute;" src="{{ asset('dimages/emptycar.png') }}">
    <button onclick="toggleLoginPopup(true)"
      style="border:none;background:none;padding:0;position:absolute;left:121px;top:636.55px;cursor:pointer;">
      <div class="w-48 h-9 bg-[#760000] rounded-[33px] flex justify-center items-center"
        style="transition:transform 0.15s ease;"
        onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
        onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
        ontouchend="this.style.transform='scale(1)'">
        <span class="text-white text-base font-semibold font-[Poppins]">ADD VEHICLE</span>
      </div>
    </button>

    <!-- Your saved locations -->
    <div style="width:175px;height:24px;left:22px;top:687.1px;position:absolute;display:flex;justify-content:center;align-items:center;color:white;font-size:15px;font-weight:600;">Your saved locations</div>
    <div style="width:389px;height:145px;left:20px;top:718.7px;position:absolute;background:rgba(217,217,217,0.10);border-radius:15px;"></div>
    <img style="width:330px;height:85px;left:54px;top:744px;position:absolute;" src="{{ asset('dimages/emptylocation.png') }}">
    <button onclick="toggleLoginPopup(true)"
      style="border:none;background:none;padding:0;position:absolute;left:122px;top:846.26px;cursor:pointer;">
      <div class="w-48 h-9 bg-[#760000] rounded-[33px] flex justify-center items-center"
        style="transition:transform 0.15s ease;"
        onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
        onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
        ontouchend="this.style.transform='scale(1)'">
        <span class="text-white text-base font-semibold font-[Poppins]">PINPOINT NOW</span>
      </div>
    </button>

    <!-- History Tab -->
    <img src="{{ asset('dimages/historybutton.png') }}" alt="History Button" draggable="false"
      style="width:110px;height:50px;left:160px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
      onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
      onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'"
      onclick="window.location.href='{{ route('history') }}'">

    <!-- Menu Tab -->
    <img src="{{ asset('dimages/morebutton.png') }}" alt="More Button" draggable="false"
      style="width:110px;height:50px;left:290px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
      onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
      onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
      ontouchend="this.style.transform='scale(1)'"
      onclick="window.location.href='{{ route('menu') }}'">
  </div>

<!--------------------------------------------------------------------------  
| POPUP  
|-------------------------------------------------------------------------->  

<div id="loginPopup" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden justify-center items-center z-50 transition-opacity duration-300 opacity-0">
  <div id="popupBox" class="relative w-68 h-72 bg-slate-950 rounded-3xl flex flex-col items-center justify-between p-4 transform translate-y-full transition-transform duration-500 ease-[cubic-bezier(0.25,1,0.5,1)]">
    <img src="{{ asset('dimages/dashboardbutton.png') }}" alt="Logo" class="w-44 h-12 mt-4" />

    <!-- Initial State -->
    <div id="initialState" class="w-56">
      <div class="text-white text-xl font-bold font-[Poppins] mt-1 text-left leading-tight">No account yet?</div>
      <p class="text-white/60 text-xs font-normal font-[Poppins] text-left leading-snug mt-2">
        Uh-oh! It looks like you're not logged in to proceed with this action.
        Log in or sign up to access all available features.
      </p>
    </div>

    <!-- Login State -->
        <div id="loginState" class="w-56 hidden relative">
          <!-- Email Input -->
          <div class="relative mb-3 -mt-0">
            <input type="email" id="emailInput"
              class="credential-input w-full h-11 bg-[rgba(217,217,217,0.10)] rounded-[15px] border border-transparent px-4 text-gray-400 text-base font-[Poppins] font-normal focus:outline-none focus:border-gray-500 transition-colors placeholder-gray-400"
              placeholder="Email" autocomplete="email" />
          </div>

          <!-- Password Input -->
          <div class="relative -mt-2">
            <input type="password" id="passwordInput"
              class="credential-input w-full h-11 bg-[rgba(217,217,217,0.10)] rounded-[15px] border border-transparent px-4 text-gray-400 text-base font-[Poppins] font-normal focus:outline-none focus:border-gray-500 transition-colors placeholder-gray-400"
              placeholder="Password" autocomplete="current-password" />
          </div>

      <!-- Sign Up Text Button (hidden by default, one line, no layout shift) -->
      <div id="signupButton"
        style="
          width: 100%;
          text-align: center;
          display: flex;
          justify-content: center;
          align-items: center;
          gap: 4px;
          margin-top: 8px;
          margin-left: 25px;
          opacity: 0;
          pointer-events: none;
          transition: opacity 0.3s ease, transform 0.15s ease;
        "
        onmousedown="this.style.transform='scale(1.1)'"
        onmouseup="this.style.transform='scale(1)'"
        onmouseleave="this.style.transform='scale(1)'"
        ontouchstart="this.style.transform='scale(1.1)'"
        ontouchend="this.style.transform='scale(1)'"
        onclick="window.location.href='{{ route('signup') }}'">
        <span style="color: #FFE100; font-size: 9px; font-family: Poppins; font-weight: 500;">
          Don’t have an account yet?
        </span>
        <span style="color: #FFE100; font-size: 9px; font-family: Poppins; font-weight: 400; text-decoration: underline;">
          Sign Up
        </span>
      </div>
    </div>

    <!-- Continue/Login Button -->
    <div class="w-56 h-10 bg-[#760000] rounded-[33px] flex justify-center items-center cursor-pointer hover:scale-[1.03] transition"
      id="actionButton">
      <span class="text-white text-base font-bold font-[Poppins]">CONTINUE</span>
    </div>
  </div>
</div>

<!--------------------------------------------------------------------------  
| POPUP   
|-------------------------------------------------------------------------->  

<style>
  input:-webkit-autofill,
  input:-webkit-autofill:hover,
  input:-webkit-autofill:focus,
  input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0px 1000px rgba(217, 217, 217, 0) inset !important;
    -webkit-text-fill-color: #ffffff !important;
    caret-color: #ffffff !important;
    transition: background-color 9999s ease-in-out 0s !important;
  }

  /* Default gray placeholder text */
  .credential-input {
    color: #9ca3af;
    -webkit-text-fill-color: rgba(255,255,255,0.14);
  }

  /* When user types something */
  .credential-input.has-text {
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
  }

  .credential-input {
  font-size: 0.875rem !important; /* small */
  font-weight: 500 !important;    /* medium boldness */
}
</style>

<!--------------------------------------------------------------------------  
| POPUP SCRIPT  
|-------------------------------------------------------------------------->  

<script>
  function updateInputColors() {
    document.querySelectorAll('.credential-input').forEach(input => {
      if (input.value.trim() !== "") {
        input.classList.add('has-text');
      } else {
        input.classList.remove('has-text');
      }
    });
  }

  document.querySelectorAll('.credential-input').forEach(input => {
    input.addEventListener('input', updateInputColors);
  });

  window.addEventListener('load', () => {
    setTimeout(updateInputColors, 300);
  });
</script>

<script>
  const popup = document.getElementById('loginPopup'),
        box = document.getElementById('popupBox'),
        initialState = document.getElementById('initialState'),
        loginState = document.getElementById('loginState'),
        actionButton = document.getElementById('actionButton'),
        emailInput = document.getElementById('emailInput'),
        passwordInput = document.getElementById('passwordInput');

  function toggleLoginPopup(show) {
    if (show) {
      resetToInitialState();
      popup.style.display = 'flex';
      requestAnimationFrame(() => {
        popup.classList.remove('opacity-0');
        popup.classList.add('opacity-100');
        box.classList.remove('translate-y-full');
        box.classList.add('translate-y-0');
      });
    } else {
      popup.classList.remove('opacity-100');
      popup.classList.add('opacity-0');
      box.classList.remove('translate-y-0');
      box.classList.add('translate-y-full');
      setTimeout(() => {
        popup.style.display = 'none';
        resetToInitialState();
      }, 500);
    }
  }

  function resetToInitialState() {
    initialState.classList.remove('hidden');
    loginState.classList.add('hidden');
    emailInput.value = '';
    passwordInput.value = '';
    document.querySelectorAll('.credential-input').forEach(i => i.classList.remove('has-text'));
    actionButton.style.backgroundColor = '#760000';
    actionButton.style.pointerEvents = 'auto';
    actionButton.innerHTML = '<span class="text-white text-base font-bold font-[Poppins]">CONTINUE</span>';
    actionButton.onclick = switchToLoginForm;

    document.getElementById('signupButton').style.opacity = '0';
    document.getElementById('signupButton').style.pointerEvents = 'none';
  }

  function switchToLoginForm() {
    initialState.classList.add('hidden');
    loginState.classList.remove('hidden');
    document.getElementById('signupButton').style.opacity = '1';
    document.getElementById('signupButton').style.pointerEvents = 'auto';
    actionButton.style.backgroundColor = '#4B5563';
    actionButton.style.pointerEvents = 'none';
    actionButton.innerHTML = '<span class="text-white text-base font-bold font-[Poppins]">LOGIN</span>';
    actionButton.onclick = null;
    [emailInput, passwordInput].forEach(i => i.addEventListener('input', checkLoginForm));
  }

function checkLoginForm() {
  const e = emailInput.value.trim(),
        p = passwordInput.value.trim(),
        v = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e);

  if (v && p.length > 0) {
    actionButton.style.backgroundColor = '#760000';
    actionButton.style.pointerEvents = 'auto';
    actionButton.onclick = () => {
      if (e.endsWith('@admin.brufuel.bn')) {
        window.location.href = '{{ route('admin.dashboard') }}';
      } else if (e.endsWith('@driver.brufuel.bn')) {
        window.location.href = '{{ route('driver.dashboard') }}';
      } else {
        window.location.href = '{{ route('home') }}';
      }
    };
  } else {
    actionButton.style.backgroundColor = '#4B5563';
    actionButton.style.pointerEvents = 'none';
    actionButton.onclick = null;
  }
}

  popup.addEventListener('click', e => {
    if (e.target.id === 'loginPopup') toggleLoginPopup(false);
  });
</script>


</body>
</html>

