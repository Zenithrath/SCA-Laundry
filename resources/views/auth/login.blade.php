<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SCA Laundry</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Variabel tema dasar */
        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-sub: #64748b;
            --border-color: #e2e8f0;
            --input-bg: #f1f5f9;
        }

        /* Override mode kaca */
        body.glass-mode {
            --bg-body: #0f172a;
            --bg-card: rgba(255, 255, 255, 0.1);
            --text-main: #ffffff;
            --text-sub: #cbd5e1;
            --border-color: rgba(255, 255, 255, 0.2);
            --input-bg: rgba(255, 255, 255, 0.05);
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            transition: background-color .5s, color .5s;
        }

        .auth-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            backdrop-filter: blur(12px);
        }

        .auth-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }
        .auth-input::placeholder {
            color: var(--text-sub);
            opacity: .7;
        }

        /* Transisi form login-register */
        .form-section {
            transition: .5s;
            position: absolute;
            width: 100%;
            top: 0;
            left: 0;
        }
        .hide-left { transform: translateX(-110%); opacity: 0; pointer-events: none; }
        .hide-right { transform: translateX(110%); opacity: 0; pointer-events: none; }
        .show { transform: translateX(0); opacity: 1; position: relative; }
    </style>

    <script>
        /* Set tema awal berdasarkan localStorage */
        if (localStorage.getItem('theme') === 'glass') {
            document.documentElement.classList.add('glass-mode');
            document.body?.classList.add('glass-mode');
        }
    </script>
</head>

<body id="mainBody" class="min-h-screen flex items-center justify-center overflow-hidden relative">

    <!-- Background blob (khusus mode kaca) -->
    <div id="bgBlobs" class="absolute inset-0 -z-10 opacity-0 transition-opacity duration-500 overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-blue-500 rounded-full blur-[100px] opacity-20 animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-cyan-500 rounded-full blur-[100px] opacity-20 animate-blob"></div>
    </div>

    <!-- Card utama (login/register) -->
    <div class="relative w-full max-w-md p-6">
        <div class="auth-card shadow-2xl rounded-[40px] p-8 md:p-10">

            <!-- Header halaman -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-blue-600 rounded-full mx-auto text-3xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    🧺
                </div>
                <h2 id="pageTitle" class="text-2xl font-bold">Selamat Datang</h2>
                <p class="text-xs mt-2" style="color: var(--text-sub)">SCA Laundry Application</p>
            </div>

            <!-- Notifikasi error -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-xs mb-4">
                    <strong>Oops!</strong> {{ $errors->first() }}
                </div>
            @endif

            <!-- Wrapper kedua form -->
            <div class="relative overflow-hidden min-h-[300px]">

                <!-- Form Login -->
                <div id="loginForm" class="form-section show">
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold mb-1" style="color: var(--text-sub)">Email</label>
                            <input type="email" name="email" required class="auth-input w-full px-4 py-3 rounded-xl text-sm focus:ring-2 focus:ring-blue-500" placeholder="email@contoh.com">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-1" style="color: var(--text-sub)">Password</label>
                            <input type="password" name="password" required class="auth-input w-full px-4 py-3 rounded-xl text-sm focus:ring-2 focus:ring-blue-500" placeholder="••••••••">
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-blue-600 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 active:scale-95">
                            Masuk
                        </button>
                    </form>
                </div>

                <!-- Form Register -->
                <div id="registerForm" class="form-section hide-right">
                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold mb-1" style="color: var(--text-sub)">Nama Lengkap</label>
                            <input type="text" name="name" required class="auth-input w-full px-4 py-3 rounded-xl text-sm focus:ring-2 focus:ring-blue-500" placeholder="Nama Kamu">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-1" style="color: var(--text-sub)">Email</label>
                            <input type="email" name="email" required class="auth-input w-full px-4 py-3 rounded-xl text-sm focus:ring-2 focus:ring-blue-500" placeholder="email@contoh.com">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-1" style="color: var(--text-sub)">Password</label>
                            <input type="password" name="password" required class="auth-input w-full px-4 py-3 rounded-xl text-sm focus:ring-2 focus:ring-blue-500" placeholder="••••••••">
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-1" style="color: var(--text-sub)">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required class="auth-input w-full px-4 py-3 rounded-xl text-sm focus:ring-2 focus:ring-blue-500" placeholder="••••••••">
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-blue-600 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 active:scale-95">
                            Daftar Sekarang
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer switch -->
            <div class="mt-6 text-center pt-6 border-t" style="border-color: var(--border-color)">
                <p class="text-sm" style="color: var(--text-sub)">
                    <span id="questionText">Belum punya akun?</span>
                    <button onclick="toggleAuth()" class="text-blue-600 font-bold hover:underline ml-1" id="btnText">
                        Daftar di sini
                    </button>
                </p>
            </div>

        </div>
    </div>

    <!-- Tombol ubah tema -->
    <div class="fixed bottom-6 right-6">
        <button onclick="toggleTheme()" class="bg-white/10 backdrop-blur-md border border-white/20 text-blue-500 px-4 py-2 rounded-full text-xs font-bold hover:bg-white/20">
            🌓 Ganti Tema
        </button>
    </div>

    <script>
        /* Control mode tema */
        const body = document.getElementById('mainBody');
        const bgBlobs = document.getElementById('bgBlobs');

        function checkTheme() {
            const isGlass = localStorage.getItem('theme') === 'glass';
            body.classList.toggle('glass-mode', isGlass);
            bgBlobs.classList.toggle('opacity-0', !isGlass);
        }
        checkTheme();

        function toggleTheme() {
            const isGlass = body.classList.contains('glass-mode');
            localStorage.setItem('theme', isGlass ? 'normal' : 'glass');
            checkTheme();
        }

        /* Logic toggle login ↔ register */
        let isLogin = true;
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const pageTitle = document.getElementById('pageTitle');
        const questionText = document.getElementById('questionText');
        const btnText = document.getElementById('btnText');

        function toggleAuth() {
            isLogin = !isLogin;

            if (isLogin) {
                loginForm.classList.replace('hide-left', 'show');
                registerForm.classList.replace('show', 'hide-right');
                pageTitle.textContent = "Selamat Datang";
                questionText.textContent = "Belum punya akun?";
                btnText.textContent = "Daftar di sini";
            } else {
                loginForm.classList.replace('show', 'hide-left');
                registerForm.classList.replace('hide-right', 'show');
                pageTitle.textContent = "Buat Akun Baru";
                questionText.textContent = "Sudah punya akun?";
                btnText.textContent = "Login di sini";
            }
        }
    </script>

</body>
</html>
