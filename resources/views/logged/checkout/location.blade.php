<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>BruFuel Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;650;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        * { 
            user-select: none; 
            -webkit-user-drag: none; 
            user-drag: none; 
        }
        
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
        
        .fuel-card { 
            transition: all 0.2s ease; 
        }
        
        .fuel-card:hover { 
            transform: scale(1.05); 
        }
        
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
        
        select option {
            background-color: #0B0F1F; /* same dark as profile menu */
            color: white;
            border-radius: 10px;
            padding: 8px;
        }

        /* Hide dropdown caret completely for modern flat look */
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none !important;
        }
    </style>

    <style>
        #map {
            width: 335px;
            height: 200px;
            border-radius: 18px;
        }
    </style>
</head>
<body>
    @php
        use Illuminate\Support\Facades\Auth;
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
        <img src="{{ asset('dimages/dashboardbutton.png') }}" 
             alt="Dashboard Button" 
             draggable="false"
             style="width:192px;height:52px;left:20px;top:78px;position:absolute;cursor:pointer;transition:transform 0.15s ease; z-index:20;"
             onmousedown="this.style.transform='scale(1.1)'" 
             onmouseup="this.style.transform='scale(1)'"
             onmouseleave="this.style.transform='scale(1)'" 
             ontouchstart="this.style.transform='scale(1.1)'"
             ontouchend="this.style.transform='scale(1)'" 
             onclick="window.location.href='{{ route('user.home', ['username' => Auth::user()->name]) }}'">

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
                    <div style="font-size:11px;color:#aaa;max-width:130px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</div>
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
            <!-- Fixed background div -->
            <div style="position:absolute;top:155px;left:0;width:100%;height:calc(932px - 155px + 150px);background:rgba(217,217,217,0.74);opacity:0.07;border-radius:41px;bottom:-150px;"></div>

            <img src="{{ asset('checkout/location.png') }}" 
                 alt="Image 50" 
                 draggable="false"
                 style="top:193px; left:27px; width:38px;height:38px;position:absolute;">

            <!-- Vehicle details heading -->
            <div style="position:absolute;left:80px;top:190px;width:340px;">
                <div style="color:#fff;font-size:15px;font-weight:600;font-family:Poppins;">
                    Pin it here, get fueled there - no station required 
                </div>
                <div style="color:#A6A6A6;font-size:12px;font-weight:300;margin-top:6px;">
                    Pin your location
                </div>
            </div>

            <!-- LOCATION INPUT COMPONENT -->
            <div style="position:absolute;left:50px;top:340px;width:348px;">
                <div id="map" 
                    style="position:absolute;left:0;top:0;
                            width:335px;height:200px;
                            border-radius:18px;overflow:hidden;">
                </div>
                
                <!-- Input Box (below map) -->
                <div style="position:absolute;top:220px;left:0;width:335px;
                            height:37px;background:rgba(217,217,217,0.06);
                            border-radius:14px;display:flex;align-items:center;
                            padding:0 15px;">
                    <input id="addressBox" readonly placeholder="Anywhere"
                        style="background:transparent;border:none;outline:none;width:100%;
                                color:rgba(177,177,177,0.7);font-size:11px;font-family:Poppins;">
                </div>
            </div>
        </div>

        <!-- Confirm Button -->
        <div id="confirmButton"
            class="absolute w-96 h-12 left-[27px] top-[850px] rounded-[33px] flex justify-center items-center cursor-not-allowed transition-all duration-200"
            style="background: #4B5563;">
            <span id="confirmBtnText" class="text-white text-base font-bold font-['Poppins'] opacity-50">
                CONFIRM LOCATION
            </span>
        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('slideWrapper').classList.add('show');
            }, 200);
        });
    </script>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addressBox = document.getElementById('addressBox');
            const confirmBtn = document.getElementById('confirmButton');
            const confirmText = document.getElementById('confirmBtnText');

            window.updateConfirmButton = function() {
                if (addressBox.value.trim() !== "") {
                confirmBtn.style.background = "#760000"; // 🔴 red
                confirmBtn.style.cursor = "pointer";
                confirmText.style.opacity = "1";
                confirmBtn.onclick = () => {
                const urlParams = new URLSearchParams(window.location.search);
                const redirectBack = urlParams.get("redirect_back");

                if (redirectBack === "payment") {
                    window.location.href = "{{ route('user.checkout.payment', ['username' => strtolower(Auth::user()->name)]) }}";
                } else {
                    window.location.href = "{{ route('user.checkout.vehicledetails', ['username' => strtolower(Auth::user()->name)]) }}";
                }
            };

                } else {
                confirmBtn.style.background = "#4B5563"; // grey
                confirmBtn.style.cursor = "not-allowed";
                confirmText.style.opacity = "0.5";
                confirmBtn.onclick = null;
                }
            };

            // optional live watch
            addressBox.addEventListener('input', updateConfirmButton);
            updateConfirmButton();
            });
         </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const map = L.map('map').setView([4.5353, 114.7277], 13); // Brunei area example

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            let marker;
            const addressBox = document.getElementById('addressBox');
            map.on('click', async (e) => {
                if (marker) map.removeLayer(marker);
                marker = L.marker(e.latlng).addTo(map);

                const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${e.latlng.lat}&lon=${e.latlng.lng}`;
                const res = await fetch(url);
                const data = await res.json();
                addressBox.value = data.display_name || `${e.latlng.lat.toFixed(5)}, ${e.latlng.lng.toFixed(5)}`;
                addressBox.style.color = "white";

                // ✅ Trigger the confirm button update manually
                if (typeof updateConfirmButton === 'function') updateConfirmButton();
                fetch("{{ route('user.checkout.location.save', ['username' => strtolower(Auth::user()->name)]) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({ address: addressBox.value })
            });
            });
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