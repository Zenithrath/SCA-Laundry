<!-- Wrapper Utama: Tanpa relative/z-index agar tidak menimbun tombol fixed -->
<div class="w-full max-w-4xl mx-auto booking-wrapper">
    
    <!-- Header Text -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold mb-2 transition-colors duration-500 booking-title">Pesan Laundry Online</h2>
        <p class="text-sm transition-colors duration-500 booking-subtitle">Pesan layanan laundry dengan mudah, tanpa perlu datang ke tempat</p>
    </div>

    <!-- MAIN CARD FORM -->
    <div class="rounded-[30px] p-6 md:p-10 shadow-2xl transition-all duration-500 border booking-card">
        
        <!-- Judul Dalam Card -->
        <div class="text-center mb-8">
            <h3 class="text-xl font-bold transition-colors duration-500 booking-card-title">Form Pemesanan</h3>
            <p class="text-xs mt-1 transition-colors duration-500 booking-subtitle">Isi form di bawah untuk memesan layanan laundry</p>
        </div>

        <!-- Stepper -->
        <div class="flex rounded-full p-1.5 mb-8 w-full transition-colors duration-500 booking-stepper-container">
            <button type="button" onclick="goToStep(1)" id="btnStep1" class="step-btn flex-1 py-2 rounded-full text-[10px] md:text-xs font-bold transition-all duration-300">Layanan</button>
            <button type="button" onclick="goToStep(2)" id="btnStep2" class="step-btn flex-1 py-2 rounded-full text-[10px] md:text-xs font-bold transition-all duration-300">Penjemputan</button>
            <button type="button" onclick="goToStep(3)" id="btnStep3" class="step-btn flex-1 py-2 rounded-full text-[10px] md:text-xs font-bold transition-all duration-300">Data Diri</button>
            <button type="button" onclick="goToStep(4)" id="btnStep4" class="step-btn flex-1 py-2 rounded-full text-[10px] md:text-xs font-bold transition-all duration-300">Pembayaran</button>
        </div>

        <!-- Form Area -->
        <form id="bookingForm" onsubmit="submitOrder(event)" class="flex flex-col">
            @csrf
            <input type="hidden" name="service_id" id="inputServiceId">
            <input type="hidden" name="service_price" id="inputServicePrice" value="0">
            <input type="hidden" id="userPoints" value="{{ auth()->user() ? auth()->user()->points : 0 }}">

            <!-- Step 1: Layanan -->
            <div id="step1" class="step-content flex-1 flex flex-col">
                <p class="text-sm font-bold mb-4 ml-1 booking-label">Pilih Jenis Layanan :</p>
                
                <!-- Grid Layanan -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                    @foreach($services as $svc)
                    <div onclick="selectService({{ $svc->id }}, '{{ $svc->name }}', {{ $svc->price }})" 
                            id="service-card-{{ $svc->id }}" 
                            class="service-selection-card cursor-pointer rounded-2xl p-5 text-center transition-all duration-300 border border-transparent shadow-sm group relative overflow-hidden">
                            
                        <!-- Nama Layanan -->
                        <h4 class="font-bold text-sm mb-1 transition-colors booking-card-title">{{ $svc->name }}</h4>
                        
                        <!-- Harga -->
                        <p class="text-sm font-bold booking-price">
                            Rp {{ number_format($svc->price, 0, ',', '.') }}<span class="text-[11px] font-normal opacity-70">/kg</span>
                        </p>
                        
                        <!-- Deskripsi -->
                        <p class="text-[10px] mt-2 booking-subtitle">Cuci + keringkan</p>
                    </div>
                    @endforeach
                </div>

                <!-- Input Estimasi & Catatan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-auto">
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1 booking-label">Estimasi Berat (Kg)</label>
                        <input type="number" id="inputWeight" name="weight" oninput="calculateTotal()" placeholder="0" 
                            class="w-full rounded-xl px-4 py-3 text-sm border-none focus:ring-2 transition-colors booking-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1 booking-label">Catatan Khusus</label>
                        <input type="text" name="notes" placeholder="Contoh: Jangan disetrika" 
                            class="w-full rounded-xl px-4 py-3 text-sm border-none focus:ring-2 transition-colors booking-input">
                    </div>
                </div>
            </div>

            <!-- Step 2: Penjemputan -->
            <div id="step2" class="step-content hidden flex-1 flex flex-col">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1 booking-label">Alamat Penjemputan</label>
                        <textarea id="pickupAddress" name="pickup_address" rows="5" placeholder="Alamat lengkap..." 
                            class="w-full rounded-xl px-4 py-3 text-sm border-none focus:ring-2 transition-colors booking-input"></textarea>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold mb-2 ml-1 booking-label">Tanggal Jemput</label>
                            <input type="date" id="pickupDate" name="pickup_date" 
                                class="w-full rounded-xl px-4 py-3 text-sm border-none focus:ring-2 transition-colors booking-input">
                        </div>
                        <div>
                            <label class="block text-xs font-bold mb-2 ml-1 booking-label">Waktu Jemput</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="pickup_time" value="Pagi" checked class="peer sr-only">
                                    <div class="rounded-xl p-3 text-center transition-all border border-transparent booking-radio peer-checked:ring-2">
                                        <span class="text-xs font-bold booking-radio-text">Pagi</span>
                                        <p class="text-[9px] booking-subtitle">08.00 - 12.00</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="pickup_time" value="Siang" class="peer sr-only">
                                    <div class="rounded-xl p-3 text-center transition-all border border-transparent booking-radio peer-checked:ring-2">
                                        <span class="text-xs font-bold booking-radio-text">Siang</span>
                                        <p class="text-[9px] booking-subtitle">13.00 - 17.00</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Data Diri -->
            <div id="step3" class="step-content hidden flex-1 flex flex-col">
                <div class="space-y-5 max-w-md mx-auto w-full">
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1 booking-label">Nama Lengkap</label>
                        <input type="text" id="inputName" name="name" value="{{ auth()->user()->name ?? '' }}" 
                            class="w-full rounded-xl px-4 py-3 text-sm border-none focus:ring-2 transition-colors booking-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1 booking-label">Nomor HP / WA</label>
                        <input type="tel" id="inputPhone" name="phone" value="{{ auth()->user()->phone ?? '' }}" 
                            class="w-full rounded-xl px-4 py-3 text-sm border-none focus:ring-2 transition-colors booking-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1 booking-label">Email (Opsional)</label>
                        <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" 
                            class="w-full rounded-xl px-4 py-3 text-sm border-none focus:ring-2 transition-colors booking-input">
                    </div>
                </div>
            </div>

            <!-- Step 4: Ringkasan -->
            <div id="step4" class="step-content hidden flex-1 flex flex-col items-center justify-center">
                <div class="w-full max-w-sm rounded-2xl p-6 border transition-colors booking-summary-card">
                    <h4 class="font-bold mb-4 text-center booking-card-title">Ringkasan Pesanan</h4>
                    <div id="pointStatus" class="text-center mb-4 text-[10px] font-bold py-2 px-3 rounded-lg bg-yellow-100 text-yellow-700 hidden border border-yellow-200"></div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm booking-subtitle">
                            <span id="summaryService">Layanan</span>
                            <span id="summaryPrice" class="font-semibold">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm booking-subtitle">
                            <span>Antar Jemput</span>
                            <span class="font-semibold">Rp 10.000</span>
                        </div>
                        <div id="discountRow" class="flex justify-between text-sm font-bold hidden booking-discount">
                            <span>Diskon Poin</span>
                            <span id="summaryDiscount">-Rp 0</span>
                        </div>
                        <div class="border-t pt-3 mt-2 flex justify-between text-lg font-bold booking-total-row">
                            <span>Total Bayar</span>
                            <span id="summaryGrandTotal" class="booking-grand-total">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center mt-auto pt-8">
                <button type="button" onclick="changeStep(-1)" id="btnBack" class="invisible px-6 py-2 rounded-xl text-sm font-bold transition-colors booking-btn-back">Kembali</button>
                <button type="button" onclick="changeStep(1)" id="btnNext" class="px-10 py-3 rounded-xl font-bold shadow-lg transition-all active:scale-95 text-sm booking-btn-primary">Lanjut</button>
                <button type="submit" id="btnSubmit" class="hidden px-10 py-3 rounded-xl font-bold shadow-lg transition-all active:scale-95 text-sm bg-green-600 hover:bg-green-700 text-white shadow-green-500/30">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* =========================================
       NORMAL MODE (Light - Biru Muda & Putih)
       ========================================= */
    .booking-wrapper { background-color: transparent; } /* Transparan agar tidak nutup background parent */
    .booking-title { color: #1e293b; } /* Slate-800 */
    .booking-subtitle { color: #64748b; } /* Slate-500 */
    
    .booking-card {
        background-color: #ffffff;
        border-color: #f1f5f9; /* Slate-100 */
    }
    .booking-card-title { color: #1e293b; }

    /* Stepper */
    .booking-stepper-container { background-color: #f1f5f9; } /* Slate-100 */
    .step-btn { color: #64748b; } /* Inactive text */
    .step-btn.active {
        background-color: #ffffff;
        color: #1e293b;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    /* Inputs */
    .booking-label { color: #334155; } /* Slate-700 */
    .booking-input {
        background-color: #f1f5f9; /* Slate-100 */
        color: #1e293b;
    }
    .booking-input:focus { outline: 2px solid #60a5fa; } /* Blue-400 */
    .booking-input::placeholder { color: #94a3b8; }

    /* Service Card (Pilihan) */
    .service-selection-card {
        background-color: #dbeafe; /* Blue-100 - SESUAI REQUEST */
        border-color: transparent;
    }
    .service-selection-card.active {
        background-color: #bfdbfe; /* Blue-200 */
        border-color: #3b82f6; /* Blue-500 */
        transform: scale(1.05);
    }
    .booking-price { color: #334155; }

    /* Radio Inputs (Waktu Jemput) */
    .booking-radio { background-color: #f1f5f9; }
    .booking-radio-text { color: #334155; }
    .peer-checked:checked ~ .booking-radio {
        background-color: #dbeafe; /* Blue-100 */
        outline: 2px solid #60a5fa;
    }

    /* Summary */
    .booking-summary-card {
        background-color: #eff6ff; /* Blue-50 */
        border-color: #dbeafe;
    }
    .booking-discount { color: #16a34a; }
    .booking-total-row { border-top-color: #cbd5e1; color: #1e293b; }
    .booking-grand-total { color: #2563eb; } /* Blue-600 */

    /* Buttons */
    .booking-btn-back { color: #94a3b8; }
    .booking-btn-back:hover { color: #475569; }
    .booking-btn-primary {
        background-color: #2563eb; /* Blue-600 */
        color: white;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }
    .booking-btn-primary:hover { background-color: #1d4ed8; }

    /* =========================================
       GLASS MODE (Dark - Navy & Cyan)
       ========================================= */
    body.glass-mode .booking-wrapper { background-color: transparent; }
    body.glass-mode .booking-title { color: white; }
    body.glass-mode .booking-subtitle { color: #94a3b8; } /* Slate-400 */
    
    body.glass-mode .booking-card {
        background-color: rgba(30, 41, 59, 0.6); /* Slate-800 opacity */
        backdrop-filter: blur(12px);
        border-color: rgba(255, 255, 255, 0.1);
    }
    body.glass-mode .booking-card-title { color: white; }

    /* Stepper */
    body.glass-mode .booking-stepper-container { background-color: rgba(15, 23, 42, 0.5); }
    body.glass-mode .step-btn { color: #94a3b8; }
    body.glass-mode .step-btn.active {
        background-color: #0891b2; /* Cyan-600 */
        color: white;
        box-shadow: 0 4px 6px -1px rgba(8, 145, 178, 0.4);
    }

    /* Inputs */
    body.glass-mode .booking-label { color: #cbd5e1; } /* Slate-300 */
    body.glass-mode .booking-input {
        background-color: rgba(51, 65, 85, 0.5); /* Slate-700 opacity */
        color: white;
    }
    body.glass-mode .booking-input:focus { outline: 2px solid #22d3ee; } /* Cyan-400 */
    body.glass-mode .booking-input::placeholder { color: #64748b; }

    /* Service Card */
    body.glass-mode .service-selection-card {
        background-color: rgba(15, 23, 42, 1); /* Very Dark */
        border-color: rgba(255,255,255,0.05);
    }
    body.glass-mode .service-selection-card.active {
        background-color: rgba(15, 23, 42, 1);
        border-color: #06b6d4; /* Cyan-500 */
        box-shadow: 0 0 15px rgba(6, 182, 212, 0.2);
    }
    body.glass-mode .booking-price { color: #cbd5e1; }

    /* Radio Inputs */
    body.glass-mode .booking-radio { background-color: rgba(51, 65, 85, 0.5); }
    body.glass-mode .booking-radio-text { color: white; }
    body.glass-mode .peer-checked:checked ~ .booking-radio {
        background-color: rgba(8, 145, 178, 0.3);
        outline: 2px solid #22d3ee;
    }

    /* Summary */
    body.glass-mode .booking-summary-card {
        background-color: #0f172a;
        border-color: #334155;
    }
    body.glass-mode .booking-discount { color: #4ade80; }
    body.glass-mode .booking-total-row { border-top-color: #475569; color: white; }
    body.glass-mode .booking-grand-total { color: #22d3ee; } /* Cyan-400 */

    /* Buttons */
    body.glass-mode .booking-btn-back { color: #94a3b8; }
    body.glass-mode .booking-btn-back:hover { color: #cbd5e1; }
    body.glass-mode .booking-btn-primary {
        background-color: #0891b2; /* Cyan-600 */
        color: white;
        box-shadow: 0 10px 15px -3px rgba(8, 145, 178, 0.3);
    }
    body.glass-mode .booking-btn-primary:hover { background-color: #0e7490; }
</style>

<script>
    let currentStep = 1;
    let selectedService = { id: null, price: 0, name: '' };

    document.addEventListener("DOMContentLoaded", () => updateNavigationUI());

    function updateNavigationUI() {
        // Toggle Visibility Step
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(`step${currentStep}`).classList.remove('hidden');

        // Toggle Style Stepper
        document.querySelectorAll('.step-btn').forEach((btn, i) => {
            if (i + 1 === currentStep) {
                btn.classList.add('active'); // CSS yang handle warnanya
            } else {
                btn.classList.remove('active');
            }
        });

        // Toggle Buttons Navigation
        const btnBack = document.getElementById('btnBack');
        const btnNext = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');

        btnBack.classList.toggle('invisible', currentStep === 1);
        
        if (currentStep === 4) {
            btnNext.classList.add('hidden');
            btnSubmit.classList.remove('hidden');
            calculateTotal();
        } else {
            btnNext.classList.remove('hidden');
            btnSubmit.classList.add('hidden');
        }
    }

    function changeStep(dir) {
        if (currentStep === 1 && dir === 1) {
            if (!document.getElementById('inputServiceId').value) return alert('Silakan pilih jenis layanan.');
            if (!document.getElementById('inputWeight').value) return alert('Silakan isi estimasi berat.');
        }
        if (currentStep === 2 && dir === 1) {
            if (!document.getElementById('pickupAddress').value) return alert('Alamat penjemputan wajib diisi.');
            if (!document.getElementById('pickupDate').value) return alert('Tanggal penjemputan wajib diisi.');
        }
        if (currentStep === 3 && dir === 1) {
            if (!document.getElementById('inputName').value) return alert('Nama wajib diisi.');
            if (!document.getElementById('inputPhone').value) return alert('Nomor HP wajib diisi.');
        }
        goToStep(currentStep + dir);
    }

    function goToStep(val) {
        if (val < 1 || val > 4) return;
        currentStep = val;
        updateNavigationUI();
    }

    function selectService(id, name, price) {
        selectedService = { id, name, price };
        document.getElementById('inputServiceId').value = id;
        document.getElementById('inputServicePrice').value = price;

        // Reset semua card
        document.querySelectorAll('.service-selection-card').forEach(el => {
            el.classList.remove('active');
        });

        // Set active card
        const activeCard = document.getElementById(`service-card-${id}`);
        if(activeCard) activeCard.classList.add('active');
        
        calculateTotal();
    }

    function calculateTotal() {
        const weight = parseInt(document.getElementById('inputWeight').value) || 0;
        const subtotal = selectedService.price * weight;
        let total = subtotal + 10000; // Biaya antar
        let points = parseInt(document.getElementById('userPoints').value) || 0;
        
        const discountRow = document.getElementById('discountRow');
        const pointStatus = document.getElementById('pointStatus');
        
        discountRow.classList.add('hidden');
        pointStatus.classList.add('hidden');

        if (points >= 10 && weight > 0) {
            const discountAmount = total * 0.6;
            total -= discountAmount;
            
            discountRow.classList.remove('hidden');
            document.getElementById('summaryDiscount').innerText = '-Rp ' + discountAmount.toLocaleString('id-ID');
            
            pointStatus.classList.remove('hidden');
            pointStatus.innerText = `Poin Anda ${points}. Diskon 60% diterapkan!`;
        }

        document.getElementById('summaryService').innerText = selectedService.name || '-';
        document.getElementById('summaryPrice').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('summaryGrandTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    function submitOrder(e) {
        e.preventDefault();
        const btnSubmit = document.getElementById('btnSubmit');
        btnSubmit.innerText = 'Memproses...';
        btnSubmit.disabled = true;

        const formData = new FormData(document.getElementById('bookingForm'));

        fetch("{{ route('order.store') }}", {
            method: "POST",
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(async res => {
            const data = await res.json();
            if (res.ok) {
                alert('✅ Pesanan Berhasil!');
                if (data.wa_url) window.open(data.wa_url, '_blank');
                window.location.href = "{{ route('landing') }}";
            } else {
                alert('❌ ' + data.message);
                btnSubmit.innerText = 'Konfirmasi';
                btnSubmit.disabled = false;
            }
        })
        .catch(err => {
            alert('❌ Error: ' + err.message);
            btnSubmit.innerText = 'Konfirmasi';
            btnSubmit.disabled = false;
        });
    }
</script>