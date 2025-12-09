<footer class="w-full pt-16 pb-6 px-6 md:px-16 border-t transition-colors duration-500 footer-section">

    <!-- Brand -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 w-full max-w-7xl mx-auto mb-10">
        
        <div class="col-span-1 md:col-span-2">
            <h3 class="text-2xl font-bold mb-4 footer-title">SCA Laundry</h3>
            <p class="text-sm leading-relaxed footer-text">
                Solusi laundry premium dengan pelayanan cepat, bersih, dan wangi untuk pakaian kesayangan Anda.
            </p>
        </div>

        <!-- Links -->
        <div>
            <h4 class="font-bold mb-4 footer-subtitle">Tautan</h4>
            <ul class="space-y-2 text-sm footer-text">
                <li><a href="{{ route('landing') }}" class="hover:underline">Beranda</a></li>
                <li><a href="#order" class="hover:underline">Pesan Jasa</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div>
            <h4 class="font-bold mb-4 footer-subtitle">Hubungi Kami</h4>
            <p class="text-sm footer-text">
                Jalan Sigura-gura<br>
                scalaundry@gmail.com<br>
                087783923671
            </p>
        </div>
    </div>

    <!-- Copyright -->
    <div class="border-t w-full text-center pt-8 text-[10px] footer-copyright">
        &copy; {{ date('Y') }} SCA Laundry. All rights reserved.
    </div>
</footer>

<style>
    .footer-section {
        background-color: white;
        border-color: #f3f4f6;
        color: #1e293b;
    }
    .footer-title { color: #2563eb; }
    .footer-subtitle { color: #1e293b; }
    .footer-text { color: #64748b; }
    .footer-copyright {
        border-color: #f3f4f6;
        color: #94a3b8;
    }

    body.glass-mode .footer-section {
        background-color: #0f172a;
        border-color: rgba(255, 255, 255, 0.1);
        color: white;
    }
    body.glass-mode .footer-title { color: #22d3ee; }
    body.glass-mode .footer-subtitle { color: white; }
    body.glass-mode .footer-text { color: #bfdbfe; }
    body.glass-mode .footer-copyright {
        border-color: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.4);
    }
</style>
