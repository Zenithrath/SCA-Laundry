<section id="booking-section" class="w-full py-16 px-4 relative transition-colors duration-500 bg-slate-50 dark:bg-slate-900">

    <!-- Header -->
    <div class="text-center mb-10 relative z-10">
        <h2 class="text-3xl font-bold mb-2 text-slate-800 dark:text-white">Pesan Laundry Online</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Isi form di bawah untuk memesan</p>
    </div>

    <!-- Card Container -->
    <div class="relative z-10 max-w-4xl mx-auto min-h-[550px] rounded-[30px] p-8 shadow-2xl flex flex-col transition-all duration-500 bg-white dark:bg-slate-800/80 backdrop-blur-xl border border-slate-200 dark:border-slate-700">
        
        <!-- Stepper -->
        <div class="flex rounded-full p-1 mb-8 w-full max-w-2xl mx-auto bg-slate-100 dark:bg-slate-700/50">
            <button onclick="goToStep(1)" id="btnStep1" class="step-btn flex-1 py-2 rounded-full text-xs font-bold transition-all bg-cyan-600 text-white shadow-md">Layanan</button>
            <button onclick="goToStep(2)" id="btnStep2" class="step-btn flex-1 py-2 rounded-full text-xs font-bold transition-all text-slate-400 dark:hover:text-slate-200">Penjemputan</button>
            <button onclick="goToStep(3)" id="btnStep3" class="step-btn flex-1 py-2 rounded-full text-xs font-bold transition-all text-slate-400 dark:hover:text-slate-200">Data Diri</button>
            <button onclick="goToStep(4)" id="btnStep4" class="step-btn flex-1 py-2 rounded-full text-xs font-bold transition-all text-slate-400 dark:hover:text-slate-200">Pembayaran</button>
        </div>

        <!-- Form -->
        <form id="bookingForm" onsubmit="submitOrder(event)" class="flex-1 flex flex-col">
            @csrf
            <input type="hidden" name="service_id" id="inputServiceId">
            <input type="hidden" name="service_price" id="inputServicePrice" value="0">
            <input type="hidden" id="userPoints" value="{{ auth()->user() ? auth()->user()->points : 0 }}">

            <!-- Step 1: Pilih Layanan -->
            <div id="step1" class="step-content flex-1 flex flex-col justify-between">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    @foreach($services as $svc)
                    <div onclick="selectService({{ $svc->id }}, '{{ $svc->name }}', {{ $svc->price }})" 
                         id="service-card-{{ $svc->id }}"
                         class="service-card cursor-pointer border-2 border-transparent rounded-2xl p-6 text-center transition-all bg-slate-50 dark:bg-slate-700/50 hover:scale-105 hover:bg-cyan-50 dark:hover:bg-cyan-900/20">
                        <h4 class="font-bold text-sm mb-1 text-slate-800 dark:text-white">{{ $svc->name }}</h4>
                        <p class="text-[10px] mb-2 text-slate-500 dark:text-slate-400">Klik untuk memilih</p>
                        <p class="text-xs font-bold text-cyan-500">Rp {{ number_format($svc->price, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1">Estimasi Berat (Kg)</label>
                        <input type="number" id="inputWeight" name="weight" oninput="calculateTotal()" class="w-full rounded-xl px-4 py-3 bg-slate-100 dark:bg-slate-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1">Catatan</label>
                        <input type="text" name="notes" class="w-full rounded-xl px-4 py-3 bg-slate-100 dark:bg-slate-700">
                    </div>
                </div>
            </div>

            <!-- Step 2: Penjemputan -->
            <div id="step2" class="step-content hidden flex-1 flex flex-col">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1">Alamat Penjemputan</label>
                        <textarea name="pickup_address" rows="4" class="w-full rounded-xl px-4 py-3 bg-slate-100 dark:bg-slate-700"></textarea>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold mb-2 ml-1">Tanggal</label>
                            <input type="date" name="pickup_date" class="w-full rounded-xl px-4 py-3 bg-slate-100 dark:bg-slate-700">
                        </div>
                        <div>
                            <label class="block text-xs font-bold mb-2 ml-1">Jam</label>
                            <div class="space-y-2">
                                <label class="flex items-center p-3 rounded-xl cursor-pointer bg-slate-100 dark:bg-slate-700">
                                    <input type="radio" name="pickup_time" value="Pagi (08.00 - 12.00)" checked class="accent-cyan-500 w-4 h-4">
                                    <span class="ml-3 text-sm">Pagi (08.00 - 12.00)</span>
                                </label>
                                <label class="flex items-center p-3 rounded-xl cursor-pointer bg-slate-100 dark:bg-slate-700">
                                    <input type="radio" name="pickup_time" value="Siang (13.00 - 17.00)" class="accent-cyan-500 w-4 h-4">
                                    <span class="ml-3 text-sm">Siang (13.00 - 17.00)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Data Diri -->
            <div id="step3" class="step-content hidden flex-1 flex flex-col">
                <div class="space-y-6 max-w-xl mx-auto w-full">
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ auth()->user()->name ?? '' }}" class="w-full rounded-xl px-4 py-3 bg-slate-100 dark:bg-slate-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1">Nomor HP / WA</label>
                        <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="w-full rounded-xl px-4 py-3 bg-slate-100 dark:bg-slate-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2 ml-1">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" class="w-full rounded-xl px-4 py-3 bg-slate-100 dark:bg-slate-700">
                    </div>
                </div>
            </div>

            <!-- Step 4: Ringkasan -->
            <div id="step4" class="step-content hidden flex-1 flex flex-col">
                <div class="rounded-2xl p-6 space-y-3 mb-6 max-w-xl mx-auto w-full bg-slate-100 dark:bg-slate-700/50 shadow-inner">
                    <h4 class="font-bold mb-4 text-center">Ringkasan Pesanan</h4>

                    <div id="pointStatus" class="text-center mb-4 text-xs font-bold py-2 rounded bg-yellow-100 text-yellow-700 hidden"></div>

                    <div class="flex justify-between text-sm">
                        <span id="summaryService">Layanan</span>
                        <span id="summaryPrice">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Antar Jemput</span>
                        <span>Rp 10.000</span>
                    </div>

                    <div id="discountRow" class="flex justify-between text-sm text-green-500 font-bold hidden">
                        <span>Diskon Poin (60%)</span>
                        <span id="summaryDiscount">-Rp 0</span>
                    </div>

                    <div class="border-t pt-3 flex justify-between text-lg font-bold">
                        <span>Total Bayar</span>
                        <span id="summaryGrandTotal" class="text-cyan-500">Rp 0</span>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between items-center mt-auto pt-8">
                <button type="button" onclick="changeStep(-1)" id="btnBack" class="invisible text-slate-400 text-sm font-semibold">Kembali</button>
                <button type="button" onclick="changeStep(1)" id="btnNext" class="bg-cyan-600 text-white px-8 py-3 rounded-xl font-bold">Lanjut</button>
                <button type="submit" id="btnSubmit" class="hidden bg-green-600 text-white px-8 py-3 rounded-xl font-bold">Konfirmasi</button>
            </div>
        </form>
    </div>
</section>

<script>
    let currentStep = 1;
    let selectedService = { id: null, price: 0, name: '' };

    // Reset ke step awal saat halaman dibuka
    document.addEventListener("DOMContentLoaded", () => updateNavigationUI());

    // Update tampilan step & tombol
    function updateNavigationUI() {
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(`step${currentStep}`).classList.remove('hidden');

        document.querySelectorAll('.step-btn').forEach((btn, i) => {
            btn.className =
                i + 1 === currentStep
                    ? "step-btn flex-1 py-2 rounded-full text-xs font-bold bg-cyan-600 text-white shadow-md"
                    : "step-btn flex-1 py-2 rounded-full text-xs font-bold text-slate-400";
        });

        btnBack.classList.toggle('invisible', currentStep === 1);
        btnNext.classList.toggle('hidden', currentStep === 4);
        btnSubmit.classList.toggle('hidden', currentStep !== 4);

        if (currentStep === 4) calculateTotal();
    }

    // Perpindahan step + validasi
    function changeStep(dir) {
        if (currentStep === 1 && dir === 1) {
            if (!inputServiceId.value) return alert('Silakan pilih layanan.');
            if (!inputWeight.value) return alert('Isi estimasi berat.');
        }
        if (currentStep === 2 && dir === 1) {
            if (!pickup_address.value) return alert('Lengkapi alamat.');
            if (!pickup_date.value) return alert('Pilih tanggal.');
        }
        if (currentStep === 3 && dir === 1) {
            if (!document.querySelector('[name="name"]').value) return alert('Nama wajib diisi.');
            if (!document.querySelector('[name="phone"]').value) return alert('Nomor HP wajib diisi.');
        }

        goToStep(currentStep + dir);
    }

    function goToStep(val) {
        if (val < 1 || val > 4) return;
        currentStep = val;
        updateNavigationUI();
    }

    // Pilih layanan
    function selectService(id, name, price) {
        selectedService = { id, name, price };
        inputServiceId.value = id;
        inputServicePrice.value = price;

        document.querySelectorAll('.service-card').forEach(el => {
            el.classList.remove('border-cyan-500', 'bg-cyan-50', 'dark:bg-cyan-900/40');
            el.classList.add('border-transparent');
        });

        const card = document.getElementById(`service-card-${id}`);
        card.classList.remove('border-transparent');
        card.classList.add('border-cyan-500', 'bg-cyan-50', 'dark:bg-cyan-900/40');

        calculateTotal();
    }

    // Hitung total + diskon poin
    function calculateTotal() {
        const weight = parseInt(inputWeight.value) || 0;
        const subtotal = selectedService.price * weight;
        let total = subtotal + 10000;

        let points = parseInt(userPoints.value) || 0;

        discountRow.classList.add('hidden');
        pointStatus.classList.add('hidden');

        if (points >= 10 && weight > 0) {
            const discount = total * 0.6;
            total -= discount;

            discountRow.classList.remove('hidden');
            summaryDiscount.innerText = '-Rp ' + discount.toLocaleString('id-ID');

            pointStatus.classList.remove('hidden');
            pointStatus.innerText = `Poin: ${points}. Diskon 60% diterapkan!`;
        }

        summaryService.innerText = selectedService.name || '-';
        summaryPrice.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        summaryGrandTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Submit pesanan via AJAX
    function submitOrder(e) {
        e.preventDefault();

        btnSubmit.innerText = 'Memproses...';
        btnSubmit.disabled = true;

        fetch("{{ route('order.store') }}", {
            method: "POST",
            body: new FormData(bookingForm),
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(async res => {
            const data = await res.json();
            if (res.ok) {
                alert('✅ ' + data.message);
                if (data.wa_url) window.open(data.wa_url, '_blank');
                setTimeout(() => window.location.href = "{{ route('landing') }}", 1000);
            } else {
                alert('❌ ' + (data.message || 'Gagal memproses.'));
                btnSubmit.innerText = 'Konfirmasi';
                btnSubmit.disabled = false;
            }
        })
        .catch(err => {
            alert('❌ Error koneksi: ' + err.message);
            btnSubmit.innerText = 'Konfirmasi';
            btnSubmit.disabled = false;
        });
    }
</script>
