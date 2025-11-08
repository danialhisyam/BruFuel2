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
        <div style="position:absolute;top:155px;left:0;width:100%;height:calc(932px - 155px + 150px);background:rgba(217,217,217,0.74);opacity:0.07;border-radius:41px;bottom:-150px;"></div>

        <!-- Dashboard button -->
        <img src="{{ asset('dimages/dashboardbutton.png') }}" alt="Dashboard Button" draggable="false"
            style="width:192px;height:52px;left:20px;top:78px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
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
                transition:transform 0.15s ease;"
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
        | TABS
        |-------------------------------------------------------------------------->

        <!-- Home Tab -->
        <img src="{{ asset('himages/homebutton2.png') }}" alt="Home Button" draggable="false"
            style="width:110px;height:50px;left:30px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
            onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
            onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
            ontouchend="this.style.transform='scale(1)'"
            onclick="window.location.href='{{ route('user.home', ['username' => Auth::user()->name]) }}'">

        <!-- History Tab -->
        <img src="{{ asset('dimages/historybutton.png') }}" alt="History Button" draggable="false"
            style="width:110px;height:50px;left:160px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
            onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
            onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
            ontouchend="this.style.transform='scale(1)'"
            onclick="window.location.href='{{ route('user.history', ['username' => Auth::user()->name]) }}'">

        <!-- Menu Tab -->
        <img src="{{ asset('mimages/menubutton2.png') }}" alt="More Button" draggable="false"
            style="width:110px;height:50px;left:290px;top:180px;position:absolute;cursor:pointer;transition:transform 0.15s ease;"
            onmousedown="this.style.transform='scale(1.1)'" onmouseup="this.style.transform='scale(1)'"
            onmouseleave="this.style.transform='scale(1)'" ontouchstart="this.style.transform='scale(1.1)'"
            ontouchend="this.style.transform='scale(1)'"
            onclick="window.location.href='{{ route('user.menu', ['username' => Auth::user()->name]) }}'">

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

        <!-- 🧹 Report (Session Killer) -->
        <form action="{{ route('user.session.reset') }}" method="POST"
            style="position:absolute;left:24px;top:560px;cursor:pointer;transition:transform 0.15s ease;">
            @csrf
            <button type="submit"
                style="all:unset;display:block;width:383px;height:47px;position:relative;cursor:pointer;">
                <div style="width:383px;height:47px;background:rgba(217,217,217,0.13);border-radius:15px;"></div>
                <div style="position:absolute;left:60px;top:13px;color:white;font-size:15px;
                            font-family:Poppins;font-weight:600;">Report</div>
                <img src="{{ asset('mimages/report.png') }}" alt="icon"
                    width="20" height="20"
                    style="position:absolute;left:20px;top:13px;">
            </button>
        </form>


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