<?php
/*
|--------------------------------------------------------------------------
| Login Page Component Logic
|--------------------------------------------------------------------------
*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

new class extends Component {
    public string $email = '';
    public string $password = '';

    public function login(): void
    {
        $user = \App\Models\User::where('email', $this->email)->first();

        // 1️⃣ No email found — go to signup
        if (!$user) {
            $this->redirect(route('signup', absolute: false), navigate: true);
            return;
        }

        // 2️⃣ Email found — check password
        if (!\Illuminate\Support\Facades\Hash::check($this->password, $user->password)) {
            session()->flash('error', 'Incorrect password. Please try again.');
            return;
        }

        // 3️⃣ Both match — log in
        \Illuminate\Support\Facades\Auth::login($user);
        \Illuminate\Support\Facades\Session::regenerate();

        // Redirect based on email domain (role-style logic)
        if (str_ends_with($user->email, '@admin.brufuel.bn')) {
            $this->redirect(route('admin.dashboard', absolute: false), navigate: true);
        } elseif (str_ends_with($user->email, '@driver.brufuel.bn')) {
            $this->redirect(route('driver.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirect(route('home', absolute: false), navigate: true);
        }
    }
};
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>BruFuel Portal - Login</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
@livewireStyles
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
| Form Wrapper
|--------------------------------------------------------------------------
*/
.form-wrapper{display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;max-width:420px;margin:auto;padding:0 50px;box-sizing:border-box;transform:translateX(-13px);}

/*
|--------------------------------------------------------------------------
| Titles
|--------------------------------------------------------------------------
*/
h2{font-size:2rem;font-weight:700;text-align:center;margin:0 0 1rem 0;line-height:1.3;white-space:nowrap;}
p.subtitle{text-align:center;color:rgba(255,255,255,.7);margin:0 0 2rem 0;font-weight:500;font-size:1rem;line-height:1.6;white-space:nowrap;}
h2,p.subtitle{position:relative;left:10px;text-align:center;}

/* make autofill act like .has-text (white) */
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus {
  -webkit-box-shadow: 0 0 0px 1000px rgba(217,217,217,0.1) inset !important;
  -webkit-text-fill-color: #ffffff !important;
  background-color: transparent !important;
  caret-color: #ffffff !important;
  transition: background-color 9999s ease-in-out 0s !important;}
  .credential-input {
  width: 100%;
  height: 45px;
  margin-bottom: 15px;
  padding: 0 15px;
  border: none;
  border-radius: 15px;
  background: rgba(217,217,217,.1);
  font-size: 15px;
  font-weight: 500;
  font-family: 'Poppins', sans-serif;
  outline: none;
  transition: color .25s ease, -webkit-text-fill-color .25s ease;
  
  /* default: gray always */
  color: #9ca3af !important;
  -webkit-text-fill-color: #9ca3af !important;
}

/* placeholder always gray */
.credential-input::placeholder {
  color: rgba(156,163,175,0.85);
}

/* DO NOTHING on focus if empty */
.credential-input:focus {
  border: 1px solid rgba(255,255,255,0.25);
  color: #9ca3af !important;
  -webkit-text-fill-color: #9ca3af !important;
}

/* turns white ONLY when text exists */
.credential-input.has-text {
  color: #ffffff !important;
  -webkit-text-fill-color: #ffffff !important;
}

/* make autofill act like .has-text (white) */
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus {
  -webkit-box-shadow: 0 0 0px 1000px rgba(217,217,217,0.1) inset !important;
  -webkit-text-fill-color: #ffffff !important;
  background-color: transparent !important;
  caret-color: #ffffff !important;
  transition: background-color 9999s ease-in-out 0s !important;
}


/*
|--------------------------------------------------------------------------
| Footer Link (Unchanged Position)
|--------------------------------------------------------------------------
*/
.form-footer {
  margin-top: -60px;
  width: 100%;
  text-align: right;
  padding-right: 270px;
  padding-bottom: 260px;
}

.form-footer a {
  position: fixed;
  bottom: 315px;
  right: 190px;
  color: #FFE100;
  font-weight: 400;
  font-size: 13px;
  text-decoration: none;
  display: inline-block;
  transition: transform 0.15s ease, opacity 0.2s;
  z-index: 999999;
  pointer-events: auto;
}

.form-footer a:hover {
  transform: scale(1.05);
  opacity: 0.9;
}

