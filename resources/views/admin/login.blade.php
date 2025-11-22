<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | Temen Holiday</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome untuk icon eye -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fa;
            height: 100vh;
        }
        .login-wrapper {
            max-width: 430px;
            margin: auto;
            margin-top: 7%;
            padding: 40px 35px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .logo img {
            width: 180px;
        }
        .btn-login {
            background: #3478ff;
            color: white;
            font-weight: 500;
        }
        .btn-login:hover {
            background: #1c63e6;
        }
        .password-toggle {
            cursor: pointer;
        }
    </style>

</head>

<body>

<div class="login-wrapper">

    <div class="text-center mb-3 logo">
        <img src="{{ asset('assets/image/logo-new.png') }}" alt="Logo Temen Holiday">
    </div>

    @if ($errors->has('login'))
        <div class="alert alert-danger py-2">
            {{ $errors->first('login') }}
        </div>
    @endif

    <form action="{{ route('admin.login.action') }}" method="POST">
        @csrf

        <h4 class="text-center mb-4">Login with your email</h4>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

                <span class="input-group-text password-toggle" id="togglePassword">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-login w-100 py-2 mt-2">Login</button>
    </form>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        const currentType = passwordInput.getAttribute('type');

        if (currentType === "password") {
            passwordInput.setAttribute('type', 'text');
            togglePassword.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        } else {
            passwordInput.setAttribute('type', 'password');
            togglePassword.innerHTML = '<i class="fa-solid fa-eye"></i>';
        }
    });
</script>

</body>
</html>
