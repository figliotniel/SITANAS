<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    
    {{-- Notifikasi Sukses / Error --}}
    @if (session()->has('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl relative flex items-center gap-2 shadow-sm">
            <i class="fas fa-check-circle text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-xl relative flex items-center gap-2 shadow-sm">
            <i class="fas fa-exclamation-triangle text-xl"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- BAGIAN 1: HEADER & TOMBOL --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 px-8 py-6 border-b border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">{{ $aset->lokasi }}</h1>
                <div class="flex items-center gap-3 mt-2 text-sm text-slate-500">
                    <span class="font-mono bg-white border px-2 py-1 rounded text-slate-600 font-semibold">
                        {{ $aset->kode_barang ?? 'TANPA KODE' }}
                    </span>
                    <span>•</span>
                    <span>{{ $aset->penggunaan ?? 'Penggunaan Belum Diisi' }}</span>
                </div>
            </div>
            <div class="flex gap-3">
                <button wire:click="exportPdf" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 font-medium text-sm flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-pdf text-rose-500"></i> Export PDF
                </button>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 font-medium text-sm shadow-sm">
                    Kembali
                </a>
            </div>
        </div>

        {{-- Info Ringkas (4 Kotak) --}}
        <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50">
                <div class="text-xs text-slate-400 uppercase font-bold mb-1">Luas Tanah</div>
                <div class="text-2xl font-bold text-slate-800">{{ number_format($aset->luas, 0, ',', '.') }} m²</div>
            </div>
            <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50">
                <div class="text-xs text-slate-400 uppercase font-bold mb-1">Harga Perolehan</div>
                <div class="text-2xl font-bold text-emerald-600">Rp {{ number_format($aset->harga_perolehan, 0, ',', '.') }}</div>
            </div>
            <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50">
                <div class="text-xs text-slate-400 uppercase font-bold mb-1">Sertifikat</div>
                <div class="text-lg font-bold text-slate-800">{{ $aset->status_sertifikat }}</div>
                <div class="text-xs text-slate-500 truncate">{{ $aset->nomor_sertifikat ?? 'No: -' }}</div>
            </div>
            <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50">
                <div class="text-xs text-slate-400 uppercase font-bold mb-1">Status Validasi</div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                    {{ $aset->status_validasi == 'Disetujui' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    {{ $aset->status_validasi }}
                </span>
            </div>
        </div>
    </div>

    {{-- BAGIAN 2: PETA & DETAIL (Grid 3 Kolom) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kiri: Peta --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between">
                    <h3 class="font-bold text-slate-700">Peta Lokasi</h3>
                    <span class="text-xs font-mono text-slate-400">{{ $aset->koordinat }}</span>
                </div>
                <div id="mapDetail" class="h-80 w-full z-0 bg-slate-100"></div>
            </div>
            
            {{-- Batas Wilayah --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4">Batas Wilayah</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="text-xs text-slate-400 font-bold uppercase block">Utara</span>
                        <span class="font-medium text-slate-700">{{ $aset->batas_utara ?? '-' }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="text-xs text-slate-400 font-bold uppercase block">Timur</span>
                        <span class="font-medium text-slate-700">{{ $aset->batas_timur ?? '-' }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="text-xs text-slate-400 font-bold uppercase block">Selatan</span>
                        <span class="font-medium text-slate-700">{{ $aset->batas_selatan ?? '-' }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="text-xs text-slate-400 font-bold uppercase block">Barat</span>
                        <span class="font-medium text-slate-700">{{ $aset->batas_barat ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Legalitas --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4 border-b pb-2">Detail Legalitas</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase">NUP</label>
                        <p class="text-slate-800 font-medium">{{ $aset->nup ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase">Bukti Perolehan</label>
                        <p class="text-slate-800 font-medium">{{ $aset->bukti_perolehan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase">Kondisi</label>
                        <p class="text-slate-800 font-medium">{{ $aset->kondisi ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase">Keterangan</label>
                        <p class="text-slate-600 text-sm bg-slate-50 p-3 rounded-lg border mt-1">
                            {{ $aset->keterangan ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN 3: PEMANFAATAN (Form Kiri, Tabel Kanan) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        {{-- KOLOM 1: FORM INPUT (Khusus Admin) --}}
        @if(Auth::user()->role_id == 1)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:col-span-1 sticky top-4">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-edit text-blue-600"></i> Catat Pemanfaatan
            </h3>
            
            <form wire:submit.prevent="simpanPemanfaatan" class="space-y-4">
                {{-- Pihak --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Pihak Pemanfaat</label>
                    <input type="text" wire:model="p_pihak_ketiga" class="w-full mt-1 rounded-lg border-slate-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Nama Penyewa / Instansi">
                    @error('p_pihak_ketiga') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Bentuk --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Bentuk Kerjasama</label>
                    <select wire:model="p_bentuk_pemanfaatan" class="w-full mt-1 rounded-lg border-slate-300 text-sm">
                        <option value="Sewa">Sewa</option>
                        <option value="Pinjam Pakai">Pinjam Pakai</option>
                        <option value="Bangun Guna Serah">Bangun Guna Serah</option>
                        <option value="Bangun Serah Guna">Bangun Serah Guna</option>
                        <option value="Kerjasama Pemanfaatan">Kerjasama Pemanfaatan</option>
                    </select>
                </div>

                {{-- Tanggal --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase">Mulai</label>
                        <input type="date" wire:model="p_tanggal_mulai" class="w-full mt-1 rounded-lg border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase">Selesai</label>
                        <input type="date" wire:model="p_tanggal_selesai" class="w-full mt-1 rounded-lg border-slate-300 text-sm">
                    </div>
                </div>
                @error('p_tanggal_mulai') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                @error('p_tanggal_selesai') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror

                {{-- Nilai --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Nilai (Rp)</label>
                    <input type="number" wire:model="p_nilai_kontribusi" class="w-full mt-1 rounded-lg border-slate-300 text-sm" placeholder="0">
                    @error('p_nilai_kontribusi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Status Bayar --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Status Pembayaran</label>
                    <select wire:model="p_status_pembayaran" class="w-full mt-1 rounded-lg border-slate-300 text-sm">
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>

                {{-- Upload Bukti --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Upload Bukti (Opsional)</label>
                    <input type="file" wire:model="p_path_bukti" class="w-full mt-1 text-xs text-slate-500 file:mr-2 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('p_path_bukti') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Keterangan</label>
                    <textarea wire:model="p_keterangan" rows="2" class="w-full mt-1 rounded-lg border-slate-300 text-sm"></textarea>
                </div>

                <button type="submit" wire:loading.attr="disabled" class="w-full py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition disabled:opacity-50">
                    <span wire:loading.remove>Simpan Data</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </form>
        </div>
        @endif

        {{-- KOLOM 2 & 3: TABEL DATA (Lebar) --}}
        <div class="{{ Auth::user()->role_id == 1 ? 'lg:col-span-2' : 'lg:col-span-3' }}">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="font-bold text-slate-800">Riwayat Pemanfaatan</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Pihak</th>
                                <th class="px-6 py-3">Bentuk / Nilai</th>
                                <th class="px-6 py-3">Ket / Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($aset->pemanfaatan->sortByDesc('created_at') as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}</div>
                                    <div class="text-xs text-slate-400">s/d {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    {{ $item->pihak_ketiga }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-bold rounded bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $item->bentuk_pemanfaatan }}
                                    </span>
                                    <div class="mt-1 font-mono text-slate-600">Rp {{ number_format($item->nilai_kontribusi, 0, ',', '.') }}</div>
                                    <div class="text-xs font-bold {{ $item->status_pembayaran == 'Lunas' ? 'text-emerald-500' : 'text-rose-500' }}">
                                        {{ $item->status_pembayaran }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-slate-600 max-w-[150px] truncate">{{ $item->keterangan ?? '-' }}</div>
                                    @if($item->path_bukti)
                                        <a href="{{ asset('storage/'.$item->path_bukti) }}" target="_blank" class="text-blue-600 hover:underline text-xs font-bold mt-1 block">
                                            <i class="fas fa-paperclip"></i> Lihat Bukti
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                    <i class="fas fa-folder-open text-4xl mb-3 opacity-30"></i>
                                    <p>Belum ada data riwayat.</p>
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

{{-- Script Peta --}}
@script
<script>
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
            // Reset map container jika sudah ada isinya agar tidak error
            if (container._leaflet_id) container._leaflet_id = null;
            container.innerHTML = "";

            var map = L.map('mapDetail', { zoomControl: true, scrollWheelZoom: false }).setView([lat, lng], 16);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);
            
            L.marker([lat, lng]).addTo(map)
                .bindPopup("<b>{{ $aset->lokasi }}</b><br>Luas: {{ $aset->luas }} m²")
                .openPopup();
            
            setTimeout(() => { map.invalidateSize(); }, 300);
        }
    }
</script>
@endscript