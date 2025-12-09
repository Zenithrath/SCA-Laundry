<section id="layanan" class="w-full min-h-screen snap-start flex flex-col justify-center items-center relative px-6 md:px-16 py-20 transition-colors duration-500 services-section animate-on-scroll">
    
    <div class="text-center mb-12 relative z-10">
        <h2 class="text-3xl font-bold transition-colors duration-500 services-title">
            Layanan Kami
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl relative z-10">
        @foreach($services as $item)
            @php
                // Logika penentuan gambar layanan

                if ($item->image) {
                    // Gambar upload dari database
                    $imgUrl = asset('storage/' . $item->image);

                } else {
                    // Fallback image berdasarkan nama layanan
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

            <div class="services-card p-6 rounded-[35px] text-center flex flex-col items-center border relative group transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
                
                <!-- Gambar layanan -->
                <div class="w-full h-48 rounded-3xl mb-6 overflow-hidden relative shadow-sm bg-white">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-all z-10"></div>
                    <img src="{{ $imgUrl }}" alt="{{ $item->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                </div>

                <!-- Nama layanan -->
                <h3 class="text-xl font-bold mb-1 transition-colors duration-500 services-item-title line-clamp-1" title="{{ $item->name }}">
                    {{ $item->name }}
                </h3>

                <!-- Harga -->
                <p class="text-sm font-bold mb-6 transition-colors duration-500 services-price">
                    Rp {{ number_format($item->price, 0, ',', '.') }} 
                    <span class="text-xs font-normal">{{ $item->unit }}</span>
                </p>

                <!-- Tombol pesan -->
                <a href="#order" class="px-8 py-3 rounded-xl text-xs font-bold mt-auto w-full transition duration-500 flex items-center justify-center services-btn shadow-lg">
                    Pesan Sekarang
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
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
    }
    .services-card:hover { 
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); 
    }
    
    .services-item-title { color: #1e40af; }
    .services-price { color: #2563eb; }
    
    .services-btn { 
        background-color: #1e3a8a; 
        color: white; 
    }
    .services-btn:hover { background-color: #1e40af; }

    /* Glass Mode */
    body.glass-mode .services-section { background-color: transparent; }
    body.glass-mode .services-title { color: white; }
    
    body.glass-mode .services-card { 
        background-color: rgba(30, 41, 59, 0.6);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px 0 rgba(0,0,0,0.37);
    }
    
    body.glass-mode .services-item-title { color: white; }
    body.glass-mode .services-price { color: #22d3ee; }
    
    body.glass-mode .services-btn { 
        background-color: #0891b2;
        color: white;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.2);
    }
    body.glass-mode .services-btn:hover { 
        background-color: #06b6d4; 
        transform: scale(1.02); 
    }
</style>
