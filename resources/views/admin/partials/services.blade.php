{{-- Partial View: Kelola Layanan --}}

<div class="space-y-6 animate-fade-in relative">

    {{-- Notifikasi Toast --}}
    @if(session('success'))
        <div id="flash-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-xl z-50 transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="flash-message" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-xl shadow-xl z-50 transition-opacity duration-500">
            {{ session('error') }}
        </div>
    @endif

    {{-- Indicator loading (Menyimpan...) --}}
    <div id="saving-indicator" class="fixed top-4 right-4 bg-blue-600 text-white px-6 py-3 rounded-xl shadow-xl z-50 hidden items-center gap-2 transition-all">
        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        Menyimpan Perubahan...
    </div>

    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Kelola Layanan & Harga</h2>
        <button onclick="toggleModal(true)" class="px-6 py-2 rounded-xl font-bold text-sm bg-blue-600 text-white hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
            + Tambah Layanan
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($services as $svc)
            <div class="bg-white dark:bg-slate-800 p-4 rounded-[30px] flex gap-4 items-center shadow-md hover:shadow-lg transition-all border border-slate-100 dark:border-slate-700 group relative">
                
                {{-- BAGIAN FOTO (Klik untuk ganti) --}}
                <div class="relative w-20 h-20 shrink-0 group-image cursor-pointer">
                    <form action="{{ route('admin.service.image.update', $svc->id) }}" method="POST" enctype="multipart/form-data" class="w-full h-full">
                        @csrf
                        
                        @php
                            $imgSrc = 'https://images.unsplash.com/photo-1582735689369-4fe89db7114c?auto=format&fit=crop&w=150&q=80'; 
                            if($svc->image) {
                                $imgSrc = asset('storage/' . $svc->image);
                            } else {
                                if(str_contains(strtolower($svc->name), 'sepatu')) $imgSrc = "https://images.unsplash.com/photo-1603808033192-082d6919d3e1?auto=format&fit=crop&w=150&q=80";
                                if(str_contains(strtolower($svc->name), 'bedcover')) $imgSrc = "https://images.unsplash.com/photo-1512918760532-3ea50d82175d?auto=format&fit=crop&w=150&q=80";
                            }
                        @endphp

                        <img src="{{ $imgSrc }}" class="w-full h-full object-cover rounded-2xl border border-slate-100 dark:border-slate-600 shadow-sm" alt="{{ $svc->name }}">
                        
                        {{-- Overlay Edit Icon --}}
                        <label for="upload-{{ $svc->id }}" class="absolute inset-0 bg-black/40 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-white font-bold text-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </label>
                        
                        <input type="file" name="image" id="upload-{{ $svc->id }}" class="hidden" accept="image/*" onchange="this.form.submit()">
                    </form>
                </div>

                {{-- INFO LAYANAN (NAMA BISA DIEDIT) --}}
                <div class="flex-1 min-w-0">
                    {{-- Input Nama --}}
                    <input 
                        type="text" 
                        value="{{ $svc->name }}"
                        oninput="debounceUpdate({{ $svc->id }}, 'name', this.value)"
                        class="w-full font-bold text-lg text-slate-800 dark:text-white bg-transparent border-b border-transparent focus:border-blue-500 outline-none transition-colors px-1"
                        placeholder="Nama Layanan"
                    >
                    <p class="text-xs text-slate-400 mt-1">Harga per {{ $svc->unit }}</p>
                </div>

                {{-- HARGA & HAPUS --}}
                <div class="flex flex-col items-end gap-2">
                    <div class="flex items-center gap-2">
                        <span class="text-slate-400 font-bold text-xs">Rp</span>
                        {{-- Input Harga --}}
                        <input 
                            type="number"
                            step="1000"
                            value="{{ $svc->price }}"
                            oninput="debounceUpdate({{ $svc->id }}, 'price', this.value)"
                            class="w-24 p-2 rounded-lg text-right font-bold text-sm outline-none border border-slate-200 dark:border-slate-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-slate-700 dark:text-white dark:bg-slate-700"
                        />
                    </div>

                    <form action="{{ route('admin.service.delete', $svc->id) }}" method="POST" onsubmit="return confirm('Hapus layanan {{ $svc->name }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-400 hover:text-red-600 hover:underline transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10 text-slate-400 italic">
                Belum ada layanan yang ditambahkan.
            </div>
        @endforelse
    </div>

    <div class="flex justify-end mt-4">
        <p class="text-xs italic text-slate-400">
            *Klik foto untuk mengganti gambar. Edit nama & harga langsung di kolomnya.
        </p>
    </div>

    {{-- Modal tambah layanan --}}
    <div id="addModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity opacity-0">
        <div id="modalContent" class="w-full max-w-md bg-white dark:bg-slate-800 text-slate-800 dark:text-white rounded-[30px] p-8 relative transform scale-95 transition-transform duration-300 shadow-2xl">
            
            <button onclick="toggleModal(false)" class="absolute top-4 right-4 text-2xl opacity-50 hover:opacity-100 transition">&times;</button>

            <h3 class="text-xl font-bold mb-6">Tambah Layanan Baru</h3>

            <form action="{{ route('admin.service.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold mb-2 text-slate-400">Nama Layanan</label>
                        <input type="text" name="name" required placeholder="Contoh: Cuci Karpet" class="w-full p-3 rounded-xl outline-none border border-slate-200 dark:border-slate-600 focus:border-blue-500 bg-slate-50 dark:bg-slate-700 dark:text-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2 text-slate-400">Harga per Kg/Unit</label>
                        <input type="number" name="price" step="1000" required placeholder="15000" class="w-full p-3 rounded-xl outline-none border border-slate-200 dark:border-slate-600 focus:border-blue-500 bg-slate-50 dark:bg-slate-700 dark:text-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2 text-slate-400">Foto Layanan (Opsional)</label>
                        <input type="file" name="image" accept="image/*" class="w-full p-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG. Max 2MB.</p>
                    </div>
                </div>

                <button type="submit" class="w-full mt-8 py-3 rounded-xl font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                    Simpan Layanan
                </button>
            </form>
        </div>
    </div>

