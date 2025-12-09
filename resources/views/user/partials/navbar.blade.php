<nav id="navbar" class="fixed top-0 left-0 right-0 flex justify-between items-center px-6 md:px-16 py-5 z-50 backdrop-blur-md border-b transition-all duration-500 nav-style">
    
    <div class="text-2xl font-bold tracking-tight nav-logo-text">
        SCA Laundry
    </div>

    <div class="hidden md:flex space-x-8 text-sm font-medium nav-links">
        <a href="#home" class="hover:text-blue-500 transition">Home</a>
        <a href="#layanan" class="hover:text-blue-500 transition">Layanan</a>
        @auth <a href="#tracking" class="hover:text-blue-500 transition">Tracking</a> @endauth
        <a href="#order" class="hover:text-blue-500 transition">Pesan</a>
    </div>

    <div class="flex items-center gap-3">
        @auth
            <div class="hidden md:block text-right mr-2 nav-user-text">
                <p class="text-xs font-bold">Hi, {{ Auth::user()->name }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg text-xs font-bold border transition-all nav-btn-logout">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-lg text-sm font-bold transition border nav-btn-login">Login</a>
        @endauth

        <a href="#order" class="px-6 py-2.5 rounded-lg text-sm font-bold bg-blue-600 text-white shadow-lg hover:bg-blue-700 transition">
            Pesan
        </a>
    </div>
</nav>

<style>
    /* Default (Normal Mode) */
    .nav-style { background-color: rgba(255, 255, 255, 0.9); border-color: rgba(255, 255, 255, 0.2); color: #475569; }
    .nav-logo-text { color: #1d4ed8; } /* blue-700 */
    .nav-links { color: #475569; }
    .nav-user-text { color: #1e293b; }
    .nav-btn-logout { background-color: white; color: #ef4444; border-color: #fecaca; }
    .nav-btn-login { background-color: white; color: #475569; border-color: #e2e8f0; }

    /* Glass Mode*/
    body.glass-mode .nav-style { background-color: rgba(15, 23, 42, 0.6); border-color: rgba(255, 255, 255, 0.1); color: white; }
    body.glass-mode .nav-logo-text { color: #22d3ee; } /* cyan-400 */
    body.glass-mode .nav-links { color: #dbeafe; } /* blue-100 */
    body.glass-mode .nav-user-text { color: white; }
    body.glass-mode .nav-btn-logout { background-color: rgba(239, 68, 68, 0.2); color: #fca5a5; border-color: rgba(239, 68, 68, 0.5); }
    body.glass-mode .nav-btn-login { background-color: rgba(255, 255, 255, 0.05); color: white; border-color: transparent; }
</style>