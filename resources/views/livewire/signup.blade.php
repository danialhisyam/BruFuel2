
<div class="signup-root" style="all:unset;display:block;">
    {{-- ================= BACKGROUND ================= --}}
    <img src="{{ asset('signupimages/background.jpg') }}" alt="background" class="background" draggable="false">

    {{-- ================= MAIN GLASS CONTAINER ================= --}}
    <div class="glass-container">
        <div class="left-side"></div>

        <div class="right-side">
            <div class="form-wrapper">
                <h2>Create an Account</h2>
                <p class="subtitle">Join <strong>BruFuel</strong> and start your journey</p>

                {{-- ================= FORM ================= --}}
                <form wire:submit.prevent="register">
                    @csrf

                    <input wire:model="name"
                        type="text"
                        name="name"
                        placeholder="Full Name"
                        class="credential-input"
                        required
                        autocomplete="name">

                    <input wire:model="email"
                        type="email"
                        name="email"
                        placeholder="Email Address"
                        class="credential-input"
                        required
                        autocomplete="email username"
                        inputmode="email">

                    <input wire:model="password"
                        type="password"
                        name="password"
                        placeholder="Password"
                        class="credential-input"
                        required
                        autocomplete="new-password">

                    <div class="password-strength" id="passwordStrength"></div>

                    <input wire:model="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm Password"
                        class="credential-input"
                        required
                        autocomplete="new-password">

                    <div class="button-container">
                        <button id="createButton" type="submit">CREATE ACCOUNT</button>
                    </div>
                </form>

                <div class="form-footer">
                    <a href="{{ route('login') }}">Already have an account? Log in</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ================== FULL CSS ================== --}}
    <style>
        html, body {
            margin: 0; padding: 0; height: 100%;
            background: #000; color: #fff;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }
        .background {
            position: fixed; left:50%; top:50%;
            width:110%; height:110%;
            transform:translate(-50%,-50%);
            object-fit:cover; filter:brightness(.9);
            z-index:0; opacity:1;
        }
        .glass-container {
            position:absolute; top:150px; left:300px; right:300px; bottom:150px;
            display:flex; overflow:hidden;
            border-radius:25px;
            background:rgba(255,255,255,.07);
            backdrop-filter:blur(25px);
            -webkit-backdrop-filter:blur(25px);
            border:1px solid rgba(255,255,255,.15);
            box-shadow:0 0 50px rgba(0,0,0,.4);
            z-index:1; opacity:0;
            transform:translateY(30px);
            transition:opacity .6s ease, transform .6s ease;
        }
        .left-side {
            flex:1;
            background:url('{{ asset('signupimages/brufuel.png') }}') center/cover no-repeat;
        }
        .right-side {
            flex:1; display:flex; flex-direction:column;
            justify-content:space-between; align-items:center;
            padding:90px 50px; box-sizing:border-box;
        }
        .form-wrapper {
            display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            width:100%; max-width:420px;
            margin:auto; padding:0 50px;
            transform:translateX(-13px);
            box-sizing:border-box;
        }
        h2 {
            font-size:2rem; font-weight:700;
            text-align:center; margin:0 0 1rem;
            line-height:1.3; white-space:nowrap;
        }
        p.subtitle {
            text-align:center; color:rgba(255,255,255,.7);
            margin:0 0 2rem; font-weight:500;
            font-size:1rem; line-height:1.6; white-space:nowrap;
        }
        h2, p.subtitle { position:relative; left:10px; text-align:center; }

        .credential-input {
            width:100%; height:45px;
            margin-bottom:15px; padding:0 15px;
            border:none; border-radius:15px;
            background:rgba(217,217,217,.1);
            font-size:15px; font-weight:500;
            font-family:'Poppins',sans-serif;
            color:#9ca3af; outline:none;
            transition:.3s; -webkit-text-fill-color:#9ca3af;
        }
        .credential-input::placeholder { color:rgba(255,255,255,.25); }
        .credential-input.has-text {
            color:#fff !important; -webkit-text-fill-color:#fff !important;
        }
        .credential-input:focus { border:1px solid rgba(255,255,255,.25); }

        .password-strength {
            margin-top:-10px; margin-bottom:15px;
            font-size:12px; color:#FFE100;
            text-align:left; width:100%; padding-left:15px;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color:#9ca3af !important;
            -webkit-box-shadow:0 0 0px 1000px rgba(217,217,217,0.1) inset !important;
            background-color:transparent !important;
            transition:background-color 5000s ease-in-out 0s !important;
            border:none !important;
        }
        .credential-input.has-text:-webkit-autofill {
            -webkit-text-fill-color:#fff !important;
        }

        .form-footer {
            margin-top:-55px; width:100%;
            text-align:right; padding-right:5px; padding-bottom:180px;
        }
        .form-footer a {
            color:#FFE100; font-weight:400; font-size:13px;
            text-decoration:none; display:inline-block;
            transition:transform .15s ease, opacity .2s;
        }
        .form-footer a:hover { transform:scale(1.05); opacity:.9; }

        .button-container {
            width:100%; display:flex; justify-content:center; align-items:center;
            position:relative; bottom:-50px;
        }
        button {
            width:100%; max-width:310px; height:50px;
            border:none; border-radius:33px;
            background:#4B5563; color:#fff;
            font-family:'Poppins',sans-serif;
            font-size:18px; font-weight:800;
            cursor:not-allowed; transition:all .3s ease;
            position:relative; z-index:5;
        }
        button.enabled { background:#760000; cursor:pointer; }
        button.enabled:hover { transform:scale(1.03); }

        @media(max-width:1024px){
            .glass-container{top:100px;bottom:100px;left:150px;right:150px;}
        }
        @media(max-width:768px){
            .glass-container{flex-direction:column;top:50px;bottom:50px;left:50px;right:50px;}
            .left-side{height:20%;flex:none;border-bottom:1px solid rgba(255,255,255,.2);}
            .right-side{padding:25px 35px;}
            .form-wrapper{padding:0 35px;margin-top:-40px;}
            .form-footer{margin-top:-20px;text-align:right;padding-left:35px;}
            .button-container{bottom:60px;}
        }
        @media(max-width:480px){
            .glass-container{top:150px;bottom:150px;left:25px;right:25px;border-radius:18px;}
            .left-side{height:14%;}
            .right-side{padding:18px 22px;}
            .form-wrapper{padding:0 22px;margin-top:40px;transform:scale(.95) translateX(-13px);}
            .credential-input{height:40px;font-size:14px;border-radius:12px;}
            .form-footer{margin-top:-5px;margin-left:15px;}
            .button-container{bottom:240px;transform:scale(.85);}
            .h2{font-size:1.4rem;white-space:nowrap!important;}
            .p.subtitle{font-size:.9rem;margin-bottom:1.5rem;}
        }
        .glass-container.loaded { opacity:1; transform:translateY(0); }
    </style>

    {{-- ================== FULL JS ================== --}}
    <script>
        window.addEventListener('load', () => {
            const glassContainer = document.querySelector('.glass-container');
            setTimeout(()=>glassContainer.classList.add('loaded'),100);
            setTimeout(updateInputColors,300);
            setTimeout(detectAutofill,500);
        });

        function updateInputColors(){
            document.querySelectorAll('.credential-input').forEach(i=>{
                if(i.value.trim()!==""){i.classList.add('has-text');}
                else{i.classList.remove('has-text');}
            });
            checkPasswordStrength(); checkFormValidity();
        }
        function detectAutofill(){
            document.querySelectorAll('.credential-input').forEach(input=>{
                if(input.value && !input.classList.contains('has-text')){
                    input.classList.add('has-text');
                }
            });
            checkFormValidity();
        }
        function checkPasswordStrength(){
            const passwordInput=document.querySelector('input[name="password"]');
            const strengthText=document.getElementById('passwordStrength');
            if(!passwordInput||!strengthText)return;
            const password=passwordInput.value;
            if(password.length===0){strengthText.textContent='';return;}
            let strength=0;let suggestions=[];
            if(password.length>=8)strength++;
            if(/[A-Z]/.test(password))strength++;
            if(/[a-z]/.test(password))strength++;
            if(/[0-9]/.test(password))strength++;
            if(/[^A-Za-z0-9]/.test(password))strength++;
            if(password.length<8)suggestions.push('at least 8 characters');
            if(!/[A-Z]/.test(password))suggestions.push('one uppercase letter');
            if(!/[a-z]/.test(password))suggestions.push('one lowercase letter');
            if(!/[0-9]/.test(password))suggestions.push('one number');
            const msgs=['Very Weak','Weak','Fair','Good','Strong','Very Strong'];
            const colors=['#ff4444','#ff8800','#ffbb33','#ffdd44','#99cc00','#00C851'];
            strengthText.textContent=`Strength: ${msgs[strength]}${suggestions.length>0?' - Add: '+suggestions.join(', '):''}`;
            strengthText.style.color=colors[strength];
        }
        function checkFormValidity(){
            const activeForm=document.querySelector('.form-wrapper form');
            if(!activeForm)return;
            const inputs=activeForm.querySelectorAll('.credential-input');
            const btn=document.getElementById("createButton");
            const allFilled=[...inputs].every(i=>i.value.trim()!=="");
            const emailInput=activeForm.querySelector('input[type="email"]');
            const passInput=activeForm.querySelector('input[name="password"]');
            const confirmInput=activeForm.querySelector('input[name="password_confirmation"]');
            const emailValid=emailInput&&/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
            const forbidden=emailInput&&(
                emailInput.value.toLowerCase().endsWith("@admin.brufuel.bn")||
                emailInput.value.toLowerCase().endsWith("@dzriver.brufuel.bn")||
                emailInput.value.toLowerCase().endsWith("@brufuel.bn")||
                emailInput.value.toLowerCase().endsWith("@brufuel.com")||
                emailInput.value.toLowerCase().endsWith("@driver.brufuel.com")||
                emailInput.value.toLowerCase().endsWith("@admin.brufuel.com")
            );
            const passValid=passInput&&/^(?=.*[A-Za-z])(?=.*\d).{8,}$/.test(passInput.value);
            const passwordsMatch=passInput&&confirmInput&&(passInput.value===confirmInput.value);
            const validForm=allFilled&&emailValid&&passValid&&passwordsMatch&&!forbidden;
            btn.classList.toggle('enabled',validForm); btn.disabled=!validForm;
        }
        function syncPasswordFields(){
            const passwordInput=document.querySelector('input[name="password"]');
            const confirmInput=document.querySelector('input[name="password_confirmation"]');
            if(passwordInput&&confirmInput&&passwordInput.value&&!confirmInput.value){
                confirmInput.value=passwordInput.value; updateInputColors();
            }
        }
        setInterval(syncPasswordFields,100);
        setInterval(detectAutofill,200);
        document.querySelectorAll('.credential-input').forEach(i=>{
            i.addEventListener('input',updateInputColors);
            i.addEventListener('change',detectAutofill);
            i.addEventListener('blur',detectAutofill);
        });
        document.addEventListener('animationstart',e=>{
            if(e.animationName==='onAutoFillStart'){detectAutofill();}
        },true);
        document.addEventListener('animationend',e=>{
            if(e.animationName==='onAutoFillCancel'){detectAutofill();}
        },true);
    </script>
</div>