</div>

<script>
    // Logic Modal
    function toggleModal(show) {
        const modal = document.getElementById('addModal');
        const content = document.getElementById('modalContent');
        if (show) {
            modal.classList.remove('hidden'); modal.classList.add('flex');
            setTimeout(() => { modal.classList.remove('opacity-0'); content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
        } else {
            modal.classList.add('opacity-0'); content.classList.remove('scale-100'); content.classList.add('scale-95');
            setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); }, 300);
        }
    }

    // --- LOGIC UPDATE DINAMIS (Nama & Harga) ---
    let debounceTimer;

    function debounceUpdate(id, field, value) {
        const indicator = document.getElementById('saving-indicator');
        indicator.classList.remove('hidden');
        indicator.classList.add('flex');

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            sendUpdateToServer(id, field, value);
        }, 1000); 
    }

    function sendUpdateToServer(id, field, value) {
        // Validasi Harga (khusus jika field == price)
        if (field === 'price' && value % 1000 !== 0) {
            alert("Harga harus kelipatan 1000!");
            document.getElementById('saving-indicator').classList.add('hidden');
            return;
        }

        // Siapkan Payload Dinamis
        let payload = {};
        payload[field] = value; // contoh: { name: "Cuci Baru" } atau { price: 9000 }

        fetch(`/admin/service/${id}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const indicator = document.getElementById('saving-indicator');
                indicator.classList.remove('flex');
                indicator.classList.add('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal menyimpan perubahan. Cek koneksi.');
            document.getElementById('saving-indicator').classList.add('hidden');
        });
    }

    // Auto-hide notifikasi
    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => {
            flash.classList.add('opacity-0');
            setTimeout(() => flash.remove(), 500);
        }, 3000);
    }
</script>