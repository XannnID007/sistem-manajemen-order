<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $isLogin ? 'Login' : 'Register' }} - {{ $setting->pangkalan_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* --- BACKGROUND & BASE SETUP --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?q=80&w=2527&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        /* --- CONTAINER UTAMA --- */
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            position: relative;
            width: 900px;
            max-width: 95%;
            min-height: 600px;
        }

        /* --- ANIMASI SLIDING --- */
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
            opacity: 0;
            pointer-events: none;
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {

            0%,
            49.99% {
                opacity: 0;
                z-index: 1;
            }

            50%,
            100% {
                opacity: 1;
                z-index: 5;
            }
        }

        /* --- SLIDE HIJAU (OVERLAY) --- */
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .overlay {
            background: linear-gradient(to right, rgba(5, 150, 105, 0.8), rgba(16, 185, 129, 0.7));
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-20%);
        }

        .container.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .container.right-panel-active .overlay-right {
            transform: translateX(20%);
        }

        /* --- FOOTER DI OVERLAY (TENGAH) --- */
        .overlay-footer {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            text-align: center;
            padding: 0 20px;
            opacity: 0.8;
            font-size: 11px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 15px;
        }

        .footer-name {
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .footer-address {
            font-weight: 300;
            font-size: 10px;
        }

        /* --- KONTEN FORM --- */
        .form-content {
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
            color: white;
        }

        h1 {
            font-weight: 700;
            margin: 0;
            font-size: 32px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }

        .form-content h1 {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .form-content h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background-color: #10b981;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
        }

        .overlay-panel p.subtitle {
            font-size: 14px;
            font-weight: 300;
            line-height: 20px;
            margin-bottom: 30px;
            color: rgba(255, 255, 255, 0.9);
            letter-spacing: 0.5px;
        }

        .logo-box {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .logo-box:hover {
            transform: scale(1.05);
        }

        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            padding: 10px;
        }

        .logo-box i {
            font-size: 50px;
            color: white;
        }

        /* --- INPUT FIELDS & ICONS --- */
        .input-group {
            width: 100%;
            margin: 10px 0;
            text-align: left;
        }

        .input-group label {
            margin-left: 10px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .icon-left {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
            pointer-events: none;
        }

        /* PERBAIKAN: Class khusus untuk Icon Alamat (Textarea) agar di atas */
        .input-wrapper .icon-top {
            top: 25px;
            /* Jarak dari atas disesuaikan dengan padding input */
            transform: none;
            /* Hilangkan centering vertical */
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            cursor: pointer;
            z-index: 10;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: #fff;
        }

        .input-wrapper input,
        .input-wrapper textarea {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 12px 40px 12px 45px;
            width: 100%;
            border-radius: 50px;
            color: white;
            outline: none;
            transition: all 0.3s;
        }

        .input-wrapper textarea {
            border-radius: 20px;
            height: 80px;
            resize: none;
            padding-right: 15px;
        }

        .input-wrapper input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-wrapper input:focus,
        .input-wrapper textarea:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #fff;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
        }

        /* --- STYLE KHUSUS REGISTER --- */
        .sign-up-container .input-group {
            margin: 5px 0;
        }

        .sign-up-container .input-wrapper input {
            padding: 8px 35px 8px 35px;
            font-size: 12px;
            height: 38px;
        }

        .sign-up-container .input-wrapper .icon-left {
            font-size: 13px;
            left: 12px;
        }

        /* Icon Top juga perlu disesuaikan ukurannya di form register */
        .sign-up-container .input-wrapper .icon-top {
            top: 15px;
            font-size: 13px;
            left: 12px;
        }

        .sign-up-container .toggle-password {
            font-size: 12px;
            right: 12px;
        }

        .sign-up-container label {
            font-size: 11px;
            margin-bottom: 2px;
        }

        /* --- BUTTONS --- */
        button.btn-primary {
            border-radius: 50px;
            border: none;
            background: linear-gradient(45deg, #10b981, #34d399);
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding: 12px 50px;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }

        button.btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.4);
        }

        button.btn-ghost {
            background: transparent;
            border: 2px solid white;
            border-radius: 50px;
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding: 12px 50px;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s;
        }

        button.btn-ghost:hover {
            background: white;
            color: #10b981;
        }

        /* --- SCROLL & GRID --- */
        .register-scroll {
            width: 100%;
            max-height: 420px;
            overflow-y: auto;
            padding: 5px;
        }

        .register-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .register-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .full-width {
            grid-column: span 2;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            width: 100%;
            margin: 15px 0;
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
        }

        .checkbox-group input {
            margin-right: 8px;
            accent-color: #10b981;
            width: 16px;
            height: 16px;
        }

        .error-message {
            color: #ff9999;
            font-size: 10px;
            text-align: left;
            margin-left: 15px;
            margin-top: 1px;
        }

        @media (max-width: 768px) {
            .container {
                width: 100%;
                min-height: 100vh;
                border-radius: 0;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                background: '#fff',
                confirmButtonColor: '#10b981',
                timer: 2000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                background: '#fff',
                confirmButtonColor: '#ef4444',
            });
        </script>
    @endif

    <div class="container {{ request()->routeIs('register') ? 'right-panel-active' : '' }}" id="container">

        <div class="form-container sign-up-container">
            <form class="form-content" action="{{ route('register') }}" method="POST">
                @csrf
                <h1>Buat Akun</h1>

                <div class="register-scroll">
                    <div class="form-grid">
                        <div class="input-group">
                            <label>Nama Lengkap</label>
                            <div class="input-wrapper">
                                <i class="fas fa-user icon-left"></i>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
                                    required>
                            </div>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label>Email</label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope icon-left"></i>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="email@domain.com" autocomplete="off" required>
                            </div>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label>NIK</label>
                            <div class="input-wrapper">
                                <i class="fas fa-id-card icon-left"></i>
                                <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                                    placeholder="NIK" required>
                            </div>
                            @error('nik')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label>No. HP</label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone icon-left"></i>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxx"
                                    required>
                            </div>
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label>Password</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock icon-left"></i>
                                <input type="password" name="password" class="password-input" placeholder="******"
                                    required>
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Konfirmasi</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock icon-left"></i>
                                <input type="password" name="password_confirmation" class="password-input"
                                    placeholder="******" required>
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>

                        <div class="input-group full-width">
                            <label>Alamat</label>
                            <div class="input-wrapper">
                                <i class="fas fa-map-marker-alt icon-left icon-top"></i>
                                <textarea name="address" placeholder="Alamat Lengkap" required>{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary">Daftar</button>
            </form>
        </div>

        <div class="form-container sign-in-container">
            <form class="form-content" action="{{ route('login') }}" method="POST">
                @csrf
                <h1>Login</h1>

                <div class="input-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope icon-left"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@domain.com"
                            autocomplete="off" required>
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock icon-left"></i>
                        <input type="password" name="password" class="password-input" placeholder="********" required>
                        <i class="fas fa-eye toggle-password"></i>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat Saya</label>
                </div>

                <button type="submit" class="btn-primary">Masuk</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <div class="logo-box">
                        @if ($setting->logo)
                            <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo">
                        @else
                            <i class="fas fa-gas-pump"></i>
                        @endif
                    </div>
                    <h1>Sudah Punya Akun?</h1>
                    <p class="subtitle">Silakan login kembali untuk mengakses dashboard Anda.</p>
                    <button class="btn-ghost" id="signIn">Login</button>

                    <div class="overlay-footer">
                        <p class="footer-name">{{ $setting->pangkalan_name }}</p>
                        <p class="footer-address">
                            <i class="fas fa-map-marker-alt" style="font-size: 10px;"></i>
                            {{ $setting->pangkalan_address ?? 'Alamat Pangkalan Belum Diatur' }}
                        </p>
                    </div>
                </div>

                <div class="overlay-panel overlay-right">
                    <div class="logo-box">
                        @if ($setting->logo)
                            <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo">
                        @else
                            <i class="fas fa-gas-pump"></i>
                        @endif
                    </div>
                    <h1>Selamat Datang!</h1>
                    <p class="subtitle">Daftarkan diri Anda untuk kemudahan transaksi LPG 3kg.</p>
                    <button class="btn-ghost" id="signUp">Daftar</button>

                    <div class="overlay-footer">
                        <p class="footer-name">{{ $setting->pangkalan_name }}</p>
                        <p class="footer-address">
                            <i class="fas fa-map-marker-alt" style="font-size: 10px;"></i>
                            {{ $setting->pangkalan_address ?? 'Alamat Pangkalan Belum Diatur' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
            window.history.pushState({}, '', '{{ route('register') }}');
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
            window.history.pushState({}, '', '{{ route('login') }}');
        });

        window.addEventListener('popstate', function(event) {
            const path = window.location.pathname;
            if (path.includes('register')) {
                container.classList.add('right-panel-active');
            } else {
                container.classList.remove('right-panel-active');
            }
        });

        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>

</html>
