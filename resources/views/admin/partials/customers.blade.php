<div class="space-y-6 animate-fade-in relative">
    
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Data Pesanan Pelanggan</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Kelola status pesanan dan lihat detail.</p>
        </div>
    </div>

    <!-- Tabel Pesanan -->
    <div class="bg-white dark:bg-slate-800 rounded-[30px] shadow-lg border border-slate-100 dark:border-slate-700">
        <div class="overflow-x-auto rounded-[30px]">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                <thead class="bg-blue-50 dark:bg-slate-700 border-b border-blue-100 dark:border-slate-600 text-slate-700 dark:text-slate-200">
                    <tr>
                        <th class="p-4">Order ID</th>
                        <th class="p-4">Pelanggan</th>
                        <th class="p-4">Layanan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-700">
                    @forelse($orders as $order)
                    <tr class="hover:bg-blue-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="p-4 font-bold text-slate-700 dark:text-white">
                            #{{ $order->order_code ?? $order->id }}
                        </td>

                        <td class="p-4">
                            <p class="font-semibold text-slate-800 dark:text-white">{{ $order->name }}</p>
                            <p class="text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}
                            </p>
                        </td>

                        <td class="p-4">
                            {{ $order->service->name ?? '-' }}
                            <span class="text-xs text-slate-400">({{ $order->weight }}kg)</span>
                            <div class="text-xs font-bold text-green-600 mt-1">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </div>
                        </td>

                        <td class="p-4">
                            @php
                                $statusClass = match($order->status) {
                                    'Selesai' => 'bg-green-100 text-green-700 border-green-200',
                                    'Menunggu' => 'bg-red-100 text-red-700 border-red-200',
                                    default => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                };
                            @endphp

                            <span id="badge-cust-{{ $order->id }}"
                                class="px-3 py-1 rounded-full text-[10px] font-bold border {{ $statusClass }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td class="p-4 text-right">
                            <button 
                                type="button"
                                onclick='window.openCustomerModal(@json($order), "{{ $order->service->name ?? '' }}")' 
                                class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500 dark:text-slate-400 italic">
                            Belum ada data pesanan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Detail Pesanan -->
