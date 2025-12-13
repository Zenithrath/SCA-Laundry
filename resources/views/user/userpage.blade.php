@extends('app')

@section('content')
<div class="w-full font-sans transition-colors duration-500 relative overflow-x-hidden landing-container">
    @include('user.partials.navbar')

    <div class="animate-on-scroll">
        @include('user.partials.hero')
    </div>

    <div>
        @include('user.partials.services') 
    </div>

    <div id="order" class="animate-on-scroll w-full min-h-screen snap-start flex flex-col justify-center items-center py-20 px-4 md:px-0">
        @include('user.partials.bookingform') 
    </div>

    @auth
        @if($latestOrder)
            <div class="animate-on-scroll">
                @include('user.partials.tracking', ['order' => $latestOrder])
            </div>
        @endif
        
        <div class="animate-on-scroll py-20">
            @include('user.partials.dashboard')
        </div>
    @else
        <section class="py-24 text-center flex flex-col items-center justify-center transition-colors duration-500 animate-on-scroll guest-cta">
            <h2 class="text-3xl font-bold mb-4 cta-title">
                Pantau Cucianmu Sekarang
            </h2>
            <p class="mb-8 cta-subtitle">
                Login untuk melihat Tracking dan Dashboard Pelanggan
            </p>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:scale-105 transition transform">
                Login Sekarang
            </a>
        </section>
    @endauth

    @include('user.partials.footer')

    <div class="fixed bottom-6 right-6 z-50">
        <button onclick="window.toggleTheme()" class="bg-white px-4 py-2 rounded-full shadow-lg text-xs font-bold text-blue-900 border border-blue-100 hover:scale-105 transition-transform">
            Toggle Theme
        </button>
    </div>
<div></div>
</div>

<style>
    /* Styling Dasar Glass Mode */
    body.glass-mode .landing-container { background-color: #0f172a; color: white; }
    body.glass-mode .guest-cta { background-color: rgba(255, 255, 255, 0.05); }
    body.glass-mode .cta-title { color: white; }
    body.glass-mode .cta-subtitle { color: #bfdbfe; }
    
    .animate-on-scroll {
        opacity: 0; transform: translateY(30px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }
    .animate-on-scroll.is-visible { opacity: 1; transform: translateY(0); }
</style>

<script>
    // Script Scroll Animation
    document.addEventListener("DOMContentLoaded", function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('is-visible');
            });
        });
        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    });
</script>
@endsection