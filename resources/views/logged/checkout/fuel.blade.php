<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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

    <style>
    .fuel-card { transition: all 0.2s ease; }
    .fuel-card:hover { transform: scale(1.05); }
    </style>

</head>
<body>

    @php
        use Illuminate\Support\Facades\Auth;
        $selectedFuel = session('checkout.fuel.fuel_type') ?? null;
        $user = Auth::user();
    @endphp

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
       
        <!-- Dashboard button -->
        <img src="{{ asset('dimages/dashboardbutton.png') }}" alt="Dashboard Button" draggable="false"
            style="width:192px;height:52px;left:20px;top:78px;position:absolute;cursor:pointer;transition:transform 0.15s ease; z-index:20;"
            onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
            onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
            ontouchend="this.style.transform='scale(1)'" onclick="window.location.href='{{ route('user.home', ['username' => Auth::user()->name]) }}'">

    <!--------------------------------------------------------------------------
    | USER PROFILE PICTURE
    |-------------------------------------------------------------------------->
        <img src="{{ $user->profile_picture 
            ? asset('storage/' . $user->profile_picture) 
            : asset('images/default-profile.png') }}"
            alt="Profile Picture"
            draggable="false"
            style="width:40px;height:40px;left:371.85px;top:89.97px;position:absolute;
                border-radius:50%;object-fit:cover;cursor:pointer;
                transition:transform 0.15s ease; z-index:20;"
            onmousedown="this.style.transform='scale(1.1)'"
            onmouseup="this.style.transform='scale(1)'"
            onmouseleave="this.style.transform='scale(1)'"
            ontouchstart="this.style.transform='scale(1.1)'"
            ontouchend="this.style.transform='scale(1)'"
            onclick="
                const menu = document.getElementById('profileMenu');
                menu.classList.toggle('show');
                if (!menu.classList.contains('show')) {
                    setTimeout(() => menu.classList.add('hidden'), 250);
                } else {
                    menu.classList.remove('hidden');
                }
            ">

        <!-- Profile Dropdown Menu -->
        <div id="profileMenu" 
            class="hidden absolute right-6 top-35 bg-[#0B0F1F] border border-gray-700 rounded-2xl p-4 shadow-lg z-50 w-56 text-white text-sm"
            style="opacity:0; transform:translateY(-10px); transition:opacity 0.25s ease, transform 0.25s ease;">
            
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-profile.png') }}"
                    alt="Profile Picture"
                    style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                <div>
                    <div style="font-weight:600;font-size:13px;">{{ Auth::user()->name }}</div>
                    <div style="font-size:11px;color:#aaa;">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <hr style="border:none;border-top:1px solid rgba(255,255,255,0.1);margin:8px 0;">
            
            <!-- Upload new profile picture -->
            <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data" style="margin-top:12px;">
                @csrf
                <input type="file" name="profile_picture" accept="image/*"
                    style="width:100%;font-size:12px;color:#ccc;background:none;border:none;padding:4px 0;">
                <button type="submit"
                    style="width:100%;margin-top:8px;background:#323b53;color:white;border:none;padding:6px 0;border-radius:8px;
                        font-weight:500;cursor:pointer;">
                    Upload Picture
                </button>
            </form>
            
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="margin-top:8px;">
                @csrf
                <button type="submit"
                    style="width:100%;background:#760000;color:white;border:none;padding:8px 0;border-radius:8px;
                        font-weight:600;cursor:pointer;transition:transform 0.15s ease;"
                    onmousedown="this.style.transform='scale(0.95)'"
                    onmouseup="this.style.transform='scale(1)'">
                    Logout
                </button>
            </form>
        </div>

            <style>
        /* Profile dropdown animation */
        #profileMenu.show {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        /* Mobile-friendly adjustments */
        @media (max-width: 480px) {
            #profileMenu {
                right: 10px !important;
                top: 80px !important;
                width: 80% !important;
                font-size: 14px;
            }
            #profileMenu button {
                font-size: 14px !important;
                padding: 10px 0 !important;
            }
        }

        
    </style>

        <script>
        document.addEventListener('click', function (e) {
            const menu = document.getElementById('profileMenu');
            const profileImg = document.querySelector('img[alt="Profile Picture"]');

            // If the click is outside both the menu and the image, close it
            if (!menu.contains(e.target) && e.target !== profileImg) {
                if (menu.classList.contains('show')) {
                    menu.classList.remove('show');
                    setTimeout(() => menu.classList.add('hidden'), 250);
                }
            }
        });
    </script>
        


    <!--------------------------------------------------------------------------
    | OIL SELECTION
    |-------------------------------------------------------------------------->
 <div id="slideWrapper" class="slide-wrapper">
        <div style="position:absolute;top:155px;left:0;width:100%;height:calc(932px - 155px + 150px);background:rgba(217,217,217,0.74);opacity:0.07;border-radius:41px;bottom:-150px;"></div>

        <img src="{{ asset('checkout/oil.png') }}" alt="Image 50" draggable="false"
            style="top:192px; left:47px; width:40px;height:46px;position:absolute;">

        <div data-layer="Fuel delivered 24/7, the same price as the petrol station" class="FuelDelivered247TheSamePriceAsThePetrolStation w-64 h-12 left-[100px] top-[189px] absolute justify-center">
            <span class="text-white text-base font-semibold font-['Poppins']">Fuel delivered </span>
            <span class="text-yellow-400 text-base font-semibold font-['Poppins']">24/7</span>
            <span class="text-white text-base font-semibold font-['Poppins']">, the same price as the petrol station</span>
        </div>
        <div data-layer="choose your fuel type" class="ChooseYourFuelType w-36 h-3.5 left-[100px] top-[243px] absolute justify-center text-neutral-400 text-xs font-['Poppins']">choose your fuel type</div>

        <!-- Petrol Fuels Section -->
        <div data-layer="Petrol fuels" class="PetrolFuels w-24 h-4 left-[29px] top-[280px] absolute justify-center text-white text-base font-semibold font-['Poppins']">Petrol fuels</div>
      
        <!-- Diesel Fuels Section -->
        <div data-layer="Diesel fuels" class="DieselFuels w-24 h-4 left-[29px] top-[538px] absolute justify-center text-white text-base font-semibold font-['Poppins']">Diesel fuels</div>
        
        <!-- V-Power RON 97 -->
        <div id="vpower97" class="fuel-card w-28 h-48 left-[27px] top-[318px] absolute bg-zinc-300/10 rounded-[10px] cursor-pointer transition"
            onclick="selectFuel('vpower97', 'V-Power RON97')"></div>
        <img class="w-16 h-32 left-[52px] top-[340px] absolute pointer-events-none" src="{{ asset('checkout/rednozzle.png') }}">
        <div class="w-28 left-[27px] top-[474px] absolute text-center text-white text-[10px] font-bold font-['Poppins']">V-Power RON 97</div>
        <div class="w-9 h-3.5 left-[66px] top-[489px] absolute text-neutral-400 text-[9px] font-['Poppins']">B$0.88/L</div>

        <!-- Premium RON 97 -->
        <div id="premium97" class="fuel-card w-28 h-48 left-[157px] top-[318px] absolute bg-zinc-300/10 rounded-[10px] cursor-pointer transition"
            onclick="selectFuel('premium97', 'Premium RON97')"></div>
        <img class="w-16 h-32 left-[183px] top-[340px] absolute pointer-events-none" src="{{ asset('checkout/greennozzle.png') }}">
        <div class="w-28 left-[157px] top-[474px] absolute text-center text-white text-[10px] font-bold font-['Poppins']">Premium RON 97</div>
        <div class="w-9 h-3.5 left-[196px] top-[489px] absolute text-neutral-400 text-[9px] font-['Poppins']">B$0.53/L</div>

        <!-- Regular RON 85 -->
        <div id="regular85" class="fuel-card w-28 h-48 left-[287px] top-[318px] absolute bg-zinc-300/10 rounded-[10px] cursor-pointer transition"
            onclick="selectFuel('regular85', 'Regular RON85')"></div>
        <img class="w-16 h-32 left-[312px] top-[340px] absolute pointer-events-none" src="{{ asset('checkout/yellownozzle.png') }}">
        <div class="w-28 left-[287px] top-[474px] absolute text-center text-white text-[10px] font-bold font-['Poppins']">Regular RON 85</div>
        <div class="w-9 h-3.5 left-[326px] top-[489px] absolute text-neutral-400 text-[9px] font-['Poppins']">B$0.36/L</div>

        <!-- V-Power Diesel -->
        <div id="vpowerdiesel" class="fuel-card w-28 h-48 left-[27px] top-[576px] absolute bg-zinc-300/10 rounded-[10px] cursor-pointer transition"
            onclick="selectFuel('vpowerdiesel', 'V-Power Diesel')"></div>
        <img class="w-16 h-32 left-[52px] top-[598px] absolute pointer-events-none" src="{{ asset('checkout/greynozzle.png') }}">
        <div class="w-28 left-[27px] top-[732px] absolute text-center text-white text-[10px] font-bold font-['Poppins']">V-Power Diesel</div>
        <div class="w-9 h-3.5 left-[66px] top-[747px] absolute text-neutral-400 text-[9px] font-['Poppins']">B$0.95/L</div>

        <!-- Diesel -->
        <div id="diesel" class="fuel-card w-28 h-48 left-[157px] top-[576px] absolute bg-zinc-300/10 rounded-[10px] cursor-pointer transition"
            onclick="selectFuel('diesel', 'Diesel')"></div>
        <img class="w-16 h-32 left-[183px] top-[598px] absolute pointer-events-none" src="{{ asset('checkout/blacknozzle.png') }}">
        <div class="w-28 left-[157px] top-[732px] absolute text-center text-white text-[10px] font-bold font-['Poppins']">Diesel</div>
        <div class="w-8 h-3.5 left-[198px] top-[747px] absolute text-neutral-400 text-[9px] font-['Poppins']">B$0.31/L</div>

        <!-- Confirm Button -->
        <div id="confirmButton"
            class="absolute w-96 h-12 left-[27px] top-[850px] rounded-[33px] flex justify-center items-center cursor-not-allowed transition-all duration-200"
            style="background: #4B5563;">
        <span id="confirmBtnText" class="text-white text-base font-bold font-['Poppins'] opacity-50">
            CONFIRM FUEL
        </span>
        </div>

        <form id="fuelForm"
        method="POST"
        action="{{ route('user.checkout.fuel.store', ['username' => strtolower(Auth::user()->name)]) }}"
        style="display:none;">
        @csrf
        <input type="hidden" name="fuel_type" id="fuel_type_input">
        <input type="hidden" name="redirect_back" value="{{ request()->query('redirect_back') }}">
        </form>
        </div>
        <script>
        let selectedFuel = null;

        function selectFuel(id, label) {
            // remove highlight from all
            document.querySelectorAll('.fuel-card').forEach(card => {
            card.style.outline = 'none';
            card.style.boxShadow = 'none';
            card.style.background = 'rgba(255,255,255,0.05)';
            });

            // highlight selected
            const selected = document.getElementById(id);
            selected.style.outline = '2px solid #FFE100';
            selected.style.boxShadow = '0 0 12px #FFE100AA';
            selected.style.background = 'rgba(255,255,255,0.1)';
            selectedFuel = id;

            // activate confirm button
            const confirmBtn = document.getElementById('confirmButton');
            const confirmText = document.getElementById('confirmBtnText');
            confirmBtn.style.background = '#760000'; // red
            confirmBtn.style.cursor = 'pointer';
            confirmText.style.opacity = '1';
            confirmText.textContent = 'CONFIRM ' + label.toUpperCase();

           confirmBtn.onclick = () => {
    if (!selectedFuel) return;

    // Store selected label in the hidden input
    document.getElementById('fuel_type_input').value = label;
console.log("Submitting fuel type:", document.getElementById('fuel_type_input').value);
    // Submit the hidden form to save the fuel choice in session
    document.getElementById('fuelForm').submit();
};


            };
        </script>

        <style>
        .slide-wrapper {
            position: absolute;
            top: 932px; /* start off-screen below */
            left: 0;
            width: 100%;
            height: 932px;
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.9s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .slide-wrapper.show {
            top: 0; /* move into visible frame */
            opacity: 1;
            transform: translateY(0);
        }
        </style>

        <script>
        // Auto-highlight previously selected fuel from session
        window.addEventListener('load', () => {
            const previousFuel = @json($selectedFuel);
            if (previousFuel) {
                const fuelMap = {
                    "V-Power RON97": "vpower97",
                    "Premium RON97": "premium97",
                    "Regular RON85": "regular85",
                    "V-Power Diesel": "vpowerdiesel",
                    "Diesel": "diesel",
                };
                const id = fuelMap[previousFuel];
                if (id) selectFuel(id, previousFuel);
            }
        });
    </script>


        <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
            document.getElementById('slideWrapper').classList.add('show');
            }, 200);
        });
        </script>


    <!--------------------------------------------------------------------------
    | LOGOUT
    |-------------------------------------------------------------------------->

    <script>
        // If user is logged out but the browser cached this page, redirect home
        window.addEventListener("pageshow", function (event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                fetch('/debug-auth')
                    .then(r => r.json())
                    .then(d => {
                        if (!d.authenticated) {
                            window.location.href = '/login';
                        }
                    });
            }
        });
    </script>

</body>
</html>