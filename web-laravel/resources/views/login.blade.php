<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPETANG - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(180deg, #04255f 0%, #0b3b80 70%, #0c477e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .login-wrapper {
            display: flex;
            width: min(1120px, 100%);
            min-height: 620px;
            border-radius: 32px;
            overflow: hidden;
            background: white;
            box-shadow: 0 40px 120px rgba(6, 31, 91, 0.25);
        }

        .login-left {
            background: linear-gradient(135deg, #0d3a71 0%, #0f4d8d 100%);
            color: white;
            padding: 60px 55px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 45%;
            position: relative;
            overflow: hidden;
        }

        .login-left::before,
        .login-left::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .login-left::before {
            top: -40%;
            right: -35%;
            width: 420px;
            height: 420px;
        }

        .login-left::after {
            bottom: -30%;
            left: -20%;
            width: 360px;
            height: 360px;
        }

        .login-left-content {
            position: relative;
            z-index: 1;
        }

        .logo-section {
            margin-bottom: 45px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo-box {
            background: white;
            width: 70px;
            height: 70px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
        }

        .sipetang-logo {
            width: 56px;
            height: 56px;
            object-fit: contain;
        }

        .logo-text h1 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .logo-text p {
            font-size: 11px;
            opacity: 0.85;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .login-title {
            font-size: 74px;
            font-weight: 800;
            margin-bottom: 18px;
            line-height: 0.95;
            letter-spacing: -1px;
        }

        .login-description {
            font-size: 16px;
            line-height: 1.8;
            opacity: 0.92;
            max-width: 360px;
            margin-bottom: 12px;
        }

        .login-left .login-footer {
            position: static;
            margin-top: 40px;
            color: rgba(255, 255, 255, 0.72);
            font-size: 12px;
            line-height: 1.6;
        }

        .login-right {
            width: 55%;
            padding: 60px 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
        }

        .login-card {
            width: 100%;
            max-width: 540px;
            background: white;
            border-radius: 28px;
            padding: 50px 44px;
            box-shadow: 0 30px 80px rgba(15, 44, 89, 0.12);
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #17274f;
            margin-bottom: 12px;
        }

        .form-header p {
            font-size: 15px;
            color: #637392;
            line-height: 1.7;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #5b647d;
            margin-bottom: 10px;
            letter-spacing: 0.8px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #dde4ef;
            border-radius: 14px;
            font-size: 15px;
            transition: all 0.25s ease;
            background: #f7f9ff;
            color: #2d3f5f;
        }

        .form-group input:focus {
            outline: none;
            border-color: #c6d8f4;
            background: white;
            box-shadow: 0 0 0 4px rgba(20, 79, 167, 0.08);
        }

        .form-group input::placeholder {
            color: #9aa3b4;
        }

        .password-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-group input {
            padding-right: 44px;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            cursor: pointer;
            font-size: 18px;
            color: #94a3bb;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: #1a4d8d;
        }

        .forgot-password {
            position: absolute;
            right: 0;
            top: 2px;
            font-size: 13px;
            color: #0f4d8d;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.25s ease;
        }

        .forgot-password:hover {
            color: #0b3a69;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 28px;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
            cursor: pointer;
            accent-color: #f16301;
        }

        .remember-me label {
            margin: 0;
            font-size: 14px;
            color: #4d556d;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 14px 18px;
            background: #f16301;
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: #d95401;
            transform: translateY(-1px);
            box-shadow: 0 14px 35px rgba(241, 99, 1, 0.18);
        }

        .error-message,
        .success-message {
            border-radius: 14px;
            margin-bottom: 22px;
            font-size: 13px;
            line-height: 1.6;
            animation: slideDown 0.3s ease-out;
            padding: 16px 18px;
        }

        .error-message {
            background: #fff1f0;
            color: #b32318;
            border-left: 4px solid #dd1f1f;
        }

        .success-message {
            background: #effaf2;
            color: #1f5d2f;
            border-left: 4px solid #2f8b4c;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 980px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-left,
            .login-right {
                width: 100%;
            }

            .login-left {
                padding: 40px 30px;
            }

            .login-right {
                padding: 30px 24px;
            }

            .login-card {
                padding: 32px 28px;
            }

            .login-title {
                font-size: 54px;
                margin-bottom: 16px;
            }

            .form-header h2 {
                font-size: 28px;
            }
        }

        @media (max-width: 640px) {
            .login-left {
                padding: 28px 18px;
            }

            .login-title {
                font-size: 42px;
            }

            .login-description,
            .logo-text h1 {
                max-width: 100%;
            }

            .form-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <!-- Left Side -->
        <div class="login-left">
            <div class="login-left-content">
                <div class="logo-section">
                    <div class="logo-box">
                    <img src="{{ asset('images/sipetang.jpg.png') }}" alt="SIPETANG Logo" class="sipetang-logo">
                </div>
                <div class="logo-text">
                    <h1>SIPETANG</h1>
                    <p>Sistem Informasi Pencatatan Hasil Tangkap</p>
                </div>
                </div>

                <h2 class="login-title">MASUK</h2>
                <p class="login-description">Lingkungan terukur untuk mengelola data maritim dan aset perikanan dengan presisi dan otoritas.</p>
            </div>
            
            <div class="login-footer">
                <p>&copy; 2024 Dinas Perikanan Kabupaten Subang.</p>
                <p>Sekuritas dan kebijakan undang-undang.</p>
            </div>
        </div>

        <!-- Right Side -->
        <div class="login-right">
            <div class="login-card">
                <div class="form-header">
                    <h2>Selamat Datang</h2>
                    <p>Masuk untuk mengelola data maritim dan aset perikanan secara presisi.</p>
                </div>

                @if ($errors->any())
                <div class="error-message">
                    <strong>Login gagal!</strong>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        placeholder="Masukan Nama" required value="{{ old('username') }}"
                        autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password
                        <a href="{{ route('password.request') }}" class="forgot-password">Lupa Kata Sandi?</a>
                    </label>
                    <div class="password-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="••••••••" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Ingat saya untuk sesi berikutnya</label>
                </div>

                <button type="submit" class="btn-login">
                    MASUK <i class="fas fa-arrow-right"></i>
                </button>
            </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
