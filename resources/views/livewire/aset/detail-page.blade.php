<div class="max-w-7xl mx-auto space-y-8 pb-20" x-data="{ showModalPemanfaatan: false }">
    
    {{-- Notifikasi Sukses --}}
    @if (session()->has('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- HEADER SECTION --}}
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
        <div class="bg-slate-50 border-b border-slate-200 px-8 py-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            {{-- Kiri: Identitas Aset --}}
            <div class="flex items-start gap-5">
                <div class="p-4 bg-blue-600 rounded-2xl text-white shadow-lg shadow-blue-500/30 flex-shrink-0">
                    <i class="fas fa-map-marked-alt text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 leading-tight">{{ $aset->lokasi }}</h1>
                    <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-slate-500">
                        <span class="font-mono bg-slate-200 px-2.5 py-1 rounded-md text-slate-700 font-bold tracking-wide border border-slate-300">
                            {{ $aset->kode_barang ?? 'TANPA-KODE' }}
                        </span>
                        <span class="hidden md:inline text-slate-300">•</span>
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-tag text-slate-400"></i>
                            {{ $aset->penggunaan ?? 'Penggunaan Belum Set' }}
                        </span>
                    </div>
                </div>
            </div>
            
            {{-- Kanan: Status & Tombol --}}
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <span class="px-5 py-2.5 rounded-full text-sm font-bold uppercase tracking-wide border shadow-sm
                    {{ $aset->status_validasi == 'Disetujui' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                    {{ $aset->status_validasi == 'Ditolak' ? 'bg-rose-50 text-rose-700 border-rose-200' : '' }}
                    {{ $aset->status_validasi == 'Diproses' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}">
                    {{ $aset->status_validasi }}
                </span>

                <button wire:click="exportPdf" class="flex items-center gap-2 px-5 py-2.5 bg-white text-rose-600 rounded-xl hover:bg-rose-50 hover:text-rose-700 transition border border-rose-200 shadow-sm font-semibold text-sm group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Export PDF
                </button>

                <a href="{{ route('laporan') }}" class="px-5 py-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition shadow-lg shadow-slate-800/20 text-sm font-semibold">
                    Kembali
                </a>
            </div>
        </div>

        {{-- CONTENT BODY --}}
        <div class="p-8 bg-slate-50/50">
            
            {{-- SECTION 1: DATA UTAMA (BOX BESAR) --}}
            <div class="mb-8">
                <h3 class="text-lg font-bold text-slate-800 mb-5 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-500"></i> Spesifikasi Tanah
                </h3>
                
                {{-- GRID UTAMA YANG DIMAKSIMALKAN --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    {{-- Card 1: Luas --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Luas Tanah</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold text-slate-800 group-hover:text-blue-600 transition">
                                {{ number_format($aset->luas, 0, ',', '.') }}
                            </span>
                            <span class="text-slate-500 font-medium">m²</span>
                        </div>
                    </div>

                    {{-- Card 2: Harga --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Harga Perolehan</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-lg font-bold text-slate-400 mr-1">Rp</span>
                            <span class="text-2xl font-extrabold text-slate-800 group-hover:text-emerald-600 transition">
                                {{ number_format($aset->harga_perolehan, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Card 3: Sertifikat --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Sertifikat</p>
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-slate-800 mb-1">
                                {{ $aset->status_sertifikat ?? '-' }}
                            </span>
                            <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded w-fit">
                                No: {{ $aset->nomor_sertifikat ?? '-' }}
                            </span>
                        </div>
                    </div>

                    {{-- Card 4: Asal Usul --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Asal Usul</p>
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-slate-800 mb-1">
                                {{ $aset->asal_perolehan ?? '-' }}
                            </span>
                            <span class="text-xs text-slate-500">
                                Tgl: {{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d M Y') : '-' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- LEFT COLUMN: Map & Batas --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- PETA --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                            <h3 class="font-bold text-slate-800">Peta Lokasi</h3>
                            <span class="text-xs font-mono text-slate-500">{{ $aset->koordinat }}</span>
                        </div>
                        <div id="mapDetail" class="h-96 w-full z-0 relative bg-slate-100"></div>
                    </div>

                    {{-- BATAS WILAYAH --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-6">Batas Wilayah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-1">Utara</span>
                                <span class="block text-lg font-semibold text-slate-800">{{ $aset->batas_utara ?? '-' }}</span>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-1">Timur</span>
                                <span class="block text-lg font-semibold text-slate-800">{{ $aset->batas_timur ?? '-' }}</span>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-1">Selatan</span>
                                <span class="block text-lg font-semibold text-slate-800">{{ $aset->batas_selatan ?? '-' }}</span>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-1">Barat</span>
                                <span class="block text-lg font-semibold text-slate-800">{{ $aset->batas_barat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN: Legalitas & Keterangan --}}
                <div class="space-y-8">
                    
                    {{-- LEGALITAS CARD --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
                            <h3 class="font-bold text-blue-900">Detail Legalitas</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">NUP (Nomor Urut Pendaftaran)</label>
                                <div class="text-lg font-medium text-slate-800 border-b border-slate-100 pb-2">
                                    {{ $aset->nup ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Bukti Perolehan</label>
                                <div class="text-lg font-medium text-slate-800 border-b border-slate-100 pb-2">
                                    {{ $aset->bukti_perolehan ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Tanggal Sertifikat</label>
                                <div class="text-lg font-medium text-slate-800 border-b border-slate-100 pb-2">
                                    {{ $aset->tanggal_sertifikat ? \Carbon\Carbon::parse($aset->tanggal_sertifikat)->format('d F Y') : '-' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Kondisi Tanah</label>
                                <span class="inline-block mt-1 px-3 py-1 rounded-lg font-bold text-sm 
                                    {{ $aset->kondisi == 'Baik' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $aset->kondisi ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- KETERANGAN CARD --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                        <h3 class="font-bold text-slate-800 mb-4">Keterangan Tambahan</h3>
                        <p class="text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100 text-sm">
                            {{ $aset->keterangan ?? 'Tidak ada keterangan tambahan.' }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- RIWAYAT PEMANFAATAN (Full Width & Spacious) --}}
            <div class="mt-8">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-history text-amber-500"></i> Riwayat Pemanfaatan
                        </h3>
                        {{-- Tombol Tambah Pemanfaatan --}}
                        <button @click="showModalPemanfaatan = true" class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition shadow flex items-center gap-2">
                            <i class="fas fa-plus"></i> Tambah Pemanfaatan
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pihak Pemanfaat</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Bentuk Pemanfaatan</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($aset->pemanfaatan ?? [] as $history)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-8 py-6 whitespace-nowrap font-medium text-slate-700">
                                        {{ \Carbon\Carbon::parse($history->tanggal)->format('d M Y') }}
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-lg font-semibold text-slate-800">
                                        {{ $history->pihak_pemanfaat }}
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $history->bentuk_pemanfaatan }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-slate-600 leading-relaxed max-w-xs">
                                        {{ $history->keterangan }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-folder-open text-4xl mb-4 opacity-30"></i>
                                            <p class="text-lg font-medium">Belum ada riwayat pemanfaatan</p>
                                            <p class="text-sm mt-1">Aset ini belum tercatat dimanfaatkan oleh pihak lain.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL TAMBAH PEMANFAATAN (AlpineJS) --}}
    <div x-show="showModalPemanfaatan" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            {{-- Overlay --}}
            <div @click="showModalPemanfaatan = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            {{-- Modal Panel --}}
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-slate-200">
                
                <form wire:submit.prevent="simpanPemanfaatan">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-handshake text-blue-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Tambah Pemanfaatan
                                </h3>
                                <div class="mt-4 space-y-4">
                                    
                                    {{-- Input Pihak Pemanfaat --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pihak Pemanfaat</label>
                                        <input type="text" wire:model="pihak_pemanfaat" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Gapoktan Makmur">
                                        @error('pihak_pemanfaat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Input Bentuk Pemanfaatan --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Bentuk Pemanfaatan</label>
                                        <select wire:model="bentuk_pemanfaatan" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                            <option value="">Pilih Bentuk...</option>
                                            <option value="Sewa">Sewa</option>
                                            <option value="Pinjam Pakai">Pinjam Pakai</option>
                                            <option value="Bangun Guna Serah">Bangun Guna Serah</option>
                                            <option value="Bangun Serah Guna">Bangun Serah Guna</option>
                                            <option value="Kerjasama Pemanfaatan">Kerjasama Pemanfaatan</option>
                                        </select>
                                        @error('bentuk_pemanfaatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Input Tanggal --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                        <input type="date" wire:model="tanggal_pemanfaatan" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                        @error('tanggal_pemanfaatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Input Keterangan --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                        <textarea wire:model="keterangan_pemanfaatan" rows="3" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Catatan tambahan..."></textarea>
                                        @error('keterangan_pemanfaatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan
                        </button>
                        <button @click="showModalPemanfaatan = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@script
<script>
    // Event listener untuk menutup modal setelah sukses simpan
    Livewire.on('pemanfaatan-stored', () => {
        // Mengakses scope alpineJS untuk menutup modal
        // Cara paling aman di livewire v3 dengan alpine inline:
        document.querySelector('[x-data]').__x.$data.showModalPemanfaatan = false;
    });

    // Script Peta Detail
    Livewire.hook('morph.updated', () => { initDetailMap(); });
    initDetailMap();

    function initDetailMap() {
        const koordinat = "{{ $aset->koordinat }}";
        if(!koordinat) return;

        const parts = koordinat.split(',');
        if(parts.length !== 2) return;

        const lat = parseFloat(parts[0]);
        const lng = parseFloat(parts[1]);

        const container = document.getElementById('mapDetail');
        if(container) {
            if (container._leaflet_id) {
                container._leaflet_id = null;
            }
            container.innerHTML = "";

            var map = L.map('mapDetail', {
                zoomControl: true,
                scrollWheelZoom: false
            }).setView([lat, lng], 16);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: ''
            }).addTo(map);
            
            L.marker([lat, lng]).addTo(map)
                .bindPopup("<b>{{ $aset->lokasi }}</b><br>Luas: {{ $aset->luas }} m²")
                .openPopup();

            setTimeout(() => { map.invalidateSize(); }, 100);
        }
    }
</script>
@endscript