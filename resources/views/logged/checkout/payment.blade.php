<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
        
        .slide-wrapper {
            position: absolute;
            top: 932px;
            left: 0;
            width: 100%;
            height: 932px;
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.9s cubic-bezier(0.25, 1, 0.5, 1);
        }
        
        .slide-wrapper.show {
            top: 0;
            opacity: 1;
            transform: translateY(0);
        }
        
        select option {
            background-color: #0B0F1F;
            color: white;
            border-radius: 10px;
            padding: 8px;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none !important;
        }

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

    <div id="frame" style="position:relative;width:430px;height:932px;background:#000919;transform-origin:center center;">
        <div style="width:501px;height:993px;left:-42px;top:0;position:absolute;background:#000919;box-shadow:0 4px 4px rgba(0,0,0,0.25);z-index:0;"></div>

<div data-layer="iPhone 14 & 15 Pro Max - 39" class="Iphone1415ProMax39" style="width: 100%; height: 100%; position: relative; background: white; overflow: hidden">
    <div data-layer="Background" class="Background" style="width: 501px; height: 993px; left: -42px; top: 0px; position: absolute; background: #000919; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)"></div>
    <div data-layer="Rectangle 22" class="Rectangle22" style="width: 430px; height: 847px; left: 0px; top: 109px; position: absolute; opacity: 0.07; background: #D9D9D9"></div>
    <div data-layer="Checkout" class="Checkout" style="width: 102px; height: 17px; left: 165px; top: 76px; position: absolute; text-align: center; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 16px; font-family: Poppins; font-weight: 600; word-wrap: break-word">Checkout</div>
    <img data-layer="image 55" class="Image55" style="width: 30px; height: 15px; left: 24px; top: 76px; position: absolute" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAPCAYAAADzun+cAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAABvSURBVHgB7ZGhDYBADEX/OQQDMAZjINgJVmAOBIsgEGxyAll+kyoS5P2cuJe8NFUvaYEfzGylmY5QEVHnkYU/0QkKWrQkyaOcS+w3PSHAw5mzh5gUpz1oRy+6QYXH478Wp9fR4jXEZyiJ+E4HFOAFOE+2PdRH+wsAAAAASUVORK5CYII=" />
    <div data-layer="ORDER DETAILS" class="OrderDetails" style="width: 159px; height: 16px; left: 39px; top: 135px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 15px; font-family: Poppins; font-weight: 700; word-wrap: break-word">ORDER DETAILS</div>
    <div data-layer="Rectangle 27" class="Rectangle27" style="width: 181px; height: 91px; left: 30px; top: 171px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 10px"></div>
    <img data-layer="rednozzle 1" class="Rednozzle1" style="width: 35.07px; height: 68.86px; left: 50px; top: 182px; position: absolute" src="data:image/png;base64,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" />
    <div data-layer="Select price*" class="SelectPrice" style="width: 69px; height: 14px; left: 102px; top: 219px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 9px; font-family: Poppins; font-weight: 400; word-wrap: break-word">Select price*</div>
    <div data-layer="Fuel Type" class="FuelType" style="width: 69px; height: 14px; left: 102px; top: 180px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 9px; font-family: Poppins; font-weight: 400; word-wrap: break-word">Fuel Type</div>
    <div data-layer="Rectangle 54" class="Rectangle54" style="width: 89px; height: 19px; left: 104px; top: 195px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 3px"></div>
    <div data-layer="Petrol V-Power RON 97" class="PetrolVPowerRon97" style="width: 81px; height: 12px; left: 108px; top: 199px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #FFE100; font-size: 7px; font-family: Poppins; font-weight: 500; word-wrap: break-word">Petrol V-Power RON 97</div>
    <div data-svg-wrapper data-layer="Rectangle 55" class="Rectangle55" style="left: 104px; top: 233px; position: absolute">
        <svg width="48" height="20" viewBox="0 0 48 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="48" height="20" rx="3" fill="#D9D9D9" fill-opacity="0.06"/>
        </svg>
    </div>
    <div data-layer="B$40" class="B40" style="width: 38px; height: 12px; left: 109px; top: 237px; position: absolute; text-align: center; justify-content: center; display: flex; flex-direction: column; color: #FFE100; font-size: 10px; font-family: Poppins; font-weight: 500; word-wrap: break-word">B$40</div>
    <div data-layer="Rectangle 27" class="Rectangle27" style="width: 370px; height: 237px; left: 30px; top: 318px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 10px"></div>
    <div data-layer="Credit/Debit Card" class="CreditDebitCard" style="width: 162.07px; height: 18.74px; left: 70px; top: 333px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 14px; font-family: Poppins; font-weight: 600; word-wrap: break-word">Credit/Debit Card</div>
    <div data-layer="Rectangle 53" class="Rectangle53" style="width: 326.01px; height: 33.01px; left: 52px; top: 383.97px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 14px"></div>
    <div data-layer="1234 5678 1234 5678" class="567812345678" style="width: 299.78px; height: 16.95px; left: 66.05px; top: 392px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: rgba(177.76, 177.76, 177.76, 0.11); font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">1234 5678 1234 5678</div>
    <div data-layer="Card Number" class="CardNumber" style="width: 191.11px; height: 13.38px; left: 61.37px; top: 366px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A6A6A6; font-size: 11px; font-family: Poppins; font-weight: 400; word-wrap: break-word">Card Number</div>
    <div data-layer="Rectangle 54" class="Rectangle54" style="width: 326.01px; height: 33.01px; left: 52px; top: 441.08px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 14px"></div>
    <div data-layer="Muhammad Ali" class="MuhammadAli" style="width: 299.78px; height: 16.95px; left: 66.05px; top: 449.11px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: rgba(177.76, 177.76, 177.76, 0.11); font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">Muhammad Ali</div>
    <div data-layer="Name on Card" class="NameOnCard" style="width: 191.11px; height: 13.38px; left: 61.37px; top: 423.11px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A6A6A6; font-size: 11px; font-family: Poppins; font-weight: 400; word-wrap: break-word">Name on Card</div>
    <div data-layer="Rectangle 49" class="Rectangle49" style="width: 154.57px; height: 33.01px; left: 223.43px; top: 503.54px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 14px"></div>
    <div data-layer="123" style="width: 129.28px; height: 16.95px; left: 236.55px; top: 511.57px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: rgba(177.76, 177.76, 177.76, 0.11); font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">123</div>
    <div data-layer="Expiry Date" class="ExpiryDate" style="width: 74.94px; height: 14.28px; left: 60.43px; top: 482.12px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A5A5A5; font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">Expiry Date</div>
    <div data-layer="CVV Code" class="CvvCode" style="width: 74.94px; height: 14.28px; left: 228.12px; top: 482.12px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A5A5A5; font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">CVV Code</div>
    <div data-layer="Rectangle 48" class="Rectangle48" style="width: 154.57px; height: 33.01px; left: 52.94px; top: 503.54px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 14px"></div>
    <div data-layer="01/25" class="25" style="width: 129.28px; height: 16.95px; left: 66.05px; top: 511.57px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: rgba(177.76, 177.76, 177.76, 0.11); font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">01/25</div>
    <div data-layer="Rectangle 27" class="Rectangle27" style="width: 181px; height: 91px; left: 219px; top: 171px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 10px"></div>
    <div data-layer="Vehicle Model" class="VehicleModel" style="width: 69px; height: 14px; left: 291px; top: 219px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 9px; font-family: Poppins; font-weight: 400; word-wrap: break-word">Vehicle Model</div>
    <div data-layer="License Plate" class="LicensePlate" style="width: 69px; height: 14px; left: 291px; top: 180px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 9px; font-family: Poppins; font-weight: 400; word-wrap: break-word">License Plate</div>
    <div data-layer="Rectangle 54" class="Rectangle54" style="width: 89px; height: 19px; left: 293px; top: 195px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 3px"></div>
    <div data-layer="Rectangle 55" class="Rectangle55" style="width: 89px; height: 19px; left: 293px; top: 233px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 3px"></div>
    <div data-layer="BAA 1234" class="Baa1234" style="width: 81px; height: 12px; left: 297px; top: 199px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #FFE100; font-size: 7px; font-family: Poppins; font-weight: 500; word-wrap: break-word">BAA 1234</div>
    <div data-layer="Koenigsegg Hilux" class="KoenigseggHilux" style="width: 81px; height: 12px; left: 297px; top: 237px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #FFE100; font-size: 7px; font-family: Poppins; font-weight: 500; word-wrap: break-word">Koenigsegg Hilux</div>
    <img data-layer="Adobe Express - file 1" class="AdobeExpressFile1" style="width: 49.21px; height: 69.70px; left: 232px; top: 182px; position: absolute" src="data:image/png;base64,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" />
    <div data-layer="CARD INFORMATION" class="CardInformation" style="width: 159px; height: 16px; left: 39px; top: 282px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 15px; font-family: Poppins; font-weight: 700; word-wrap: break-word">CARD INFORMATION</div>
    <div data-svg-wrapper data-layer="Ellipse 1" class="Ellipse1" style="left: 48px; top: 335px; position: absolute">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="7" cy="7" r="7" fill="#D9D9D9"/>
        </svg>
    </div>
    <div data-svg-wrapper data-layer="Ellipse 2" class="Ellipse2" style="left: 49px; top: 336px; position: absolute">
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="6" cy="6" r="6" fill="#1B2330"/>
        </svg>
    </div>
    <div data-svg-wrapper data-layer="Ellipse 1" class="Ellipse1" style="left: 48px; top: 592px; position: absolute">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="7" cy="7" r="7" fill="#D9D9D9"/>
        </svg>
    </div>
    <div data-svg-wrapper data-layer="Ellipse 2" class="Ellipse2" style="left: 49px; top: 593px; position: absolute">
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="6" cy="6" r="6" fill="#1B2330"/>
        </svg>
    </div>
    <div data-layer="Rectangle 55" class="Rectangle55" style="width: 370px; height: 49px; left: 30px; top: 575px; position: absolute; background: rgba(217, 217, 217, 0.06); border-radius: 10px"></div>
    <div data-layer="Cash" class="Cash" style="width: 162.07px; height: 18.74px; left: 70px; top: 590px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 14px; font-family: Poppins; font-weight: 600; word-wrap: break-word">Cash</div>
    <div data-layer="+Service Charge" class="ServiceCharge" style="width: 110px; height: 14px; left: 55px; top: 822px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A5A5A5; font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">+Service Charge</div>
    <div data-layer="+B$5" class="B5" style="width: 34px; height: 14px; left: 344px; top: 822px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: #A5A5A5; font-size: 11px; font-family: Poppins; font-weight: 500; word-wrap: break-word">+B$5</div>
    <div data-layer="Total" class="Total" style="width: 63px; height: 20px; left: 56px; top: 791px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 24px; font-family: Poppins; font-weight: 600; word-wrap: break-word">Total</div>
    <div data-layer="B$20" class="B20" style="width: 63px; height: 20px; left: 318px; top: 791px; position: absolute; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 24px; font-family: Poppins; font-weight: 600; word-wrap: break-word">B$20</div>
    <div data-layer="Rectangle 23" class="Rectangle23" style="width: 375px; height: 47px; left: 30px; top: 855px; position: absolute; background: #770000; border-radius: 33px"></div>
    <div data-layer="PAY NOW (B$30)" class="PayNowB30" style="width: 285.81px; height: 30.03px; left: 75px; top: 863px; position: absolute; text-align: center; justify-content: center; display: flex; flex-direction: column; color: white; font-size: 16px; font-family: Poppins; font-weight: 700; word-wrap: break-word">PAY NOW (B$30)</div>
    <div data-svg-wrapper data-layer="Ellipse 3" class="Ellipse3" style="left: 51px; top: 595px; position: absolute">
        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="4" cy="4" r="4" fill="#D9D9D9"/>
        </svg>
    </div>
    <div data-layer="Rectangle 55" class="Rectangle55" style="width: 430px; height: 2px; left: 0px; top: 763px; position: absolute; background: rgba(217, 217, 217, 0.20); border-radius: 14px"></div>
</div>


    <div id="slideWrapper" class="slide-wrapper">
        <script>
            window.addEventListener('load', () => {
                setTimeout(() => {
                    document.getElementById('slideWrapper').classList.add('show');
                }, 200);
            });
        </script>

    <script>
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