<div id="customerModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity opacity-0">
    <div id="customerModalContent"
        class="w-full max-w-2xl bg-white dark:bg-slate-900 text-slate-800 dark:text-white shadow-2xl rounded-[30px] p-8 relative transform scale-95 transition-transform duration-300 overflow-y-auto max-h-[90vh]">
        
        <button onclick="window.closeCustomerModal()"
            class="absolute top-6 right-6 text-2xl opacity-50 hover:opacity-100 transition z-50 cursor-pointer">
            &times;
        </button>

        <h3 class="text-2xl font-bold mb-6 border-b pb-4 dark:border-slate-700">Detail Pesanan</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Info Pelanggan -->
            <div class="space-y-5 text-sm">
                <div>
                    <label class="text-xs font-bold uppercase text-slate-400">Kode Order</label>
                    <p id="cModalCode" class="font-mono font-bold text-lg bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded w-fit mt-1"></p>
                </div>

                <div>
                    <label class="text-xs font-bold uppercase text-slate-400">Pelanggan</label>
                    <p id="cModalName" class="font-bold text-lg"></p>
                    <p id="cModalPhone" class="text-slate-500"></p>
                </div>

                <div>
                    <label class="text-xs font-bold uppercase text-slate-400">Alamat Jemput</label>
                    <div id="cModalAddress"
                        class="bg-slate-50 dark:bg-slate-800 p-3 rounded-xl text-slate-600 dark:text-slate-300 leading-relaxed border border-slate-100 dark:border-slate-700 mt-1"></div>
                </div>

                <a id="cBtnWA" href="#" target="_blank"
                    class="flex items-center justify-center gap-2 w-full py-3 bg-green-500 text-white rounded-xl font-bold hover:bg-green-600 transition shadow-lg shadow-green-500/30">
                    Chat WhatsApp
                </a>
            </div>

            <!-- Info Status & Harga -->
            <div class="space-y-6">

                <div class="p-5 rounded-2xl bg-blue-50 dark:bg-slate-800 border border-blue-100 dark:border-slate-700 text-sm">
                    <h4 class="font-bold mb-3 text-blue-500">Rincian Biaya</h4>

                    <div class="flex justify-between mb-2">
                        <span>Layanan (<span id="cModalService"></span>)</span>
                        <span id="cModalWeight"></span>
                    </div>

                    <div class="border-t border-dashed border-blue-200 dark:border-slate-600 my-2"></div>

                    <div class="flex justify-between font-bold text-lg text-slate-800 dark:text-white">
                        <span>Total</span>
                        <span id="cModalTotal" class="text-blue-600"></span>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold uppercase tracking-wider block mb-3 text-slate-400">Update Status</label>
                    <div class="grid grid-cols-2 gap-2" id="cStatusContainer"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    (function() {
        let currentCustOrder = null;
        const custStatuses = ["Menunggu", "Dicuci", "Disetrika", "Selesai"];

        // Buka modal dan isi data detail pesanan
        window.openCustomerModal = function(order, serviceName) {
            currentCustOrder = order;

            const modal = document.getElementById('customerModal');
            const content = document.getElementById('customerModalContent');

            document.getElementById('cModalCode').innerText = '#' + (order.order_code || order.id);
            document.getElementById('cModalName').innerText = order.name;
            document.getElementById('cModalPhone').innerText = order.phone;
            document.getElementById('cModalAddress').innerText =
                order.pickup_address + `\n(${order.pickup_date} : ${order.pickup_time})`;

            document.getElementById('cModalService').innerText = serviceName;
            document.getElementById('cModalWeight').innerText = order.weight + ' kg';

            const total = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' })
                .format(order.total_price);
            document.getElementById('cModalTotal').innerText = total;

            let phone = order.phone.replace(/\D/g, '');
            if (phone.startsWith('0')) phone = '62' + phone.substring(1);
            document.getElementById('cBtnWA').href =
                `https://wa.me/${phone}?text=Halo%20Kak%20${order.name},%20status%20pesanan%20saat%20ini:%20${order.status}`;

            renderCustStatusButtons(order.status);

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        };

        // Tutup modal
        window.closeCustomerModal = function() {
            const modal = document.getElementById('customerModal');
            const content = document.getElementById('customerModalContent');

            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        };

        // Render tombol status
        function renderCustStatusButtons(activeStatus) {
            const container = document.getElementById('cStatusContainer');
            container.innerHTML = '';

            custStatuses.forEach(status => {
                const btn = document.createElement('button');
                const isActive = activeStatus === status;

                let btnClass =
                    "py-3 rounded-xl text-xs font-bold border transition-all ";

                btnClass += isActive
                    ? "bg-blue-600 text-white border-blue-600 ring-2 ring-blue-300 dark:ring-slate-700"
                    : "bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700";

                btn.className = btnClass;
                btn.innerText = status;
                btn.onclick = () => updateCustStatus(status);

                container.appendChild(btn);
            });
        }

        // Update status pesanan
        function updateCustStatus(newStatus) {
            if (!currentCustOrder) return;

            renderCustStatusButtons(newStatus);

            fetch(`/admin/order/${currentCustOrder.id}/status`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const badge = document.getElementById(`badge-cust-${currentCustOrder.id}`);
                    if (badge) {
                        badge.innerText = newStatus;

                        let color = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                        if (newStatus === 'Selesai') color = 'bg-green-100 text-green-700 border-green-200';
                        if (newStatus === 'Menunggu') color = 'bg-red-100 text-red-700 border-red-200';

                        badge.className =
                            `px-3 py-1 rounded-full text-[10px] font-bold border ${color}`;
                    }

                    currentCustOrder.status = newStatus;
                }
            })
            .catch(err => alert("Gagal update status: " + err.message));
        }

        // Tutup modal jika klik area gelap
        const modal = document.getElementById('customerModal');
        if (modal) modal.addEventListener("click", e => {
            if (e.target === modal) window.closeCustomerModal();
        });
    })();
</script>
