<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                {{ isset($aset) ? 'Edit Data Aset Tanah' : 'Input Aset Tanah' }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">Formulir inventarisasi aset tanah desa sesuai standar Permendagri.</p>
        </div>
        <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition shadow-sm">
            <i class="fas fa-arrow-left mr-2 text-xs"></i> Kembali
        </a>
    </div>

    <form wire:submit.prevent="simpan">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-blue-50 px-6 py-4 border-b border-blue-100 flex justify-between items-center">
                        <h3 class="font-bold text-blue-900 flex items-center gap-2 text-sm uppercase tracking-wide">
                            <i class="fas fa-star text-blue-600"></i> Data Wajib (Mandatory)
                        </h3>
                    </div>
                    
                    <div class="p-8 space-y-7">
                        {{-- Kode Barang --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Kode Barang <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="kode_barang" class="w-full rounded-lg border-slate-300 text-sm py-2.5 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400" placeholder="Contoh: 01.01.01.04.001">
                            @error('kode_barang') <span class="text-xs text-red-500 mt-1 block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        {{-- Nama Barang --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nama / Jenis Barang <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="nama_barang" class="w-full rounded-lg border-slate-300 text-sm py-2.5 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400" placeholder="Contoh: Tanah Bangunan Kantor Desa">
                            @error('nama_barang') <span class="text-xs text-red-500 mt-1 block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        {{-- Asal & Tanggal --}}
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Asal Usul <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="asal_perolehan" list="list-asal" class="w-full rounded-lg border-slate-300 text-sm py-2.5 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400" placeholder="Pilih/Ketik...">
                                <datalist id="list-asal">
                                    <option value="Kekayaan Asli Desa"><option value="Perolehan Lainnya yang Sah"><option value="Hibah / Sumbangan"><option value="Pembelian APBDes">
                                </datalist>
                                @error('asal_perolehan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Tgl Perolehan <span class="text-red-500">*</span></label>
                                <input type="date" wire:model="tanggal_perolehan" class="w-full rounded-lg border-slate-300 text-sm py-2.5 focus:ring-blue-500 focus:border-blue-500">
                                @error('tanggal_perolehan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Luas & Harga --}}
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Luas (m²) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" wire:model="luas" class="w-full rounded-lg border-slate-300 text-sm py-2.5 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 5000">
                                @error('luas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" wire:model="harga_perolehan" class="w-full rounded-lg border-slate-300 text-sm py-2.5 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 150000000">
                                @error('harga_perolehan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Kondisi --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Kondisi Tanah <span class="text-red-500">*</span></label>
                            <select wire:model="kondisi" class="w-full rounded-lg border-slate-300 text-sm py-2.5 focus:ring-blue-500 focus:border-blue-500">
                                <option value="Baik">Baik (Siap Pakai)</option>
                                <option value="Rusak Ringan">Rusak Ringan (Perlu Urug/Landclearing)</option>
                                <option value="Rusak Berat">Rusak Berat (Sengketa/Banjir)</option>
                            </select>
                            @error('kondisi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Penggunaan --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Penggunaan Lahan <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="penggunaan" list="list-guna" class="w-full rounded-lg border-slate-300 text-sm py-2.5 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400" placeholder="Contoh: Lahan Pertanian Jagung">
                            <datalist id="list-guna">
                                <option value="Jalan Desa"><option value="Bangunan Kantor"><option value="Tanah Bengkok"><option value="Kuburan / Makam"><option value="Pasar Desa">
                            </datalist>
                            @error('penggunaan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Status Sertifikat --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Status Hak <span class="text-red-500">*</span></label>
                            <select wire:model="status_sertifikat" class="w-full rounded-lg border-slate-300 text-sm py-2.5 focus:ring-blue-500 focus:border-blue-500">
                                <option value="Sertifikat Hak Pakai">Sertifikat Hak Pakai (HP)</option>
                                <option value="Sertifikat Hak Milik">Sertifikat Hak Milik (HM)</option>
                                <option value="Sertifikat Hak Pengelolaan">Sertifikat Hak Pengelolaan (HPL)</option>
                                <option value="Girik / Letter C">Girik / Letter C</option>
                                <option value="Belum Bersertifikat">Belum Bersertifikat</option>
                            </select>
                        </div>

                        {{-- Lokasi --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Alamat / Lokasi <span class="text-red-500">*</span></label>
                            <textarea wire:model="lokasi" rows="4" class="w-full rounded-lg border-slate-300 text-sm py-2.5 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400 leading-relaxed" placeholder="Contoh: Jl. Mawar No. 5, Dusun II, Sebelah utara Balai Desa"></textarea>
                            @error('lokasi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: PETA & OPSIONAL --}}
            <div class="lg:col-span-7 space-y-6">
                
                {{-- Kartu Peta --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50 px-6 py-3 border-b border-slate-200 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 text-sm uppercase flex items-center gap-2">
                            <i class="fas fa-map-marked-alt text-amber-500"></i> Peta Lokasi
                        </h3>
                        <div class="flex items-center gap-2">
                            <input type="text" wire:model="koordinat" readonly class="text-xs font-mono bg-white border border-slate-300 rounded px-2 py-1 w-48 text-slate-600 text-center" placeholder="Klik pada peta...">
                        </div>
                    </div>
                    <div class="relative h-96 w-full bg-slate-100">
                        <div wire:ignore id="map" class="w-full h-full z-0"></div>
                        <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur px-3 py-2 rounded-lg shadow-sm z-[400] text-xs font-semibold text-slate-700 pointer-events-none border border-slate-200">
                            <i class="fas fa-mouse-pointer mr-1 text-blue-500"></i> Klik peta untuk menandai lokasi aset
                        </div>
                    </div>
                </div>

                {{-- Kartu Data Pelengkap --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50 px-6 py-3 border-b border-slate-200">
                        <h3 class="font-bold text-slate-800 text-sm uppercase flex items-center gap-2">
                            <i class="fas fa-list-ul text-slate-400"></i> Data Detail (Opsional)
                        </h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Sertifikat</label>
                            <input type="text" wire:model="nomor_sertifikat" class="w-full rounded-lg border-slate-300 text-sm focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400" placeholder="Contoh: 12.34.56.78.1.23456">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">NUP (No Register)</label>
                            <input type="text" wire:model="nup" class="w-full rounded-lg border-slate-300 text-sm focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400" placeholder="Contoh: 0001">
                        </div>
                        
                        {{-- Batas Wilayah --}}
                        <div class="sm:col-span-2 pt-4 border-t border-slate-100">
                            <label class="block text-xs font-bold text-slate-800 uppercase mb-3">Batas Wilayah Fisik</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase w-12">Utara</span>
                                    <input type="text" wire:model="batas_utara" class="flex-1 rounded border-slate-300 text-sm py-1.5 placeholder-slate-300" placeholder="Sawah Bpk. Budi">
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase w-12">Timur</span>
                                    <input type="text" wire:model="batas_timur" class="flex-1 rounded border-slate-300 text-sm py-1.5 placeholder-slate-300" placeholder="Jalan Raya">
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase w-12">Selatan</span>
                                    <input type="text" wire:model="batas_selatan" class="flex-1 rounded border-slate-300 text-sm py-1.5 placeholder-slate-300" placeholder="Sungai">
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase w-12">Barat</span>
                                    <input type="text" wire:model="batas_barat" class="flex-1 rounded border-slate-300 text-sm py-1.5 placeholder-slate-300" placeholder="Rumah Ibu Ani">
                                </div>
                            </div>
                        </div>

                        {{-- Keterangan Tambahan --}}
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Keterangan Lain</label>
                            <textarea wire:model="keterangan" rows="2" class="w-full rounded-lg border-slate-300 text-sm focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400" placeholder="Contoh: Tanah datar, patok batas jelas"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition border border-transparent">
                        Batalkan
                    </a>
                    <button type="submit" wire:loading.attr="disabled" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition disabled:opacity-50 flex items-center gap-2 transform hover:-translate-y-0.5">
                        <span wire:loading.remove><i class="fas fa-save mr-2"></i> Simpan Data Aset</span>
                        <span wire:loading><i class="fas fa-circle-notch fa-spin mr-2"></i> Menyimpan...</span>
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

@script
<script>
    document.addEventListener('livewire:navigated', () => {
        if (window.sitanasMap) { window.sitanasMap.remove(); window.sitanasMap = null; }

        const defaultLat = -7.7956;
        const defaultLng = 110.3695;
        window.sitanasMap = L.map('map').setView([defaultLat, defaultLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 19
        }).addTo(window.sitanasMap);

        var marker;
        const savedCoord = @this.get('koordinat');
        
        if (savedCoord) {
            const parts = savedCoord.split(',');
            const lat = parseFloat(parts[0]);
            const lng = parseFloat(parts[1]);
            if (!isNaN(lat) && !isNaN(lng)) {
                const latLng = [lat, lng];
                marker = L.marker(latLng).addTo(window.sitanasMap);
                window.sitanasMap.setView(latLng, 16);
            }
        }

        window.sitanasMap.on('click', function(e) {
            const lat = e.latlng.lat.toFixed(6);
            const lng = e.latlng.lng.toFixed(6);
            @this.set('koordinat', `${lat},${lng}`);
            if (!marker) {
                marker = L.marker(e.latlng).addTo(window.sitanasMap);
            } else {
                marker.setLatLng(e.latlng);
            }
        });
    });
    
    Livewire.hook('morph.updated', () => {
        const mapEl = document.getElementById('map');
        if(mapEl && !mapEl._leaflet_id) {
            document.dispatchEvent(new Event('livewire:navigated'));
        }
    });
</script>
@endscript