/*
|--------------------------------------------------------------------------
| Button Container + Button
|--------------------------------------------------------------------------
*/
.button-container{width:100%;display:flex;justify-content:center;align-items:center;position:relative;bottom:-60px;pointer-events: none;}
button{width:100%;max-width:310px;height:50px;border:none;border-radius:33px;background:#4B5563;color:#fff;font-family:'Poppins',sans-serif;font-size:18px;font-weight:800;cursor:not-allowed;transition:all .3s ease;position:relative;z-index:5;}
button.enabled{background:#760000;cursor:pointer;}
button.enabled:hover{transform:scale(1.03);}
.button-container button {
  pointer-events: auto;}

/*
|--------------------------------------------------------------------------
| Responsive Adjustments
|--------------------------------------------------------------------------
*/
@media(max-width:1024px){.glass-container{top:100px;bottom:100px;left:150px;right:150px;}}
@media(max-width:768px){.glass-container{flex-direction:column;top:50px;bottom:50px;left:50px;right:50px;}.left-side{height:20%;flex:none;border-bottom:1px solid rgba(255,255,255,.2);}.right-side{padding:25px 35px;}.form-wrapper{padding:0 35px;margin-top:-40px;}.form-footer{margin-top:-20px;text-align:right;padding-left:35px;}.button-container{bottom:60px;}}
@media(max-width:480px){.glass-container{top:150px;bottom:150px;left:25px;right:25px;border-radius:18px;}.left-side{height:14%;}.right-side{padding:18px 22px;}.form-wrapper{padding:0 22px;margin-top:40px;transform:scale(0.95) translateX(-13px);}.credential-input{height:40px;font-size:14px;border-radius:12px;}.form-footer{margin-top:-5px;margin-left:15px;}.button-container{bottom:240px;transform:scale(0.85);}.h2{font-size:1.4rem;white-space:nowrap!important;}.p.subtitle{font-size:.9rem;margin-bottom:1.5rem;}}

/*
|--------------------------------------------------------------------------
| Page Entrance Animation
|--------------------------------------------------------------------------
*/
@keyframes fadeInBg{to{opacity:1;}}

.error-message {
  color: #ff4d4d;
  font-weight: 500;
  font-size: 12px;
  margin-top: 115px;
  margin-bottom: 8px;
  text-align: left;
  width: 100%;
  padding-left: 5px;
  opacity: 0.95;
  position: absolute;
  left: 95px;
}

/* Page transition for glass-container */
.glass-container {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.glass-container.loaded {
  opacity: 1;
  transform: translateY(0);
}


</style>
</head>

<body>
<img src="{{ asset('signupimages/background.jpg') }}" alt="background" class="background" draggable="false">
<div class="glass-container">
  <div class="left-side"></div>
  <div class="right-side">
    <!-- LOGIN -->
    <div class="form-wrapper">
      <h2>Welcome Back</h2>
      <p class="subtitle">Log in to your <strong>BruFuel</strong> account</p>
      <form action="{{ route('login.process') }}" method="POST" id="loginForm">
        @csrf
        <input name="email" type="email" placeholder="Email Address" class="credential-input" required>
        <input name="password" type="password" placeholder="Password" class="credential-input" required>
        @if (session('error'))
          <p class="error-message">{{ session('error') }}</p>
        @endif
        <div class="button-container">
          <button id="loginButton" type="submit">LOGIN</button>
        </div>
      </form>
      </div>
     <div class="form-footer">
      <a href="{{ route('signup') }}">Don't have an account? Sign up</a>
    </div>
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
  const activeForm = document.querySelector('.form-wrapper form');
  if (!activeForm) return;

  const inputs = activeForm.querySelectorAll('.credential-input');
  const btn = document.getElementById("loginButton");

  // simple email format test
  const email = activeForm.querySelector('input[type="email"]').value.trim();
  const password = activeForm.querySelector('input[type="password"]').value.trim();

  const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  const allValid = emailValid && password !== "";

  btn.classList.toggle('enabled', allValid);
  btn.disabled = !allValid;
}

/*
|--------------------------------------------------------------------------
| Event Listeners
|--------------------------------------------------------------------------
*/
document.querySelectorAll('.credential-input').forEach(i => i.addEventListener('input', updateInputColors));
window.addEventListener('load', () => {
  setTimeout(updateInputColors, 300);
  setTimeout(resetAutofillTransparency, 400);
});

// Fade-in animation for glass container
window.addEventListener('load', () => {
  const glassContainer = document.querySelector('.glass-container');
  setTimeout(() => {
    glassContainer.classList.add('loaded');
  }, 100);
});

// Clear all form fields and disable login button on reload / back-forward navigation
window.addEventListener('pageshow', function (event) {
  // If page restored from bfcache (back/forward cache), force reset
  if (event.persisted) {
    window.location.reload();
  }

  // Clear all text, email, and password inputs
  document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]').forEach(i => {
    i.value = '';
    i.classList.remove('has-text');
  });

  // Disable button state
  const btn = document.getElementById('loginButton');
  if (btn) {
    btn.classList.remove('enabled');
    btn.disabled = true;
  }
});

</script>
  @livewireScripts
</body>
</html>