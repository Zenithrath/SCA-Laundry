<div class="space-y-6 animate-fade-in">

    <!-- Dashboard Header -->
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Dashboard Overview</h2>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Pesanan Belum Selesai -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[30px] shadow-lg border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-xl transition-shadow">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 001-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                </svg>
            </div>
            
            <p class="text-xs uppercase font-bold text-slate-500 dark:text-slate-400 tracking-wider">Pesanan Belum Selesai</p>
            <h3 class="text-4xl font-bold mt-2 text-orange-500">{{ $unfinishedCount }}</h3>
            <p class="text-xs mt-2 text-slate-400">Perlu tindakan segera</p>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[30px] shadow-lg border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-xl transition-shadow">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                </svg>
            </div>

            <p class="text-xs uppercase font-bold text-slate-500 dark:text-slate-400 tracking-wider">Total Pendapatan</p>
            <h3 class="text-4xl font-bold mt-2 text-green-500">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
            <p class="text-xs mt-2 text-slate-400">Akumulasi semua order</p>
        </div>

        <!-- Total Pesanan -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[30px] shadow-lg border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-xl transition-shadow">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
            </div>

            <p class="text-xs uppercase font-bold text-slate-500 dark:text-slate-400 tracking-wider">Total Pesanan</p>
            <h3 class="text-4xl font-bold mt-2 text-blue-600">{{ $totalOrders }}</h3>
            <p class="text-xs mt-2 text-slate-400">Total transaksi tercatat</p>
        </div>

    </div>
</div>
