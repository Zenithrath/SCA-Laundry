<div class="space-y-6 relative">
    
    <!-- Header laporan + filter periode -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Laporan Keuangan</h2>
        
        @if(isset($availableYears) && count($availableYears) > 0)
        <form action="{{ route('admin.finance') }}" method="GET"
              class="flex gap-2 bg-white dark:bg-slate-800 p-1.5 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">

            <!-- Pilihan bulan -->
            <select name="month" onchange="this.form.submit()"
                class="bg-transparent text-sm font-bold text-slate-700 dark:text-slate-200 outline-none cursor-pointer px-2 py-1">
                @foreach($availableMonths as $m)
                    <option value="{{ $m }}" {{ (isset($selectedMonth) && $selectedMonth == $m) ? 'selected' : '' }}>
                        {{ \DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endforeach
            </select>

            <!-- Pilihan tahun -->
            <select name="year" onchange="this.form.submit()"
                class="bg-transparent text-sm font-bold text-slate-700 dark:text-slate-200 outline-none cursor-pointer border-l border-slate-300 dark:border-slate-600 pl-3 px-2 py-1">
                @foreach($availableYears as $y)
                    <option value="{{ $y }}" {{ (isset($selectedYear) && $selectedYear == $y) ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </form>
        @endif
    </div>

    <!-- Ringkasan transaksi bulan berjalan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Total transaksi -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[30px] shadow-lg border text-center">
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">Total Transaksi</p>
            <p class="text-3xl font-bold text-slate-800 dark:text-white">
                {{ isset($filteredOrders) ? count($filteredOrders) : 0 }}
            </p>
        </div>

        <!-- Total pemasukan -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[30px] shadow-lg border text-center">
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">Total Pemasukan</p>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                Rp {{ isset($chartValues) ? number_format(array_sum($chartValues), 0, ',', '.') : '0' }}
            </p>
        </div>

        <!-- Periode aktif -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[30px] shadow-lg border text-center">
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">Periode</p>
            <p class="text-3xl font-bold text-slate-800 dark:text-white">
                {{ \DateTime::createFromFormat('!m', $selectedMonth ?? date('m'))->format('F') }}
                {{ $selectedYear ?? date('Y') }}
            </p>
        </div>
    </div>

    <!-- Tabel transaksi -->
    <div class="bg-white dark:bg-slate-800 rounded-[30px] shadow-lg overflow-hidden border min-h-[500px]">

        <div class="p-6 border-b">
            <h3 class="font-bold text-slate-700 dark:text-slate-200">Riwayat Transaksi</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Klik baris untuk melihat detail struk.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                <thead class="bg-blue-50 dark:bg-slate-700 border-b text-slate-700 dark:text-slate-200">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Kode Order</th>
                        <th class="p-4">Nama Pelanggan</th>
                        <th class="p-4">Layanan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Total</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($filteredOrders ?? [] as $order)
                    <tr onclick="openReceiptModal({{ json_encode($order) }}, '{{ $order->service->name ?? 'Layanan Dihapus' }}')"
                        class="hover:bg-blue-50 dark:hover:bg-slate-700 cursor-pointer">

                        <!-- tanggal -->
                        <td class="p-4">
                            <div class="flex flex-col">
                                <span class="font-semibold text-slate-700 dark:text-white">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                                </span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}
                                </span>
                            </div>
                        </td>

                        <!-- kode -->
                        <td class="p-4 font-mono text-xs text-slate-500">
                            {{ $order->order_code ?? '#ORDER-'.$order->id }}
                        </td>

                        <!-- nama -->
                        <td class="p-4">
                            <span class="font-semibold text-slate-800 dark:text-white">{{ $order->name }}</span>
                        </td>

                        <!-- layanan -->
                        <td class="p-4">
                            {{ $order->service->name ?? '-' }}
                        </td>

                        <!-- status -->
                        <td class="p-4">
                            @php
                                $statusClass = match($order->status ?? '') {
                                    'Selesai' => 'bg-green-100 text-green-700 border-green-200',
                                    'Menunggu' => 'bg-red-100 text-red-700 border-red-200',
                                    'Dicuci','Disetrika' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    default => 'bg-blue-100 text-blue-700 border-blue-200',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                {{ $order->status ?? 'Proses' }}
                            </span>
                        </td>

                        <!-- total -->
                        <td class="p-4 text-right font-bold text-green-600 dark:text-green-400">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>

                        <!-- tombol -->
                        <td class="p-4 text-center">
                            <button class="p-2 rounded-full bg-slate-100 dark:bg-slate-700 hover:bg-blue-100 dark:hover:bg-blue-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="p-10 text-center text-slate-500">
                            <p class="text-xl mb-2">📂</p>
                            Tidak ada data transaksi untuk periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal struk transaksi -->
<div id="receiptModal"
     class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 opacity-0">

    <div id="receiptContent"
         class="w-full max-w-sm bg-white dark:bg-slate-800 rounded-3xl shadow-2xl overflow-hidden transform scale-95 duration-300 relative">
        
        <!-- Header -->
        <div class="bg-slate-100 dark:bg-slate-900 p-6 text-center border-b border-dashed">
            <h3 class="font-bold text-xl text-slate-800 dark:text-white tracking-widest uppercase">STRUK LAUNDRY</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">SCA Laundry Service</p>
            <p id="modalDate" class="text-[10px] text-slate-400 mt-2 font-mono">-</p>
        </div>

        <!-- Isi struk -->
        <div class="p-6 space-y-4">

            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Kode Order</span>
                <span id="modalCode" class="font-mono font-bold">-</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Pelanggan</span>
                <span id="modalName" class="font-bold">-</span>
            </div>

            <div class="border-t border-dashed my-2"></div>

            <!-- item service -->
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span id="modalService">-</span>
                    <span id="modalServicePrice" class="font-semibold">-</span>
                </div>

                <div class="flex justify-between text-xs">
                    <span id="modalWeight">Berat: 0 kg</span>
                    <span>x <span id="modalPricePerKg">0</span></span>
                </div>

                <div class="flex justify-between text-sm text-slate-500 mt-2">
                    <span>Biaya Antar Jemput</span>
                    <span>Rp 10.000</span>
                </div>
            </div>

            <div class="border-t border-dashed my-2"></div>

            <!-- total -->
            <div class="flex justify-between items-center">
                <span class="font-bold text-lg">TOTAL</span>
                <span id="modalTotal" class="font-bold text-xl text-green-600">-</span>
            </div>

            <!-- status -->
            <div class="text-center mt-4">
                <span id="modalStatus"
                      class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-gray-100">
                    -
                </span>
            </div>
        </div>

        <!-- tombol close -->
        <div class="p-4 bg-slate-50 dark:bg-slate-900 border-t text-center">
            <button onclick="closeReceiptModal()"
                class="w-full py-3 rounded-xl bg-slate-800 dark:bg-white text-white dark:text-slate-900 font-bold hover:opacity-90">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // Buka modal + isi data struk
    function openReceiptModal(order, serviceName) {
        const modal = document.getElementById('receiptModal');
        const content = document.getElementById('receiptContent');

        // Format tanggal dan rupiah
        const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
        const dateObj = new Date(order.created_at);
        const dateStr = dateObj.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric',
            hour: '2-digit', minute:'2-digit'
        });

        // Hitung harga per kg (total - ongkir)
        const serviceTotal = order.total_price - 10000;
        const pricePerKg = order.weight > 0 ? serviceTotal / order.weight : 0;

        // Inject data ke modal
        document.getElementById('modalDate').innerText = dateStr;
        document.getElementById('modalCode').innerText = order.order_code ?? ('#' + order.id);
        document.getElementById('modalName').innerText = order.name;
        document.getElementById('modalService').innerText = serviceName;
        document.getElementById('modalServicePrice').innerText = formatter.format(serviceTotal);
        document.getElementById('modalWeight').innerText = `Berat: ${order.weight} kg`;
        document.getElementById('modalPricePerKg').innerText = formatter.format(pricePerKg) + '/kg';
        document.getElementById('modalTotal').innerText = formatter.format(order.total_price);
        document.getElementById('modalStatus').innerText = order.status;

        // Badge warna status
        const statusBadge = document.getElementById('modalStatus');
        statusBadge.className = "px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide ";
        if(order.status === 'Selesai') statusBadge.className += "bg-green-100 text-green-700";
        else if(order.status === 'Menunggu') statusBadge.className += "bg-red-100 text-red-700";
        else statusBadge.className += "bg-yellow-100 text-yellow-700";

        // tampilkan modal
        modal.classList.remove('hidden', 'opacity-0');
        modal.classList.add('flex');

        setTimeout(() => {
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    // Tutup modal
    function closeReceiptModal() {
        const modal = document.getElementById('receiptModal');
        const content = document.getElementById('receiptContent');

        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Klik area luar menutup modal
    document.getElementById('receiptModal').addEventListener('click', function(e) {
        if (e.target === this) closeReceiptModal();
    });
</script>

<style>
    /* Scrollbar custom */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
    body.glass-mode .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
</style>
