<div id="sidebar" class="w-20 md:w-64 fixed top-0 left-0 h-full z-50 transition-all duration-300 flex flex-col justify-between bg-slate-900 text-white border-r border-white/5 shadow-2xl overflow-y-auto">
    
    <!-- Header -->
    <div class="shrink-0">
        <div class="h-20 flex items-center justify-center md:justify-start md:px-8 border-b border-white/10 bg-slate-900 sticky top-0 z-10">
            <span class="hidden md:block font-bold text-xl tracking-wide">SCA Admin</span>
            <span class="block md:hidden font-bold text-xl">SCA</span>
        </div>

        <!-- Navigasi Menu -->
        <nav class="mt-6 space-y-2 px-3">

            <a href="{{ route('admin.dashboard') }}" 
               class="w-full flex items-center p-3 rounded-xl transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-600 text-white shadow-lg' : 'hover:bg-white/10 hover:text-white text-slate-400' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="hidden md:block text-sm font-medium">Dashboard</span>
            </a>

            <a href="{{ route('admin.customers') }}" 
               class="w-full flex items-center p-3 rounded-xl transition-all group {{ request()->routeIs('admin.customers') ? 'bg-cyan-600 text-white shadow-lg' : 'hover:bg-white/10 hover:text-white text-slate-400' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <span class="hidden md:block text-sm font-medium">Pelanggan</span>
            </a>

            <a href="{{ route('admin.services') }}" 
               class="w-full flex items-center p-3 rounded-xl transition-all group {{ request()->routeIs('admin.services') ? 'bg-cyan-600 text-white shadow-lg' : 'hover:bg-white/10 hover:text-white text-slate-400' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                <span class="hidden md:block text-sm font-medium">Layanan</span>
            </a>

            <a href="{{ route('admin.finance') }}" 
               class="w-full flex items-center p-3 rounded-xl transition-all group {{ request()->routeIs('admin.finance') ? 'bg-cyan-600 text-white shadow-lg' : 'hover:bg-white/10 hover:text-white text-slate-400' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="hidden md:block text-sm font-medium">Keuangan</span>
            </a>

        </nav>
    </div>

    <!-- Footer (Theme + Logout) -->
    <div class="p-4 space-y-3 border-t border-white/5 bg-slate-900 shrink-0">

        <button onclick="window.toggleTheme()" class="w-full py-3 rounded-xl text-xs font-bold border flex justify-center items-center gap-2 bg-white/5 border-white/10 text-slate-300 hover:bg-white/10 transition-all">
            <span class="hidden md:inline">Ganti Tema</span>
            <span class="md:hidden">🌓</span>
        </button>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full py-3 rounded-xl text-xs font-bold bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all flex justify-center items-center gap-2 border border-red-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="hidden md:inline">Logout</span>
            </button>
        </form>

    </div>
</div>
