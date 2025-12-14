<section id="layanan"
    class="w-full min-h-screen snap-start flex flex-col justify-center items-center relative px-3 sm:px-6 md:px-16 py-16 sm:py-20 transition-colors duration-500 services-section animate-on-scroll">
    
    <div class="text-center mb-10 sm:mb-12 relative z-10">
        <h2 class="text-2xl sm:text-3xl font-bold transition-colors duration-500 services-title">
            Layanan Kami
        </h2>
    </div>

    <!-- GRID DIPERKETAT DI HP -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8 w-full max-w-6xl relative z-10">
        @foreach($services as $item)
            @php
                if ($item->image) {
                    $imgUrl = asset('storage/' . $item->image);
                } else {
                    $name = strtolower($item->name);
                    $imgUrl = "https://images.unsplash.com/photo-1582735689369-4fe89db7114c?q=80&w=500&auto=format&fit=crop";

                    if (str_contains($name, 'sepatu')) {
                        $imgUrl = "https://images.unsplash.com/photo-1603808033192-082d6919d3e1?q=80&w=500&auto=format&fit=crop";
                    } elseif (str_contains($name, 'express') || str_contains($name, 'kilat')) {
                        $imgUrl = "https://images.unsplash.com/photo-1517677208171-0bc12dd9743c?q=80&w=500&auto=format&fit=crop";
                    } elseif (str_contains($name, 'bedcover') || str_contains($name, 'selimut') || str_contains($name, 'karpet')) {
                        $imgUrl = "https://images.unsplash.com/photo-1512918760532-3ea50d82175d?q=80&w=500&auto=format&fit=crop";
                    } elseif (str_contains($name, 'setrika')) {
                        $imgUrl = "https://images.unsplash.com/photo-1585664811087-47f65be1bac6?q=80&w=500&auto=format&fit=crop";
                    }
                }
            @endphp

            <!-- CARD DIPERKECIL DI HP -->
            <div
                class="services-card p-3 sm:p-5 md:p-6 rounded-[22px] sm:rounded-[30px] text-center flex flex-col items-center border relative group transition-all duration-500 overflow-hidden">

                <!-- GAMBAR DIPENDEKIN -->
                <div class="w-full h-28 sm:h-40 md:h-48 rounded-2xl sm:rounded-3xl mb-4 sm:mb-6 overflow-hidden relative shadow-sm bg-white">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-all z-10"></div>
                    <img src="{{ $imgUrl }}"
                         alt="{{ $item->name }}"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                </div>

                <!-- JUDUL DIKECILIN -->
                <h3 class="text-sm sm:text-lg md:text-xl font-bold mb-1 transition-colors duration-500 services-item-title line-clamp-2">
                    {{ $item->name }}
                </h3>

                <!-- HARGA -->
                <p class="text-xs sm:text-sm font-bold mb-4 sm:mb-6 transition-colors duration-500 services-price">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                    <span class="text-[10px] sm:text-xs font-normal">{{ $item->unit }}</span>
                </p>

                <!-- TOMBOL -->
                <a href="#order"
                   class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-bold mt-auto w-full transition duration-500 flex items-center justify-center services-btn shadow">
                    Pesan
                </a>
            </div>
        @endforeach
    </div>
</section>

<style>
    /* Normal Mode */
    .services-section { background-color: #f1f5f9; }
    .services-title { color: #1e293b; }

    .services-card {
        background-color: #e0f2fe;
        border: 1px solid rgba(255,255,255,0.5);
    }

    .services-item-title { color: #1e40af; }
    .services-price { color: #2563eb; }

    .services-btn {
        background-color: #1e3a8a;
        color: white;
    }

    /* Glass Mode */
    body.glass-mode .services-section { background-color: transparent; }
    body.glass-mode .services-title { color: white; }

    body.glass-mode .services-card {
        background-color: rgba(30, 41, 59, 0.6);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    body.glass-mode .services-item-title { color: white; }
    body.glass-mode .services-price { color: #22d3ee; }

    body.glass-mode .services-btn {
        background-color: #0891b2;
    }
</style>
