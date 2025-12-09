<div class="w-full max-w-7xl mx-auto py-10 px-4 md:px-0">

    <!-- Header -->
    <div class="text-center mb-8 relative z-10">
        <h2 class="text-3xl font-bold transition-colors duration-500 dashboard-title">
            Dashboard Pelanggan
        </h2>
    </div>

    <!-- Profile Section -->
    <div class="w-full max-w-4xl mx-auto relative z-10">
        <div class="dashboard-card rounded-[40px] p-8 flex flex-col md:flex-row items-center gap-6 transition-all duration-500">
            
            <!-- Avatar -->
            <div class="w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-blue-500/30">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <!-- User Info -->
            <div class="flex-1 text-center md:text-left space-y-1">
                <h3 class="text-xl font-bold dashboard-text-primary">
                    {{ $user->name }}
                </h3>
                <p class="text-xs dashboard-text-muted">{{ $user->email }}</p>
                <p class="text-xs dashboard-text-muted">{{ $user->phone ?? '-' }}</p>
            </div>

            <!-- Stats -->
            <div class="flex gap-8 text-center mt-6 md:mt-0">
                
                <div class="group cursor-default">
                    <p class="font-bold text-2xl text-blue-500 transition-transform group-hover:-translate-y-1">
                        {{ $totalOrder }}
                    </p>
                    <p class="text-[10px] uppercase tracking-wider dashboard-text-muted">Total Order</p>
                </div>

                <div class="group cursor-default">
                    <p class="font-bold text-2xl text-green-500 transition-transform group-hover:-translate-y-1">
                        Rp {{ number_format($totalExpense / 1000, 0) }}k
                    </p>
                    <p class="text-[10px] uppercase tracking-wider dashboard-text-muted">Pengeluaran</p>
                </div>

                <div class="group cursor-default">
                    <p class="font-bold text-2xl text-yellow-500 transition-transform group-hover:-translate-y-1">
                        {{ $points }}
                    </p>
                    <p class="text-[10px] uppercase tracking-wider dashboard-text-muted">Poin</p>
                </div>

            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">

            <a href="#order" class="dashboard-card p-6 rounded-3xl flex items-center justify-between group hover:scale-[1.02] transition-transform">
                <div>
                    <h4 class="font-bold dashboard-text-primary">Buat Pesanan Baru</h4>
                    <p class="text-xs dashboard-text-muted">Laundry numpuk? Pesan sekarang.</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
            </a>

            <a href="#tracking" class="dashboard-card p-6 rounded-3xl flex items-center justify-between group hover:scale-[1.02] transition-transform">
                <div>
                    <h4 class="font-bold dashboard-text-primary">Riwayat Transaksi</h4>
                    <p class="text-xs dashboard-text-muted">Cek status laundry kamu.</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
            </a>

        </div>
    </div>
</div>

<style>
    .dashboard-title { color: #1e293b; }
    .dashboard-card { 
        background-color: white; 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid #f1f5f9;
    }
    .dashboard-text-primary { color: #1e293b; }
    .dashboard-text-muted { color: #64748b; }

    /* Glass Mode */
    body.glass-mode .dashboard-title { color: white; }
    body.glass-mode .dashboard-card {
        background-color: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }
    body.glass-mode .dashboard-text-primary { color: white; }
    body.glass-mode .dashboard-text-muted { color: #bfdbfe; }
    body.glass-mode .bg-blue-100 { background-color: rgba(37, 99, 235, 0.2); color: #93c5fd; }
    body.glass-mode .bg-green-100 { background-color: rgba(22, 163, 74, 0.2); color: #86efac; }
</style>
