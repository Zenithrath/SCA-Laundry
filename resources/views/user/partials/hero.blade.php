<section id="home" class="relative w-full min-h-screen flex items-center justify-center transition-colors duration-500 hero-section">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center w-full max-w-7xl mx-auto px-6 relative z-10 mt-16">
        
        <!-- Text Column -->
        <div class="space-y-6 text-center md:text-left z-10">
            <h1 class="text-4xl md:text-6xl font-bold leading-tight transition-colors duration-500 hero-title">
                Layanan Laundry <br />
                <span class="transition-colors duration-500 hero-highlight">
                    Terpercaya & Cepat
                </span>
            </h1>
            
            <p class="text-sm md:text-base leading-relaxed max-w-lg mx-auto md:mx-0 transition-colors duration-500 hero-desc">
                Nikmati kemudahan layanan laundry profesional dengan kualitas terbaik. Pakaian bersih, harum, dan siap pakai dalam waktu singkat.
            </p>

            <div class="flex space-x-4 justify-center md:justify-start pt-4">
                <a href="#order" 
                   class="px-8 py-3 rounded-xl text-sm font-semibold shadow-xl transition-transform hover:scale-105 flex items-center justify-center hero-btn-primary">
                    Pesan Sekarang
                </a>
                
                <a href="#layanan" 
                   class="px-8 py-3 rounded-xl text-sm font-semibold shadow-xl transition-transform hover:scale-105 flex items-center justify-center hero-btn-secondary">
                    Lihat Layanan
                </a>
            </div>
        </div>

        <!-- Image Column -->
        <div class="relative flex justify-center group mt-8 md:mt-0">
            <img 
                src="https://images.unsplash.com/photo-1610557892470-55d9e80c0bce?auto=format&fit=crop&w=800&q=80"
                alt="Laundry Service"
                class="rounded-[40px] shadow-2xl w-full h-72 md:h-[450px] object-cover z-10 relative transition-opacity duration-500 hero-img"
            />
            <div class="absolute -top-4 -right-4 w-full h-full rounded-[40px] -z-0 transition-colors duration-500 hero-img-deco"></div>
        </div>
    </div>
</section>

<style>
    /* Light Theme */
    .hero-section { background-color: transparent; }
    .hero-title { color: #1e293b; }
    .hero-highlight { color: #3b82f6; }
    .hero-desc { color: #64748b; }
    .hero-btn-primary { background-color: #1e3a8a; color: white; }
    .hero-btn-secondary { background-color: #334155; color: white; }
    .hero-img { opacity: 1; }
    .hero-img-deco { background-color: #bfdbfe; }

    /* Glass Mode (Dark) */
    body.glass-mode .hero-title { color: white; }
    body.glass-mode .hero-highlight {
        color: #22d3ee;
        filter: drop-shadow(0 0 15px rgba(34, 211, 238, 0.4));
    }
    body.glass-mode .hero-desc { color: #dbeafe; }
    body.glass-mode .hero-btn-primary {
        background-color: #0891b2;
        border: 1px solid rgba(34, 211, 238, 0.3);
    }
    body.glass-mode .hero-btn-secondary {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(12px);
    }
    body.glass-mode .hero-img { opacity: 0.9; }
    body.glass-mode .hero-img-deco {
        background-color: rgba(6, 182, 212, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>
