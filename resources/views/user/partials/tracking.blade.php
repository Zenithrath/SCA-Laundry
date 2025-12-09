@if($order)
<section id="tracking" class="w-full py-20 px-4 relative overflow-hidden transition-colors duration-500 tracking-section">
    
    <!-- Background glow khusus mode glass -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-900/20 rounded-full blur-[120px] pointer-events-none glow-effect opacity-0 transition-opacity"></div>

    <div class="relative z-10 max-w-5xl mx-auto">
        
        <!-- Header Tracking -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold mb-2 tracking-title">Tracking Pesanan Anda</h2>
            <p class="text-sm tracking-subtitle">Pantau progress cucian Anda secara real-time</p>
        </div>

        <!-- Card utama tracking -->
        <div class="tracking-card backdrop-blur-xl border rounded-[35px] p-8 md:p-10 shadow-2xl transition-all duration-500">
            
            <!-- Informasi Order -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b pb-6 tracking-border">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h3 class="text-2xl font-bold tracking-text-main">Order #{{ $order->order_code ?? $order->id }}</h3>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-yellow-500/20 text-yellow-500 border border-yellow-500/30">
                            {{ $order->status }}
                        </span>
                    </div>

                    <p class="text-sm tracking-text-sub">
                        {{ $order->service->name ?? 'Layanan' }} • {{ $order->weight }}kg
                    </p>
                </div>

                <div class="mt-4 md:mt-0 text-right">
                    <h3 class="text-2xl font-bold text-cyan-500">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </h3>
                    <p class="text-[10px] tracking-text-sub">Progress loyalitas: 7/10</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                
                <!-- Kolom kiri -->
                <div class="space-y-8">

                    <!-- Progress Bar Status -->
                    <div>
                        <div class="flex justify-between text-sm font-bold tracking-text-sub mb-2">
                            <span>Progress Cucian</span>
                        </div>

                        <div class="w-full h-3 rounded-full overflow-hidden tracking-bg-bar">
                            @php
                                // Menentukan progress berdasarkan nilai status
                                $statuses = ["Menunggu", "Dicuci", "Disetrika", "Selesai"];
                                $currentStep = array_search($order->status, $statuses);
                                if($currentStep === false) $currentStep = 0;

                                $width = (($currentStep + 1) / count($statuses)) * 100;
                            @endphp

                            <div class="h-full bg-cyan-500 rounded-full shadow-[0_0_10px_rgba(6,182,212,0.6)]" 
                                 style="width: {{ $width }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Estimasi selesai -->
                    <div class="rounded-2xl p-6 border tracking-box">
                        <p class="text-xs mb-1 tracking-text-sub">Estimasi Selesai :</p>
                        <h4 class="text-3xl font-bold tracking-text-main">2 Jam Lagi!</h4>
                    </div>
                </div>

                <!-- Kolom kanan: Timeline -->
                <div class="relative">
                    <h4 class="text-sm font-bold mb-6 tracking-text-sub">Timeline Progress :</h4>

                    <div class="space-y-6 relative pl-2">
                        <!-- Garis vertical timeline -->
                        <div class="absolute left-[19px] top-2 bottom-4 w-0.5 tracking-line"></div>

                        @foreach($statuses as $index => $status)
                            @php $isDone = $index <= $currentStep; @endphp

                            <div class="flex items-center gap-4 relative z-10">
                                
                                <!-- Bullet timeline -->
                                <div class="w-8 h-8 rounded-full flex items-center justify-center border-2 transition-all
                                    {{ $isDone 
                                        ? 'bg-green-500 border-green-500 text-white shadow-[0_0_10px_rgba(34,197,94,0.5)]' 
                                        : 'tracking-bullet text-slate-400' }}">
                                    @if($isDone) ✓ @else • @endif
                                </div>

                                <!-- Label step -->
                                <div>
                                    <p class="text-sm font-bold {{ $isDone ? 'tracking-text-highlight' : 'tracking-text-sub' }}">
                                        {{ $status }}
                                    </p>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
    /* Normal Mode */
    .tracking-section { background-color: #f1f5f9; }
    .tracking-title { color: #1e293b; }
    .tracking-subtitle { color: #64748b; }
    .tracking-card { background-color: white; border-color: #e2e8f0; }
    .tracking-border { border-color: #e2e8f0; }
    .tracking-text-main { color: #1e293b; }
    .tracking-text-sub { color: #64748b; }
    .tracking-bg-bar { background-color: #e2e8f0; }
    .tracking-box { background-color: #f8fafc; border-color: #e2e8f0; }
    .tracking-line { background-color: #e2e8f0; }
    .tracking-bullet { background-color: white; border-color: #cbd5e1; }
    .tracking-text-highlight { color: #1e293b; }

    /* Glass Mode */
    body.glass-mode .tracking-section { background-color: #0B1120; }
    body.glass-mode .glow-effect { opacity: 1; }
    body.glass-mode .tracking-title { color: white; }
    body.glass-mode .tracking-subtitle { color: #94a3b8; }
    body.glass-mode .tracking-card { background-color: rgba(31, 41, 55, 0.7); border-color: rgba(255, 255, 255, 0.05); }
    body.glass-mode .tracking-border { border-color: rgba(255, 255, 255, 0.05); }
    body.glass-mode .tracking-text-main { color: white; }
    body.glass-mode .tracking-text-sub { color: #94a3b8; }
    body.glass-mode .tracking-bg-bar { background-color: #111827; }
    body.glass-mode .tracking-box { background-color: rgba(17, 24, 39, 0.5); border-color: rgba(255, 255, 255, 0.05); }
    body.glass-mode .tracking-line { background-color: #374151; }
    body.glass-mode .tracking-bullet { background-color: #111827; border-color: #374151; }
    body.glass-mode .tracking-text-highlight { color: white; }
</style>
@endif
