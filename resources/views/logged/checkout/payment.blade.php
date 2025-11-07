<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BruFuel Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;650;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
</head>
<body>
@php
    $fuelData = session('checkout.fuel');
@endphp


    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp

    @php
    $fuelData = session('checkout.fuel.fuel_type') ?? 'Select fuel type';
    $locationData = session('checkout.location.address') ?? 'No location selected';
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

        <!--------------------------------------------------------------------------
        | OIL SELECTION
        |-------------------------------------------------------------------------->
        <div id="slideWrapper" class="slide-wrapper">


        <div data-layer="Rectangle 22" class="Rectangle22" style="width: 430px; height: 847px; left: 0px; top: 109px; position: absolute; opacity: 0.07; background: #D9D9D9"></div>
        <div data-layer="Checkout" class="Checkout" style="width: 102px; height: 17px; left: 165px; top: 76px; position: absolute; text-align: center; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 16px; font-family: Poppins; font-weight: 600; word-wrap: break-word">Checkout</div>
        <img data-layer="image 55" class="Image55" style="width: 30px; height: 15px; left: 24px; top: 76px; position: absolute" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAPCAYAAADzun+cAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAABvSURBVHgB7ZGhDYBADEX/OQQDMAZjINgJVmAOBIsgEGxyAll+kyoS5P2cuJe8NFUvaYEfzGylmY5QEVHnkYU/0QkKWrQkyaOcS+w3PSHAw5mzh5gUpz1oRy+6QYXH478Wp9fR4jXEZyiJ+E4HFOAFOE+2PdRH+wsAAAAASUVORK5CYII=" />
        <div data-layer="ORDER DETAILS*" class="OrderDetails" style="width: 159px; height: 16px; left: 39px; top: 135px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 15px; font-family: Poppins; font-weight: 700; word-wrap: break-word">ORDER DETAILS*</div>
        
        <!-- ✅ Fuel type input -->
        <div 
            style="
                width:182px;
                height:49px;
                left:30px;
                top:164px;
                position:absolute;
                background:rgba(217,217,217,0.06);
                border-radius:10px;
                display:flex;
                align-items:center;
                justify-content:left;
                padding:0 15px;
                box-sizing:border-box;
                overflow:hidden;
                cursor:pointer;
            "
            onclick="window.location.href='{{ route('user.checkout.fuel', ['username' => strtolower(Auth::user()->name)]) }}?redirect_back=payment'"
        >
            <span 
                style="
                    color:white;
                    font-size:12px;
                    font-family:'Poppins';
                    font-weight:400;
                    white-space:nowrap;
                    overflow:hidden;
                    text-overflow:ellipsis;
                    padding-left:25px;
                    max-width:100%;
                    text-align:center;
                "
            >
                {{ session('checkout.fuel.fuel_type') ?? 'Select fuel type' }}
            </span>
        </div>


        <div data-svg-wrapper data-layer="Vector" class="Vector" style="left: 41px; top: 184px; position: absolute">
        <svg width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M19.6841 1.98603L13.0123 3.95679L11.433 3.19293C11.1555 3.05575 10.8494 2.9851 10.5393 2.98669H8.76733V1.48188H10.5162C10.6477 1.4819 10.7739 1.43064 10.8676 1.33917C10.9613 1.2477 11.0149 1.12337 11.0169 0.993015V0.496508C11.0169 0.364826 10.9642 0.238537 10.8703 0.145423C10.7764 0.0523101 10.649 0 10.5162 0H5.52388C5.39107 0 5.26369 0.0523101 5.16978 0.145423C5.07587 0.238537 5.02311 0.364826 5.02311 0.496508V0.993015C5.02513 1.12337 5.07878 1.2477 5.17248 1.33917C5.26617 1.43064 5.39239 1.4819 5.52388 1.48188H7.27272V2.97141H5.52388L1.20955 2.20755H1.02465C0.894124 2.20347 0.764066 2.22495 0.641912 2.27074C0.519758 2.31653 0.407903 2.38574 0.312743 2.47441C0.217582 2.56309 0.140981 2.66949 0.0873184 2.78753C0.033656 2.90558 0.00398469 3.03295 0 3.16237V6.10323C0.00105618 6.3347 0.0830178 6.55865 0.231923 6.73693C0.380829 6.91521 0.587468 7.03679 0.816641 7.08097L2.99692 7.47053V8.90659C2.99691 9.16863 3.10137 9.42006 3.28753 9.60607C3.47369 9.79208 3.72646 9.89759 3.99075 9.8996H12.5963C12.7285 9.89918 12.8593 9.87261 12.981 9.82146C13.1027 9.7703 13.2129 9.69559 13.3051 9.6017L19.9306 2.96377C19.9758 2.91631 20.0007 2.85334 20 2.78808V2.23047C20 2.19217 19.9912 2.15438 19.9742 2.11997C19.9573 2.08556 19.9326 2.05543 19.9022 2.03187C19.8717 2.00831 19.8363 1.99194 19.7985 1.98399C19.7607 1.97605 19.7216 1.97675 19.6841 1.98603ZM3.02773 5.95809L1.54083 5.71366V3.75818L3.04314 4.02553L3.02773 5.95809ZM17.1726 8.57813C17.1586 8.7596 17.1826 8.94197 17.2431 9.11381C17.3036 9.28566 17.3992 9.44326 17.5239 9.57675C17.6487 9.71024 17.7999 9.81674 17.9682 9.88957C18.1364 9.96241 18.318 10 18.5015 10C18.6851 10 18.8667 9.96241 19.0349 9.88957C19.2031 9.81674 19.3543 9.71024 19.4791 9.57675C19.6039 9.44326 19.6995 9.28566 19.76 9.11381C19.8204 8.94197 19.8444 8.7596 19.8305 8.57813C19.8305 7.85246 18.5054 5.94282 18.5054 5.94282C18.5054 5.94282 17.1726 7.85246 17.1726 8.57813Z" fill="#FFE100"/>
        </svg>
        </div>

        <div data-layer="Rectangle 56" class="Rectangle56" style="width: 182px; height: 49px; left: 30px; top: 220px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 10px"></div>
        <div data-layer="Nissan Almera" class="NissanAlmera" style="width: 131px; height: 19px; left: 70px; top: 235px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 12px; font-family: Poppins; font-weight: 400; word-wrap: break-word">Nissan Almera</div>
        <div data-svg-wrapper data-layer="Vector" class="Vector" style="left: 42px; top: 237px; position: absolute">
        <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M15.9004 0.999984C15.7002 0.399891 15.1504 0 14.5 0H3.50002C2.84963 0 2.29983 0.399891 2.09962 0.999984L0 6.50002V14C0 14.5498 0.450188 15 0.999984 15H2.00002C2.54981 15 3 14.5498 3 14V13.5H15V14C15 14.5498 15.4502 15 16 15H17C17.5498 15 18 14.5498 18 14V6.50002L15.9004 0.999984ZM3.50002 10.5C2.65041 10.5 2.00002 9.85008 2.00002 9C2.00002 8.14992 2.65041 7.5 3.50002 7.5C4.34963 7.5 5.00002 8.14997 5.00002 9C5.00002 9.85003 4.34963 10.5 3.50002 10.5ZM14.5 10.5C13.6504 10.5 13 9.85008 13 9C13 8.14992 13.6504 7.5 14.5 7.5C15.3496 7.5 16 8.14997 16 9C16 9.85003 15.3496 10.5 14.5 10.5ZM2.00002 5.49998L3.50002 1.5H14.5L16 5.49998H2.00002Z" fill="#FFE100"/>
        </svg>
        </div>

            <div 
                style="
                    width:370px;
                    height:49px;
                    left:30px;
                    top:276px;
                    position:absolute;
                    background:rgba(217,217,217,0.06);
                    border-radius:10px;
                    display:flex;
                    align-items:center;
                    justify-content:left;
                    padding:0 15px;
                    box-sizing:border-box;
                    overflow:hidden;
                    cursor:pointer;
                "
                onclick="window.location.href='{{ route('user.checkout.location', ['username' => strtolower(Auth::user()->name)]) }}?redirect_back=payment'"
            >
                <span 
                    style="
                        color:white;
                        font-size:12px;
                        font-family:'Poppins';
                        font-weight:400;
                        white-space:nowrap;
                        overflow:hidden;
                        text-overflow:ellipsis;
                        padding-left:25px; /* shift text right */
                        max-width:100%;
                        text-align:center;
                    "
                >
                    {{ session('checkout.location.address') ?? 'Select your location' }}
                </span>
            </div>


         <div data-svg-wrapper data-layer="Icons" class="Icons" style="left: 45px; top: 293px; position: absolute">
        <svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 6C12 10.364 6.92313 15.491 6.70725 15.7071C6.51968 15.8946 6.26533 15.9999 6.00012 15.9999C5.73492 15.9999 5.48057 15.8946 5.293 15.7071C5.07688 15.4909 0 10.364 0 6C0 4.4087 0.632141 2.88258 1.75736 1.75736C2.88258 0.632141 4.4087 0 6 0C7.5913 0 9.11742 0.632141 10.2426 1.75736C11.3679 2.88258 12 4.4087 12 6ZM6 9C6.59334 9 7.17336 8.82405 7.66671 8.49441C8.16006 8.16476 8.54458 7.69623 8.77164 7.14805C8.9987 6.59987 9.05811 5.99667 8.94236 5.41473C8.8266 4.83279 8.54088 4.29824 8.12132 3.87868C7.70176 3.45912 7.16721 3.1734 6.58527 3.05764C6.00333 2.94189 5.40013 3.0013 4.85195 3.22836C4.30377 3.45542 3.83524 3.83994 3.50559 4.33329C3.17595 4.82664 3 5.40666 3 6C2.99998 6.39397 3.07757 6.78409 3.22833 7.14807C3.37909 7.51205 3.60006 7.84278 3.87864 8.12136C4.15722 8.39994 4.48795 8.62091 4.85193 8.77167C5.21591 8.92243 5.60603 9.00002 6 9Z" fill="#FFE100"/>
        </svg>
        </div>

        <!-- ✅ License Plate Box -->
        <div 
            style="
                width:182px;
                height:49px;
                left:218px;
                top:220px;
                position:absolute;
                background:rgba(217,217,217,0.06);
                border-radius:10px;
                display:flex;
                align-items:center;
                justify-content:left;
                overflow:hidden;
                cursor:pointer;
            "
            onclick="window.location.href='{{ route('user.checkout.vehicledetails', ['username' => strtolower(Auth::user()->name)]) }}?redirect_back=payment'"
        >
            <span 
                style="
                    color:white;
                    font-size:12px;
                    font-family:'Poppins';
                    font-weight:400;
                    white-space:nowrap;
                    overflow:hidden;
                    text-overflow:ellipsis;
                    padding-left:40px; /* shift text right */
                    text-align:center;
                    max-width:90%;
                "
            >
                @if(session('checkout.vehicle.license_plate'))
                    {{ session('checkout.vehicle.license_plate') }}
                @else
                    Add License Plate
                @endif
            </span>
        </div>


       <div data-svg-wrapper data-layer="Vector" class="Vector" style="left: 227px; top: 239px; position: absolute">
        <svg width="21" height="11" viewBox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M19.0385 0H1.26923C0.93261 0 0.609776 0.133722 0.371749 0.371749C0.133722 0.609776 0 0.93261 0 1.26923L0 9.73077C0 10.0674 0.133722 10.3902 0.371749 10.6283C0.609776 10.8663 0.93261 11 1.26923 11H19.0385C19.3751 11 19.6979 10.8663 19.9359 10.6283C20.174 10.3902 20.3077 10.0674 20.3077 9.73077V1.26923C20.3077 0.93261 20.174 0.609776 19.9359 0.371749C19.6979 0.133722 19.3751 0 19.0385 0ZM19.4615 9.73077C19.4615 9.84298 19.417 9.95059 19.3376 10.0299C19.2583 10.1093 19.1507 10.1538 19.0385 10.1538H1.26923C1.15702 10.1538 1.04941 10.1093 0.97007 10.0299C0.890728 9.95059 0.846154 9.84298 0.846154 9.73077V1.26923C0.846154 1.15702 0.890728 1.04941 0.97007 0.97007C1.04941 0.890728 1.15702 0.846154 1.26923 0.846154H19.0385C19.1507 0.846154 19.2583 0.890728 19.3376 0.97007C19.417 1.04941 19.4615 1.15702 19.4615 1.26923V9.73077Z" fill="#FFE100"/>
        </svg>
        </div>

        <div data-layer="Rectangle 59" class="Rectangle59" style="width: 182px; height: 49px; left: 218px; top: 164px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 10px"></div>
        <div data-layer="Select Price*" class="SelectPrice" style="width: 131px; height: 19px; left: 257px; top: 179px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: rgba(255, 255, 255, 0.22); font-size: 12px; font-family: Poppins; font-weight: 400; word-wrap: break-word">Select Price*</div>
        <div data-svg-wrapper data-layer="Price" class="Price" style="left: 229px; top: 180px; position: absolute">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.154 2.5563C8.39145 2.35839 8.69085 2.25 9 2.25C9.30915 2.25 9.60855 2.35839 9.846 2.55631L13.2302 5.3764C13.4012 5.51889 13.5 5.72998 13.5 5.95256V15C13.5 15.4142 13.1642 15.75 12.75 15.75H5.25C4.83579 15.75 4.5 15.4142 4.5 15V5.95256C4.5 5.72998 4.59887 5.51889 4.76987 5.3764L8.154 2.5563ZM9 0.75C8.33993 0.75 7.70078 0.981413 7.1937 1.40397L3.80959 4.22407C3.2966 4.65155 3 5.28481 3 5.95256V15C3 16.2427 4.00736 17.25 5.25 17.25H12.75C13.9927 17.25 15 16.2427 15 15V5.95256C15 5.28481 14.7034 4.65155 14.1905 4.22407L10.8063 1.40397C10.2992 0.981413 9.66008 0.75 9 0.75ZM9.75 6C9.75 5.58579 9.41423 5.25 9 5.25C8.58578 5.25 8.25 5.58582 8.25 6C7.00736 6 6 7.00736 6 8.25C6 9.49268 7.00736 10.5 8.25 10.5H9.75C10.1642 10.5 10.5 10.8358 10.5 11.25C10.5 11.6642 10.1642 12 9.75 12H7.5C7.08579 12 6.75 12.3358 6.75 12.75C6.75 13.1642 7.08579 13.5 7.5 13.5H8.25C8.25 13.9142 8.58578 14.2499 9 14.2499C9.41423 14.2499 9.75 13.9142 9.75 13.5C10.9927 13.5 12 12.4927 12 11.25C12 10.0073 10.9927 9 9.75 9H8.25C7.83578 9 7.5 8.66422 7.5 8.25C7.5 7.83578 7.83578 7.5 8.25 7.5H10.5C10.9142 7.5 11.25 7.16421 11.25 6.75C11.25 6.33579 10.9142 6 10.5 6H9.75Z" fill="#FFE100"/></svg></div>
        <div data-layer="Vector" class="Vector" style="width: 19.46px; height: 10.15px; left: 227.42px; top: 239.42px; position: absolute; background: rgba(51.35, 69.43, 88.27, 0)"></div>
        <div data-svg-wrapper data-layer="Vector" class="Vector" style="left: 228.27px; top: 239.42px; position: absolute">
        <svg width="19" height="10" viewBox="0 0 19 10" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18.6154 0.846154V9.30769H9.30769C6.8412 9.30099 4.47764 8.31821 2.73356 6.57413C0.98948 4.83005 0.00669943 2.46649 0 0H17.7692C17.9936 0 18.2089 0.0891483 18.3676 0.247833C18.5262 0.406518 18.6154 0.62174 18.6154 0.846154Z" fill="#585858" fill-opacity="0.25"/>
        </svg>
        </div>

        <div data-svg-wrapper data-layer="Vector" class="Vector" style="left: 229.12px; top: 241.12px; position: absolute">
        <svg width="17" height="8" viewBox="0 0 17 8" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.11539 0H1.26923C0.93261 0 0.609776 0.133722 0.371749 0.371749C0.133722 0.609776 0 0.93261 0 1.26923V2.96154C0 3.29816 0.133722 3.62099 0.371749 3.85902C0.609776 4.09705 0.93261 4.23077 1.26923 4.23077H2.11539C2.45201 4.23077 2.77484 4.09705 3.01287 3.85902C3.25089 3.62099 3.38462 3.29816 3.38462 2.96154V1.26923C3.38462 0.93261 3.25089 0.609776 3.01287 0.371749C2.77484 0.133722 2.45201 0 2.11539 0ZM1.26923 0.846154H2.11539L0.846154 2.53846V1.26923C0.846154 1.15702 0.890728 1.04941 0.970071 0.97007C1.04941 0.890728 1.15702 0.846154 1.26923 0.846154ZM2.11539 3.38462H1.26923L2.53846 1.69231V2.96154C2.53846 3.07375 2.49389 3.18136 2.41455 3.2607C2.3352 3.34004 2.22759 3.38462 2.11539 3.38462ZM10.5769 0H9.73077C9.39415 0 9.07132 0.133722 8.83329 0.371749C8.59526 0.609776 8.46154 0.93261 8.46154 1.26923V2.96154C8.46154 3.29816 8.59526 3.62099 8.83329 3.85902C9.07132 4.09705 9.39415 4.23077 9.73077 4.23077H10.5769C10.9135 4.23077 11.2364 4.09705 11.4744 3.85902C11.7124 3.62099 11.8462 3.29816 11.8462 2.96154V1.26923C11.8462 0.93261 11.7124 0.609776 11.4744 0.371749C11.2364 0.133722 10.9135 0 10.5769 0ZM9.73077 0.846154H10.5769L9.30769 2.53846V1.26923C9.30769 1.15702 9.35227 1.04941 9.43161 0.97007C9.51095 0.890728 9.61856 0.846154 9.73077 0.846154ZM10.5769 3.38462H9.73077L11 1.69231V2.96154C11 3.07375 10.9554 3.18136 10.8761 3.2607C10.7967 3.34004 10.6891 3.38462 10.5769 3.38462ZM5.5 2.53846H6.76923V3.80769C6.76923 3.9199 6.81381 4.02751 6.89315 4.10685C6.97249 4.1862 7.0801 4.23077 7.19231 4.23077C7.30452 4.23077 7.41213 4.1862 7.49147 4.10685C7.57081 4.02751 7.61539 3.9199 7.61539 3.80769V0.423077C7.61539 0.31087 7.57081 0.203259 7.49147 0.123916C7.41213 0.0445741 7.30452 0 7.19231 0C7.0801 0 6.97249 0.0445741 6.89315 0.123916C6.81381 0.203259 6.76923 0.31087 6.76923 0.423077V1.69231H5.5C5.38779 1.69231 5.28018 1.64773 5.20084 1.56839C5.1215 1.48905 5.07692 1.38144 5.07692 1.26923V0.423077C5.07692 0.31087 5.03235 0.203259 4.95301 0.123916C4.87367 0.0445741 4.76605 0 4.65385 0C4.54164 0 4.43403 0.0445741 4.35469 0.123916C4.27534 0.203259 4.23077 0.31087 4.23077 0.423077V1.26923C4.23077 1.60585 4.36449 1.92869 4.60252 2.16671C4.84055 2.40474 5.16338 2.53846 5.5 2.53846ZM15.6538 0.846154C15.7661 0.846154 15.8737 0.80158 15.953 0.722237C16.0324 0.642895 16.0769 0.535284 16.0769 0.423077C16.0769 0.31087 16.0324 0.203259 15.953 0.123916C15.8737 0.0445741 15.7661 0 15.6538 0H13.5385C13.3141 0 13.0988 0.0891483 12.9401 0.247833C12.7815 0.406518 12.6923 0.62174 12.6923 0.846154V1.69231C12.6923 1.91672 12.7815 2.13194 12.9401 2.29063C13.0988 2.44931 13.3141 2.53846 13.5385 2.53846H15.2308V3.38462H13.1154C13.0032 3.38462 12.8956 3.42919 12.8162 3.50853C12.7369 3.58787 12.6923 3.69549 12.6923 3.80769C12.6923 3.9199 12.7369 4.02751 12.8162 4.10685C12.8956 4.1862 13.0032 4.23077 13.1154 4.23077H15.2308C15.4552 4.23077 15.6704 4.14162 15.8291 3.98294C15.9878 3.82425 16.0769 3.60903 16.0769 3.38462V2.53846C16.0769 2.31405 15.9878 2.09883 15.8291 1.94014C15.6704 1.78146 15.4552 1.69231 15.2308 1.69231H13.5385V0.846154H15.6538ZM8.88462 5.92308H7.19231C7.0801 5.92308 6.97249 5.96765 6.89315 6.04699C6.81381 6.12634 6.76923 6.23395 6.76923 6.34615C6.76923 6.45836 6.81381 6.56597 6.89315 6.64531C6.97249 6.72466 7.0801 6.76923 7.19231 6.76923H8.88462C8.99682 6.76923 9.10444 6.72466 9.18378 6.64531C9.26312 6.56597 9.30769 6.45836 9.30769 6.34615C9.30769 6.23395 9.26312 6.12634 9.18378 6.04699C9.10444 5.96765 8.99682 5.92308 8.88462 5.92308ZM5.19962 5.62269L5.07692 5.74962L4.95423 5.62269C4.87456 5.54303 4.76651 5.49827 4.65385 5.49827C4.54118 5.49827 4.43313 5.54303 4.35346 5.62269C4.2738 5.70236 4.22904 5.81041 4.22904 5.92308C4.22904 6.03574 4.2738 6.14379 4.35346 6.22346L4.48039 6.34615L4.35346 6.46885C4.2738 6.54851 4.22904 6.65656 4.22904 6.76923C4.22904 6.8819 4.2738 6.98995 4.35346 7.06962C4.43313 7.14928 4.54118 7.19404 4.65385 7.19404C4.76651 7.19404 4.87456 7.14928 4.95423 7.06962L5.07692 6.94269L5.19962 7.06962C5.27928 7.14928 5.38734 7.19404 5.5 7.19404C5.61267 7.19404 5.72072 7.14928 5.80039 7.06962C5.88005 6.98995 5.92481 6.8819 5.92481 6.76923C5.92481 6.65656 5.88005 6.54851 5.80039 6.46885L5.67346 6.34615L5.80039 6.22346C5.88005 6.14379 5.92481 6.03574 5.92481 5.92308C5.92481 5.81041 5.88005 5.70236 5.80039 5.62269C5.72072 5.54303 5.61267 5.49827 5.5 5.49827C5.38734 5.49827 5.27928 5.54303 5.19962 5.62269ZM11.1227 5.62269L11 5.74962L10.8773 5.62269C10.8379 5.58325 10.791 5.55195 10.7395 5.53061C10.688 5.50926 10.6327 5.49827 10.5769 5.49827C10.5211 5.49827 10.4659 5.50926 10.4144 5.53061C10.3628 5.55195 10.316 5.58325 10.2765 5.62269C10.2371 5.66214 10.2058 5.70897 10.1845 5.76051C10.1631 5.81205 10.1521 5.86729 10.1521 5.92308C10.1521 5.97886 10.1631 6.0341 10.1845 6.08564C10.2058 6.13718 10.2371 6.18401 10.2765 6.22346L10.4035 6.34615L10.2765 6.46885C10.1969 6.54851 10.1521 6.65656 10.1521 6.76923C10.1521 6.8819 10.1969 6.98995 10.2765 7.06962C10.3562 7.14928 10.4643 7.19404 10.5769 7.19404C10.6896 7.19404 10.7976 7.14928 10.8773 7.06962L11 6.94269L11.1227 7.06962C11.2024 7.14928 11.3104 7.19404 11.4231 7.19404C11.5357 7.19404 11.6438 7.14928 11.7235 7.06962C11.8031 6.98995 11.8479 6.8819 11.8479 6.76923C11.8479 6.65656 11.8031 6.54851 11.7235 6.46885L11.5965 6.34615L11.7235 6.22346C11.8031 6.14379 11.8479 6.03574 11.8479 5.92308C11.8479 5.81041 11.8031 5.70236 11.7235 5.62269C11.6438 5.54303 11.5357 5.49827 11.4231 5.49827C11.3104 5.49827 11.2024 5.54303 11.1227 5.62269Z" fill="#FFE100"/>
        </svg>
        </div>

        <div data-layer="CARD INFORMATION" class="CardInformation" style="width: 159px; height: 16px; left: 39px; top: 353px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 15px; font-family: Poppins; font-weight: 700; word-wrap: break-word">CARD INFORMATION</div>
        <div data-layer="Rectangle 27" class="Rectangle27" style="width: 370px; height: 237px; left: 30px; top: 389px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 10px"></div>
        <div data-layer="Credit/Debit Card" class="CreditDebitCard" style="width: 162.07px; height: 18.74px; left: 70px; top: 404px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 14px; font-family: Poppins; font-weight: 600; word-wrap: break-word">Credit/Debit Card</div>

            <div data-layer="Card Number" class="CardNumber" style="width: 191.11px; height: 13.38px; left: 61.37px; top: 437px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A6A6A6; font-size: 11px; font-family: Poppins; font-weight: 400; word-wrap: break-word">Card Number</div>
            <!-- Card Number -->
            <input type="text" 
                placeholder="1234 5678 1234 5678"
                maxlength="19"
                class="absolute left-[55px] top-[455px] w-[326.01px] h-[33.01px] 
                    bg-[rgba(217,217,217,0.06)] rounded-[14px] 
                    text-[11px] font-medium text-white font-['Poppins'] 
                    placeholder:text-[rgba(177,177,177,0.4)] px-3 outline-none
           tracking-widest" />

           <div data-layer="Name on Card" class="NameOnCard" style="width: 191.11px; height: 13.38px; left: 61.37px; top: 494.11px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A6A6A6; font-size: 11px; font-family: Poppins; font-weight: 400; word-wrap: break-word">Name on Card</div>
            <!-- Cardholder Name -->
            <input type="text" 
                placeholder="Muhammad Ali"
                class="absolute left-[55px] top-[513px] w-[326.01px] h-[33.01px] 
                    bg-[rgba(217,217,217,0.06)] rounded-[14px]
                    text-[11px] font-medium text-white font-['Poppins']
                    placeholder:text-[rgba(177,177,177,0.4)] px-3 outline-none" />

            <div data-layer="Expiry Date" class="ExpiryDate" style="width: 74.94px; height: 14.28px; left: 60.43px; top: 553.12px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A5A5A5; font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">Expiry Date</div>
            <!-- Expiry (MM/YY) -->
            <input type="text" 
                placeholder="01/25"
                maxlength="5"
                class="absolute left-[55px] top-[575px] w-[154.57px] h-[33.01px]
                    bg-[rgba(217,217,217,0.06)] rounded-[14px]
                    text-[11px] font-medium text-white font-['Poppins']
                    placeholder:text-[rgba(177,177,177,0.4)] px-3 outline-none" />

            <div data-layer="CVV Code" class="CvvCode" style="width: 74.94px; height: 14.28px; left: 228.12px; top: 553.12px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A5A5A5; font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">CVV Code</div>
            <!-- CVV -->
            <input type="text" 
                placeholder="123"
                maxlength="3"
                class="absolute left-[225px] top-[575px] w-[154.57px] h-[33.01px]
                    bg-[rgba(217,217,217,0.06)] rounded-[14px]
                    text-[11px] font-medium text-white font-['Poppins']
                    placeholder:text-[rgba(177,177,177,0.4)] px-3 outline-none" />

            <div data-layer="Rectangle 55" class="Rectangle55" style="width: 370px; height: 49px; left: 30px; top: 635px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 10px"></div>
            <div data-layer="Cash" class="Cash" style="width: 162.07px; height: 18.74px; left: 70px; top: 650px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 14px; font-family: Poppins; font-weight: 600; word-wrap: break-word">Cash</div>
   
            <!-- ✅ Ellipse 3 (movable small circle) -->
            <div id="ellipse3"
                style="left:51px; top:409px; position:absolute; z-index:5; cursor:pointer;">
            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="4" cy="4" r="4" fill="#D9D9D9"/>
            </svg>
            </div>

            <!-- ✅ First Group (top area 406/407) -->
            <div id="groupTop" style="position:absolute; left:48px; top:406px; width:20px; height:20px; cursor:pointer; z-index:3;">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                xmlns="http://www.w3.org/2000/svg" style="position:absolute; left:0; top:0;">
                <circle cx="7" cy="7" r="7" fill="#D9D9D9"/>
            </svg>
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                xmlns="http://www.w3.org/2000/svg" style="position:absolute; left:1px; top:1px;">
                <circle cx="6" cy="6" r="6" fill="#1B2330"/>
            </svg>
            </div>

            <!-- ✅ Second Group (bottom area 652/653) -->
            <div id="groupBottom" style="position:absolute; left:48px; top:652px; width:20px; height:20px; cursor:pointer; z-index:3;">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                xmlns="http://www.w3.org/2000/svg" style="position:absolute; left:0; top:0;">
                <circle cx="7" cy="7" r="7" fill="#D9D9D9"/>
            </svg>
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                xmlns="http://www.w3.org/2000/svg" style="position:absolute; left:1px; top:1px;">
                <circle cx="6" cy="6" r="6" fill="#1B2330"/>
            </svg>
            </div>

            <div data-layer="Rectangle 55" class="Rectangle55"
                style="position:absolute; width:430px; height:2px; background:rgba(217,217,217,0.20);
                        top:760px; border-radius:14px;"></div>

            <div data-layer="+Service Charge" class="ServiceCharge" style="width: 110px; height: 14px; left: 55px; top: 822px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A5A5A5; font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">+Service Charge</div>
            <div data-layer="+B$5" class="B5" style="width: 34px; height: 14px; left: 344px; top: 822px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A5A5A5; font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">+B$5</div>
            <div data-layer="Total" class="Total" style="width: 63px; height: 20px; left: 56px; top: 791px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 24px; font-family: Poppins; font-weight: 600; word-wrap: break-word">Total</div>
            <div data-layer="B$40" class="B40" style="width: 63px; height: 20px; left: 318px; top: 791px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 24px; font-family: Poppins; font-weight: 600; word-wrap: break-word">B$40</div>

            <!-- Confirm Button -->
            <div id="confirmButton"
            class="absolute w-96 h-12 left-[27px] top-[850px] rounded-[33px] flex justify-center items-center cursor-not-allowed transition-all duration-200"
            style="background:#4B5563;">
            <span id="confirmBtnText" class="text-white text-base font-bold font-['Poppins'] opacity-50">
                PAY NOW (B$45)
            </span>
            </div>

            <script>
            const ellipse3 = document.getElementById('ellipse3');
            const topGroup = document.getElementById('groupTop');
            const bottomGroup = document.getElementById('groupBottom');

            function moveCircle(topValue) {
                // Instantly move (no animation)
                ellipse3.style.transition = 'none';
                ellipse3.style.top = `${topValue}px`;
            }

            topGroup.addEventListener('click', () => moveCircle(409)); // move to top
            bottomGroup.addEventListener('click', () => moveCircle(655)); // move to bottom
            </script>



        <script>
        document.querySelectorAll('input[placeholder="1234 5678 1234 5678"]').forEach(input => {
        input.addEventListener('input', e => {
            e.target.value = e.target.value
            .replace(/\D/g, '')             // digits only
            .replace(/(.{4})/g, '$1 ')      // space every 4 digits
            .trim();
        });
        });
        </script>

        <script>
            window.addEventListener('load', () => {
                setTimeout(() => {
                    document.getElementById('slideWrapper').classList.add('show');
                }, 200);
            });
        </script>

        <script>
            // Watch all input fields
            const inputs = document.querySelectorAll('input[type="text"]');
            const confirmBtn = document.getElementById('confirmButton');
            const confirmText = document.getElementById('confirmBtnText');

            function checkInputs() {
                // Check if all inputs have a value
                const allFilled = Array.from(inputs).every(input => input.value.trim() !== "");

                if (allFilled) {
                    // Enable confirm button
                    confirmBtn.style.background = "#760000";
                    confirmBtn.style.cursor = "pointer";
                    confirmText.style.opacity = "1";

                    // Add click behavior (change to route if you want)
                    confirmBtn.onclick = () => {
                        onclick="window.location.href='{{ route('user.checkout.reset', ['username' => strtolower(Auth::user()->name)]) }}'"

                    };
                } else {
                    // Disable confirm button
                    confirmBtn.style.background = "#4B5563";
                    confirmBtn.style.cursor = "not-allowed";
                    confirmText.style.opacity = "0.5";
                    confirmBtn.onclick = null; // disable click
                }
            }

            // Trigger on each input change
            inputs.forEach(input => input.addEventListener('input', checkInputs));
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
        </div>
    </div>
</body>
</html>