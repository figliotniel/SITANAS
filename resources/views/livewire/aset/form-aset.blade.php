<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $pageTitle }}</h1>
            <p class="text-base text-slate-500 mt-2">Silakan isi detail aset tanah dengan data yang valid dan lengkap.</p>
        </div>
        <a href="{{ route('dashboard') }}" wire:navigate class="group inline-flex items-center px-6 py-3 bg-white border-2 border-slate-200 rounded-xl text-base font-semibold text-slate-600 hover:border-blue-500 hover:text-blue-600 transition-all duration-200">
            <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 border-b border-slate-200 px-8 py-4">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold text-lg shadow-lg shadow-blue-500/30">1</div>
                <span class="text-lg font-bold text-slate-700">Formulir Input Data (Wajib Diisi)</span>
            </div>
        </div>

        <form wire:submit="save" class="p-8 md:p-10 space-y-10">
            
            <div>
                <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center border-b border-slate-100 pb-4">
                    <i class="fas fa-file-alt text-blue-500 mr-3"></i> Informasi Utama
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-base font-bold text-slate-700">Kode Barang</label>
                        <input type="text" 
                               wire:model="kode_barang" 
                               class="block w-full px-5 py-4 rounded-2xl border-2 border-slate-200 text-lg text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200" 
                               placeholder="Contoh: TNH-001-2025">
                        @error('kode_barang') <p class="text-base text-red-600 font-medium mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-base font-bold text-slate-700">Asal Perolehan</label>
                        <input type="text" 
                               wire:model="asal_perolehan" 
                               list="list-asal" 
                               class="block w-full px-5 py-4 rounded-2xl border-2 border-slate-200 text-lg text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200" 
                               placeholder="Pilih atau ketik manual...">
                        <datalist id="list-asal">
                            <option value="Aset Desa">
                            <option value="Kekayaan Asli Desa">
                            <option value="Bantuan Pemerintah Kabupaten">
                            <option value="Hibah / Sumbangan">
                            <option value="Pembelian APBDes">
                        </datalist>
                        @error('asal_perolehan') <p class="text-base text-red-600 font-medium mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-base font-bold text-slate-700">Luas Tanah (m²)</label>
                        <div class="relative">
                            <input type="number" 
                                   step="0.01" 
                                   wire:model="luas" 
                                   class="block w-full px-5 py-4 rounded-2xl border-2 border-slate-200 text-lg text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200"
                                   placeholder="0">
                            <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                <span class="text-lg font-bold text-slate-400">m²</span>
                            </div>
                        </div>
                        @error('luas') <p class="text-base text-red-600 font-medium mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-base font-bold text-slate-700">Tanggal Perolehan</label>
                        <input type="date" 
                               wire:model="tanggal_perolehan" 
                               class="block w-full px-5 py-4 rounded-2xl border-2 border-slate-200 text-lg text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200">
                        @error('tanggal_perolehan') <p class="text-base text-red-600 font-medium mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-base font-bold text-slate-700">Lokasi / Alamat Lengkap</label>
                        <textarea wire:model="lokasi" 
                                  rows="3" 
                                  class="block w-full px-5 py-4 rounded-2xl border-2 border-slate-200 text-lg text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200"
                                  placeholder="Tuliskan alamat lengkap atau patokan lokasi..."></textarea>
                        @error('lokasi') <p class="text-base text-red-600 font-medium mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200">
                <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center border-b border-slate-200 pb-4">
                    <i class="fas fa-certificate text-amber-500 mr-3"></i> Data Legalitas & Fisik
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-base font-bold text-slate-700">NUP (Nomor Urut Pendaftaran)</label>
                        <input type="text" wire:model="nup" class="block w-full px-5 py-4 rounded-2xl border-2 border-slate-200 text-lg text-slate-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-base font-bold text-slate-700">Harga Perolehan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <span class="text-lg font-bold text-slate-500">Rp</span>
                            </div>
                            <input type="number" wire:model="harga_perolehan" class="block w-full pl-14 pr-5 py-4 rounded-2xl border-2 border-slate-200 text-lg text-slate-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-base font-bold text-slate-700">Nomor Sertifikat</label>
                        <input type="text" wire:model="nomor_sertifikat" class="block w-full px-5 py-4 rounded-2xl border-2 border-slate-200 text-lg text-slate-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" placeholder="Nomor Hak Milik/Pakai">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-base font-bold text-slate-700">Status Hak Tanah</label>
                        <select wire:model="status_sertifikat" class="block w-full px-5 py-4 rounded-2xl border-2 border-slate-200 text-lg text-slate-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 h-16 bg-white">
                            <option value="">-- Pilih Status --</option>
                            <option value="Tanah Kas Desa">Tanah Kas Desa</option>
                            <option value="Hak Milik">Hak Milik</option>
                            <option value="Hak Pakai">Hak Pakai</option>
                            <option value="Hak Guna Bangunan">Hak Guna Bangunan</option>
                            <option value="Letter C">Letter C / Girik</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 space-y-2">
                         <label class="block text-base font-bold text-slate-700">Penggunaan Lahan Saat Ini</label>
                         <input type="text" wire:model="penggunaan" list="list-guna" class="block w-full px-5 py-4 rounded-2xl border-2 border-slate-200 text-lg text-slate-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" placeholder="Misal: Sawah Produktif, Kantor Desa">
                         <datalist id="list-guna">
                             <option value="Pertanian / Sawah"><option value="Kebun / Tegalan"><option value="Kantor Desa"><option value="Lapangan Olahraga"><option value="Sekolah">
                         </datalist>
                    </div>

                    <div class="md:col-span-2 space-y-3">
                        <label class="block text-base font-bold text-slate-700">Titik Koordinat</label>
                        <div class="flex gap-3">
                            <input type="text" wire:model="koordinat" readonly class="block w-full px-5 py-4 rounded-2xl border-2 border-slate-200 bg-slate-100 text-lg text-slate-600" placeholder="Klik lokasi di peta bawah...">
                        </div>
                        
                        <div class="relative w-full h-96 rounded-3xl overflow-hidden border-4 border-white shadow-lg ring-1 ring-slate-200">
                            <div wire:ignore id="map" class="w-full h-full z-0"></div>
                            <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur px-4 py-2 rounded-xl shadow-sm z-[400] text-sm font-semibold text-slate-700">
                                <i class="fas fa-mouse-pointer mr-2 text-blue-500"></i> Klik peta untuk set lokasi
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-white rounded-2xl border-2 border-slate-200 border-dashed">
                        <h4 class="md:col-span-2 text-lg font-bold text-slate-700 flex items-center"><i class="fas fa-compass text-slate-400 mr-2"></i> Batas-Batas Wilayah</h4>
                        <div class="space-y-1">
                            <label class="text-sm font-bold text-slate-500 uppercase">Utara</label>
                            <input type="text" wire:model="batas_utara" class="block w-full px-4 py-3 rounded-xl border-2 border-slate-200 text-base focus:border-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-bold text-slate-500 uppercase">Timur</label>
                            <input type="text" wire:model="batas_timur" class="block w-full px-4 py-3 rounded-xl border-2 border-slate-200 text-base focus:border-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-bold text-slate-500 uppercase">Selatan</label>
                            <input type="text" wire:model="batas_selatan" class="block w-full px-4 py-3 rounded-xl border-2 border-slate-200 text-base focus:border-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-bold text-slate-500 uppercase">Barat</label>
                            <input type="text" wire:model="batas_barat" class="block w-full px-4 py-3 rounded-xl border-2 border-slate-200 text-base focus:border-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse md:flex-row justify-end items-center gap-4 pt-8 border-t border-slate-100">
                <a href="{{ route('dashboard') }}" class="w-full md:w-auto px-8 py-4 rounded-2xl border-2 border-slate-200 text-lg font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-center">
                    Batal
                </a>
                <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-10 py-4 bg-blue-600 border border-transparent rounded-2xl text-lg font-bold text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/50 shadow-xl shadow-blue-500/30 transition-all transform hover:-translate-y-1 active:translate-y-0">
                    <i class="fas fa-save mr-3"></i> {{ $saveButtonText }}
                </button>
            </div>
        </form>
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:navigated', () => {
        // Hapus map lama jika ada agar tidak duplicate
        if (window.sitanasMap) {
            window.sitanasMap.remove();
            window.sitanasMap = null;
        }

        // Inisialisasi Peta Baru
        window.sitanasMap = L.map('map').setView([-7.7956, 110.3695], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(window.sitanasMap);

        var marker;
        
        // Cek data eksisting
        const currentKoordinat = @this.get('koordinat');
        if (currentKoordinat) {
            const parts = currentKoordinat.split(',');
            const lat = parseFloat(parts[0]);
            const lng = parseFloat(parts[1]);
            if (!isNaN(lat) && !isNaN(lng)) {
                const latLng = [lat, lng];
                marker = L.marker(latLng).addTo(window.sitanasMap);
                window.sitanasMap.setView(latLng, 16);
            }
        }

        // Event Klik
        window.sitanasMap.on('click', function(e) {
            const lat = e.latlng.lat.toFixed(6);
            const lng = e.latlng.lng.toFixed(6);
            
            // Update ke Livewire
            @this.set('koordinat', `${lat},${lng}`);

            // Pindahkan Marker
            if (!marker) {
                marker = L.marker(e.latlng).addTo(window.sitanasMap);
            } else {
                marker.setLatLng(e.latlng);
            }
        });
    });
</script>
@endscript