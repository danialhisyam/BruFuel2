<?php
/*
|--------------------------------------------------------------------------
| Register + Login Page Component Logic
|--------------------------------------------------------------------------
*/
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
  public string $name=''; public string $email=''; public string $password=''; public string $password_confirmation='';

  public function register(): void {
    $validated=$this->validate([
      'name'=>['required','string','max:255'],
      'email'=>['required','string','lowercase','email','max:255','unique:' . User::class],
      'password'=>['required','string','confirmed',Rules\Password::defaults()],
    ]);
    $validated['password']=Hash::make($validated['password']);
    $user=User::create($validated);
    Auth::login($user); Session::regenerate();
    $this->redirectIntended(route('login',absolute:false),navigate:true);
  }

  public function login(): void {
    $creds=['email'=>$this->email,'password'=>$this->password];
    if(Auth::attempt($creds)){Session::regenerate();$this->redirectIntended(route('home',absolute:false),navigate:true);}
  }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>BruFuel Portal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/*
|--------------------------------------------------------------------------
| Base Styles
|--------------------------------------------------------------------------
*/
html,body{margin:0;padding:0;height:100%;background:#000;color:#fff;font-family:'Poppins',sans-serif;overflow:hidden;}

/*
|--------------------------------------------------------------------------
| Background Image
|--------------------------------------------------------------------------
*/
.background{position:fixed;left:50%;top:50%;width:110%;height:110%;transform:translate(-50%,-50%);object-fit:cover;filter:brightness(.9);z-index:0;opacity:0;animation:fadeInBg 1s ease-out forwards;}

/*
|--------------------------------------------------------------------------
| Glass Container
|--------------------------------------------------------------------------
*/
.glass-container{position:absolute;top:150px;left:300px;right:300px;bottom:150px;display:flex;overflow:hidden;border-radius:25px;background:rgba(255,255,255,.07);backdrop-filter:blur(25px);-webkit-backdrop-filter:blur(25px);border:1px solid rgba(255,255,255,.15);box-shadow:0 0 50px rgba(0,0,0,.4);z-index:1;}

/*
|--------------------------------------------------------------------------
| Left Side (Image)
|--------------------------------------------------------------------------
*/
.left-side{flex:1;background:url('{{ asset('signupimages/brufuel.png') }}') center/cover no-repeat;}

/*
|--------------------------------------------------------------------------
| Right Side (Form Section)
|--------------------------------------------------------------------------
*/
.right-side{flex:1;display:flex;flex-direction:column;justify-content:space-between;align-items:center;padding:90px 50px;box-sizing:border-box;}

/*
|--------------------------------------------------------------------------
| Form Wrapper (Register + Login)
|--------------------------------------------------------------------------
*/
.form-wrapper{display:none;flex-direction:column;align-items:center;justify-content:center;width:100%;max-width:420px;margin:auto;padding:0 50px;box-sizing:border-box;transform:translateX(-13px);}
.form-wrapper.active{display:flex;}

/*
|--------------------------------------------------------------------------
| Titles
|--------------------------------------------------------------------------
*/
h2{font-size:2rem;font-weight:700;text-align:center;margin:0 0 1rem 0;line-height:1.3;white-space:nowrap;}
p.subtitle{text-align:center;color:rgba(255,255,255,.7);margin:0 0 2rem 0;font-weight:500;font-size:1rem;line-height:1.6;white-space:nowrap;}
h2,p.subtitle{position:relative;left:10px;text-align:center;}

/*
|--------------------------------------------------------------------------
| Input Boxes
|--------------------------------------------------------------------------
*/
.credential-input{width:100%;height:45px;margin-bottom:15px;padding:0 15px;border:none;border-radius:15px;background:rgba(217,217,217,.1);font-size:15px;font-weight:500;font-family:'Poppins',sans-serif;color:#9ca3af;outline:none;transition:.3s;-webkit-text-fill-color:rgba(255,255,255,.14);}
.credential-input::placeholder{color:rgba(255,255,255,.25);}
.credential-input.has-text{color:#fff!important;-webkit-text-fill-color:#fff!important;}
.credential-input:focus{border:1px solid rgba(255,255,255,.25);}
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
  -webkit-box-shadow: 0 0 0px 1000px rgba(217, 217, 217, 0.1) inset !important; /* fully transparent */
  -webkit-text-fill-color: #ffffff !important; /* plain white text */
  caret-color: #00000013 !important;
  background-color: transparent !important;
  transition: background-color 9999s ease-in-out 0s !important;
}
/*
|--------------------------------------------------------------------------
| Footer Link (Unchanged Position)
|--------------------------------------------------------------------------
*/
.form-footer{margin-top:-10px;width:100%;text-align:right;padding-right:260px;padding-bottom:260px;}
.form-footer a{color:#FFE100;font-weight:400;font-size:13px;text-decoration:none;display:inline-block;transition:transform .15s ease,opacity .2s;}
.form-footer a:hover{transform:scale(1.05);opacity:.9;}

/*
|--------------------------------------------------------------------------
| Button Container + Button
|--------------------------------------------------------------------------
*/
.button-container{width:100%;display:flex;justify-content:center;align-items:center;position:relative;bottom:200px;}
button{width:100%;max-width:310px;height:50px;border:none;border-radius:33px;background:#4B5563;color:#fff;font-family:'Poppins',sans-serif;font-size:18px;font-weight:800;cursor:not-allowed;transition:all .3s ease;position:relative;z-index:5;}
button.enabled{background:#760000;cursor:pointer;}
button.enabled:hover{transform:scale(1.03);}
.hidden{display:none;}

/*
|--------------------------------------------------------------------------
| Responsive Adjustments
|--------------------------------------------------------------------------
*/
@media(max-width:1024px){.glass-container{top:100px;bottom:100px;left:150px;right:150px;}}
@media(max-width:768px){.glass-container{flex-direction:column;top:50px;bottom:50px;left:50px;right:50px;}.left-side{height:20%;flex:none;border-bottom:1px solid rgba(255,255,255,.2);}.right-side{padding:25px 35px;}.form-wrapper{padding:0 35px;margin-top:-40px;}.form-footer{margin-top:-20px;text-align:right;padding-left:35px;}.button-container{bottom:60px;}}
@media(max-width:480px){.glass-container{top:150px;bottom:150px;left:25px;right:25px;border-radius:18px;}.left-side{height:14%;}.right-side{padding:18px 22px;}.form-wrapper{padding:0 22px;margin-top:40px;transform:scale(0.95) translateX(-13px);}.credential-input{height:40px;font-size:14px;border-radius:12px;}.form-footer{margin-top:-5px;margin-left:15px;}.button-container{bottom:50px;transform:scale(0.85);}.h2{font-size:1.4rem;white-space:nowrap!important;}.p.subtitle{font-size:.9rem;margin-bottom:1.5rem;}}

/*
|--------------------------------------------------------------------------
| Page Entrance Animation
|--------------------------------------------------------------------------
*/
@keyframes fadeInBg{to{opacity:1;}}
</style>
</head>

<body>
<img src="{{ asset('signupimages/background.jpg') }}" alt="background" class="background" draggable="false">
<div class="glass-container">
  <div class="left-side"></div>
  <div class="right-side">
    <!-- REGISTER -->
    <div class="form-wrapper active" id="registerFormWrapper">
      <h2>Create an Account</h2>
      <p class="subtitle">Join <strong>BruFuel</strong> and start your journey</p>
      <form wire:submit="register" id="registerForm">
        @csrf
        <input wire:model="name" type="text" placeholder="Full Name" class="credential-input" required>
        <input wire:model="email" type="email" placeholder="Email Address" class="credential-input" required>
        <input wire:model="password" type="password" placeholder="Password" class="credential-input" required>
        <input wire:model="password_confirmation" type="password" placeholder="Confirm Password" class="credential-input" required>
      </form>
    </div>

    <!-- LOGIN -->
    <div class="form-wrapper" id="loginFormWrapper">
      <h2>Welcome Back</h2>
      <p class="subtitle">Log in to your <strong>BruFuel</strong> account</p>
        <form wire:submit="login" id="loginForm">        @csrf
        <input wire:model="email" type="email" placeholder="Email Address" class="credential-input" required>
        <input wire:model="password" type="password" placeholder="Password" class="credential-input" required>
      </form>
    </div>

    <div class="form-footer"><a href="javascript:void(0)" id="toggleLink" onclick="toggleForms()">Already have an account? Log in</a></div>

    <div class="button-container">
      <button id="createButton" type="submit" form="registerForm">CREATE ACCOUNT</button>
      <button id="loginButton" type="submit" form="loginForm" class="hidden">LOGIN</button>
    </div>
  </div>
</div>

<script>
/*
|--------------------------------------------------------------------------
| Input Behavior + Button Activation
|--------------------------------------------------------------------------
*/
function updateInputColors() {
  document.querySelectorAll('.credential-input').forEach(i => {
    if (i.value.trim() !== "") {
      i.classList.add('has-text');
      i.style.color = '#ffffff';
      i.style.webkitTextFillColor = '#ffffff';
    } else {
      i.classList.remove('has-text');
      i.style.color = '#9ca3af';
      i.style.webkitTextFillColor = 'rgba(255,255,255,0.14)';
    }
  });
  checkFormValidity();
}

function checkFormValidity() {
  const activeForm = document.querySelector('.form-wrapper.active form');
  if (!activeForm) return;

  const inputs = activeForm.querySelectorAll('.credential-input');
  const btn = activeForm.id === "registerForm"
    ? document.getElementById("createButton")
    : document.getElementById("loginButton");
  const allFilled = [...inputs].every(i => i.value.trim() !== "");

  if (activeForm.id === "registerForm") {
    const emailInput = activeForm.querySelector('input[type="email"]');
    const passInput = activeForm.querySelector('input[type="password"]');
    const confirmInput = activeForm.querySelector('input[placeholder="Confirm Password"]');

    const emailValid = emailInput && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
    const forbidden = emailInput && (
      emailInput.value.toLowerCase().endsWith("@admin.brufuel.bn") ||
      emailInput.value.toLowerCase().endsWith("@driver.brufuel.bn") ||
      emailInput.value.toLowerCase().endsWith("@brufuel.bn") ||
      emailInput.value.toLowerCase().endsWith("@brufuel.com") ||
      emailInput.value.toLowerCase().endsWith("@driver.brufuel.com") ||
      emailInput.value.toLowerCase().endsWith("@admin.brufuel.com")
    );
    const passValid = passInput && /^(?=.*[A-Za-z])(?=.*\d).{8,}$/.test(passInput.value);
    const passwordsMatch = passInput && confirmInput && (passInput.value === confirmInput.value);

    const validForm = allFilled && emailValid && passValid && passwordsMatch && !forbidden;
    btn.classList.toggle('enabled', validForm);
    btn.disabled = !validForm;
  } else {
    btn.classList.toggle('enabled', allFilled);
    btn.disabled = !allFilled;
  }
}

function resetAutofillTransparency() {
  document.querySelectorAll('.credential-input').forEach(el => {
    const val = el.value;
    el.style.webkitBoxShadow = '0 0 0px 1000px rgba(217, 217, 217, 0.1) inset';
    el.style.backgroundColor = 'transparent';
    el.style.webkitTextFillColor = '#ffffff';
    el.value = ''; el.value = val;
  });
}

function toggleForms(){
  const reg = document.getElementById('registerFormWrapper');
  const log = document.getElementById('loginFormWrapper');
  const regBtn = document.getElementById('createButton');
  const logBtn = document.getElementById('loginButton');
  const link = document.getElementById('toggleLink');
  const isReg = reg.classList.contains('active');

  if (isReg) {
    reg.classList.remove('active'); log.classList.add('active');
    regBtn.classList.add('hidden'); logBtn.classList.remove('hidden');
    link.innerHTML = "Don't have an account? Sign up";
    history.pushState({}, '', '/login');
  } else {
    log.classList.remove('active'); reg.classList.add('active');
    logBtn.classList.add('hidden'); regBtn.classList.remove('hidden');
    link.innerHTML = "Already have an account? Log in";
    history.pushState({}, '', '/signup');
  }

  resetAutofillTransparency();
  checkFormValidity();
}

/*
|--------------------------------------------------------------------------
| Handle Back/Forward
|--------------------------------------------------------------------------
*/
window.addEventListener('popstate', () => {
  const path = window.location.pathname;
  const reg = document.getElementById('registerFormWrapper');
  const log = document.getElementById('loginFormWrapper');
  const regBtn = document.getElementById('createButton');
  const logBtn = document.getElementById('loginButton');
  const link = document.getElementById('toggleLink');
  
  if (path.includes('login')) {
    reg.classList.remove('active'); log.classList.add('active');
    regBtn.classList.add('hidden'); logBtn.classList.remove('hidden');
    link.innerHTML = "Don't have an account? Sign up";
  } else {
    log.classList.remove('active'); reg.classList.add('active');
    logBtn.classList.add('hidden'); regBtn.classList.remove('hidden');
    link.innerHTML = "Already have an account? Log in";
  }
});

/*
|--------------------------------------------------------------------------
| Event Listeners
|--------------------------------------------------------------------------
*/
document.querySelectorAll('.credential-input').forEach(i => i.addEventListener('input', updateInputColors));
window.addEventListener('load', () => setTimeout(updateInputColors, 300));

/*
|--------------------------------------------------------------------------
| Redirect After Login (Role-based)
|--------------------------------------------------------------------------
*/
const loginBtn = document.getElementById('loginButton');
if (loginBtn) {
  loginBtn.onclick = (e) => {
    e.preventDefault();
    const emailInput = document.querySelector('#loginForm input[type="email"]');
    if (!emailInput) return;

    const emailValue = emailInput.value.toLowerCase();

    if (emailValue.endsWith('@admin.brufuel.bn')) {
      window.location.href = '{{ route('admin.dashboard') }}';
    } else if (emailValue.endsWith('@driver.brufuel.bn')) {
      window.location.href = '{{ route('driver.dashboard') }}';
    } else {
      window.location.href = '{{ route('home') }}';
    }
  };
}

document.getElementById('createButton').addEventListener('click', (e) => {
  e.preventDefault();
  toggleForms();
});
</script>

</body>
</html>