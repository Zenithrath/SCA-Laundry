<div class="space-y-6 relative">

    <!-- Header laporan + filter periode -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Laporan Keuangan</h2>

        @if(isset($availableYears) && count($availableYears) > 0)
        <form action="{{ route('admin.finance') }}" method="GET"
              class="flex gap-2 bg-white dark:bg-slate-800 p-1.5 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">

            <!-- Bulan -->
            <select name="month" onchange="this.form.submit()"
                class="bg-transparent text-sm font-bold text-slate-700 dark:text-slate-200 outline-none cursor-pointer px-2 py-1">
                @foreach($availableMonths as $m)
                    <option value="{{ $m }}" {{ ($selectedMonth ?? date('m')) == $m ? 'selected' : '' }}>
                        {{ \DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endforeach
            </select>

            <!-- Tahun -->
            <select name="year" onchange="this.form.submit()"
                class="bg-transparent text-sm font-bold text-slate-700 dark:text-slate-200 outline-none cursor-pointer border-l border-slate-300 dark:border-slate-600 pl-3 px-2 py-1">
                @foreach($availableYears as $y)
                    <option value="{{ $y }}" {{ ($selectedYear ?? date('Y')) == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </form>
        @endif
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white dark:bg-slate-800 p-6 rounded-[30px] shadow-lg border text-center">
            <p class="text-xs text-slate-500 mb-2">Total Transaksi</p>
            <p class="text-3xl font-bold">
                {{ count($filteredOrders ?? []) }}
            </p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-[30px] shadow-lg border text-center">
            <p class="text-xs text-slate-500 mb-2">Total Pemasukan</p>
            <p class="text-3xl font-bold text-green-600">
                Rp {{ number_format(array_sum($chartValues ?? []), 0, ',', '.') }}
            </p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-[30px] shadow-lg border text-center">
            <p class="text-xs text-slate-500 mb-2">Periode</p>
            <p class="text-3xl font-bold">
                {{ \DateTime::createFromFormat('!m', $selectedMonth ?? date('m'))->format('F') }}
                {{ $selectedYear ?? date('Y') }}
            </p>
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white dark:bg-slate-800 rounded-[30px] shadow-lg overflow-hidden border min-h-[500px]">

        <div class="p-6 border-b">
            <h3 class="font-bold">Riwayat Transaksi</h3>
            <p class="text-xs text-slate-500">Klik baris untuk melihat struk</p>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-sm">
                <thead class="bg-blue-50 dark:bg-slate-700">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Kode</th>
                        <th class="p-4">Pelanggan</th>
                        <th class="p-4">Layanan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Total</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($filteredOrders ?? [] as $order)
                    <tr
                        onclick="openReceiptModal({{ json_encode($order) }}, '{{ $order->service->name ?? 'Layanan Dihapus' }}')"
                        class="hover:bg-blue-50 dark:hover:bg-slate-700 cursor-pointer">

                        <td class="p-4">
                            <div class="font-semibold">
                                {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}
                            </div>
                        </td>

                        <td class="p-4 font-mono text-xs">
                            {{ $order->order_code ?? '#ORDER-'.$order->id }}
                        </td>

                        <td class="p-4 font-semibold">
                            {{ $order->name }}
                        </td>

                        <td class="p-4">
                            {{ $order->service->name ?? '-' }}
                        </td>

                        <td class="p-4">
                            @php
                                $badge = match($order->status) {
                                    'Selesai' => 'bg-green-100 text-green-700',
                                    'Menunggu' => 'bg-red-100 text-red-700',
                                    default => 'bg-yellow-100 text-yellow-700'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badge }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td class="p-4 text-right font-bold text-green-600">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>

                        <td class="p-4 text-center">
                            👁
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-10 text-center text-slate-500">
                            Tidak ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL STRUK -->
<div id="receiptModal"
     class="fixed inset-0 hidden items-center justify-center bg-black/60 z-[100]">

    <div id="receiptContent"
         class="w-full max-w-sm bg-white rounded-3xl overflow-hidden scale-95 duration-300">

        <div class="p-6 text-center border-b">
            <h3 class="font-bold tracking-widest">STRUK LAUNDRY</h3>
            <p class="text-xs text-slate-500">SCA Laundry</p>
            <p id="modalDate" class="text-[10px] mt-2">-</p>
        </div>

        <div class="p-6 space-y-3 text-sm">
            <div class="flex justify-between"><span>Kode</span><span id="modalCode"></span></div>
            <div class="flex justify-between"><span>Pelanggan</span><span id="modalName"></span></div>

            <hr>

            <div class="flex justify-between">
                <span id="modalService"></span>
                <span id="modalServicePrice"></span>
            </div>

            <div class="flex justify-between text-xs">
                <span id="modalWeight"></span>
                <span id="modalPricePerKg"></span>
            </div>

            <div class="flex justify-between">
                <span class="font-bold">TOTAL</span>
                <span id="modalTotal" class="font-bold text-green-600"></span>
            </div>

            <div class="text-center">
                <span id="modalStatus" class="px-4 py-1 rounded-full text-xs font-bold"></span>
            </div>
        </div>

        <div class="p-4 border-t text-center">
            <button onclick="closeReceiptModal()" class="w-full py-2 bg-slate-800 text-white rounded-xl">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openReceiptModal(order, serviceName) {
    const f = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });

    document.getElementById('modalDate').innerText = new Date(order.created_at).toLocaleString('id-ID');
    document.getElementById('modalCode').innerText = order.order_code ?? '#' + order.id;
    document.getElementById('modalName').innerText = order.name;
    document.getElementById('modalService').innerText = serviceName;

    const serviceTotal = order.total_price - 10000;
    document.getElementById('modalServicePrice').innerText = f.format(serviceTotal);
    document.getElementById('modalWeight').innerText = `Berat: ${order.weight} kg`;
    document.getElementById('modalPricePerKg').innerText = f.format(serviceTotal / order.weight) + '/kg';
    document.getElementById('modalTotal').innerText = f.format(order.total_price);

    const badge = document.getElementById('modalStatus');
    badge.innerText = order.status;
    badge.className = 'px-4 py-1 rounded-full text-xs font-bold ' +
        (order.status === 'Selesai' ? 'bg-green-100 text-green-700' :
         order.status === 'Menunggu' ? 'bg-red-100 text-red-700' :
         'bg-yellow-100 text-yellow-700');

    const modal = document.getElementById('receiptModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeReceiptModal() {
    document.getElementById('receiptModal').classList.add('hidden');
}
</script>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 6px }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px }
</style>
