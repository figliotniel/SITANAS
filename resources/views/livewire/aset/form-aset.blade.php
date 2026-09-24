<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    {{-- ========================================== --}}
    {{-- 1. HERO BANNER FORM ASET KIB A             --}}
    {{-- ========================================== --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 p-6 sm:p-7 text-white shadow-xl shadow-emerald-950/15 border border-emerald-700/50">
        <div class="absolute -right-8 -top-8 w-64 h-64 rounded-full bg-emerald-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-10 w-48 h-48 rounded-full bg-teal-300/15 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/15 text-emerald-200 backdrop-blur-md border border-white/20">
                    <i class="fas fa-layer-group text-emerald-300"></i>
                    <span>Buku Inventaris Barang (KIB A - Tanah Kas)</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    {{ isset($aset) ? 'Perbarui Data Persil KIB A' : 'Input Data Inventaris Tanah Kas Baru' }}
                </h1>
                <p class="text-sm text-emerald-100/90 font-medium max-w-2xl leading-relaxed">
                    Formulir inventarisasi tanah kas desa terstandarisasi Permendagri No. 1/2016. Pastikan data luas, peruntukan, dan legalitas sesuai dokumen warkah.
                </p>
            </div>
            
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl font-black text-sm text-emerald-950 bg-emerald-300 hover:bg-emerald-200 shadow-lg shadow-emerald-950/30 transition-all active:scale-95 cursor-pointer">
                    <i class="fas fa-arrow-left text-emerald-900"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="simpan">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- KOLOM KIRI --}}
            <div class="lg:col-span-6 space-y-6">
                
                {{-- KARTU 1: Identitas & Asal Usul Aset --}}
                <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 text-white flex items-center justify-center font-bold shadow-xs">
                                <i class="fas fa-tag text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">Identitas & Asal Usul Persil</h3>
                                <p class="text-[11px] text-emerald-800 font-medium">Informasi kodefikasi barang dan perolehan hak</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 sm:p-7 space-y-5">
                        
                        <div class="grid grid-cols-2 gap-5">
                            {{-- Kode Barang --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Barang <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       wire:model="kode_barang" 
                                       class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 placeholder-slate-400 bg-slate-50/60 focus:bg-white transition font-mono font-bold" 
                                       placeholder="Misal: 01.01.01"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                                @error('kode_barang') <span class="text-xs text-rose-500 mt-1 block font-bold"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                            </div>
                            
                            {{-- NUP --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NUP (No Register)</label>
                                <input type="text" 
                                       wire:model="nup" 
                                       class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 placeholder-slate-400 bg-slate-50/60 focus:bg-white transition font-mono" 
                                       placeholder="Misal: 0001"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                        </div>

                        {{-- Nama Barang --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama / Jenis Barang <span class="text-rose-500">*</span></label>
                            <input type="text" 
                                   wire:model="nama_barang" 
                                   class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 placeholder-slate-400 bg-slate-50/60 focus:bg-white transition font-medium" 
                                   placeholder="Contoh: Tanah Kas Desa"
                                   oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                            @error('nama_barang') <span class="text-xs text-rose-500 mt-1 block font-bold"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        {{-- Asal Perolehan & Tanggal --}}
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Asal Usul <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       wire:model="asal_perolehan" 
                                       list="list-asal" 
                                       class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 placeholder-slate-400 bg-slate-50/60 focus:bg-white transition font-medium" 
                                       placeholder="Pilih/Ketik..."
                                       oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                <datalist id="list-asal">
                                    <option value="Kekayaan Asli Desa"><option value="Perolehan Lainnya yang Sah"><option value="Hibah / Sumbangan"><option value="Pembelian APBDes">
                                </datalist>
                                @error('asal_perolehan') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tgl Perolehan <span class="text-rose-500">*</span></label>
                                <input type="date" wire:model="tanggal_perolehan" class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-semibold text-slate-700">
                                @error('tanggal_perolehan') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Harga Perolehan --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Harga / Nilai Perolehan <span class="text-rose-500">*</span></label>
                            <div class="relative rounded-xl shadow-xs">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="text-emerald-700 sm:text-sm font-black">Rp</span>
                                </div>
                                <input type="text" 
                                       wire:model="harga_perolehan" 
                                       class="w-full rounded-xl border border-slate-200 text-sm py-2.5 pl-12 pr-4 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-mono font-bold" 
                                       placeholder="0"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            @error('harga_perolehan') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                    </div>
                </div>

                {{-- KARTU 2: Legalitas & Bukti Kepemilikan --}}
                <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-700 to-teal-800 text-white flex items-center justify-center font-bold shadow-xs">
                                <i class="fas fa-file-contract text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">Legalitas & Bukti Kepemilikan</h3>
                                <p class="text-[11px] text-emerald-800 font-medium">Status sertifikasi hak atas tanah kas desa</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 sm:p-7 space-y-5">
                        {{-- Bukti Perolehan --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Bukti Perolehan</label>
                            <select wire:model="bukti_perolehan" class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-medium cursor-pointer">
                                <option value="">Pilih Bukti Perolehan...</option>
                                <option value="Sertifikat">Sertifikat</option>
                                <option value="Akta Jual Beli">Akta Jual Beli</option>
                                <option value="Hibah">Hibah</option>
                                <option value="Wakaf">Wakaf</option>
                                <option value="Tukar Menukar">Tukar Menukar</option>
                                <option value="Letter C / Girik">Letter C / Girik</option>
                                <option value="Tidak Ada Bukti">Tidak Ada Bukti</option>
                            </select>
                        </div>

                        {{-- Status Sertifikat & Nomor Sertifikat --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Hak <span class="text-rose-500">*</span></label>
                                <select wire:model="status_sertifikat" class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-bold text-slate-800 cursor-pointer">
                                    <option value="Sertifikat Hak Pakai">Sertifikat Hak Pakai (HP)</option>
                                    <option value="Sertifikat Hak Milik">Sertifikat Hak Milik (HM)</option>
                                    <option value="Sertifikat Hak Pengelolaan">Sertifikat Hak Pengelolaan (HPL)</option>
                                    <option value="Girik / Letter C">Girik / Letter C</option>
                                    <option value="Belum Bersertifikat">Belum Bersertifikat</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Registrasi Sertifikat</label>
                                <input type="text" wire:model="nomor_sertifikat" class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-mono placeholder-slate-400" placeholder="Contoh: 12.34.56.78.1.23456">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="lg:col-span-6 space-y-6">
                
                {{-- KARTU 3: Fisik, Luas & Geografis --}}
                <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white flex items-center justify-center font-bold shadow-xs">
                                <i class="fas fa-map-location-dot text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">Fisik, Luas & Geografis</h3>
                                <p class="text-[11px] text-emerald-800 font-medium">Dimensi luas tanah dan titik koordinat spasial</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 sm:p-7 space-y-5">
                        <div class="grid grid-cols-2 gap-5">
                            {{-- Luas --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Luas Fisik <span class="text-rose-500">*</span></label>
                                <div class="relative rounded-xl shadow-xs">
                                    <input type="number" 
                                           step="0.01" 
                                           wire:model="luas" 
                                           class="w-full rounded-xl border border-slate-200 text-sm py-2.5 pl-3.5 pr-12 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-mono font-bold" 
                                           placeholder="0"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5">
                                        <span class="text-emerald-700 sm:text-sm font-black">m²</span>
                                    </div>
                                </div>
                                @error('luas') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                            
                            {{-- Kondisi --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kondisi Lahan <span class="text-rose-500">*</span></label>
                                <select wire:model="kondisi" class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-bold text-slate-800 cursor-pointer">
                                    <option value="Baik">✨ Baik (Terawat)</option>
                                    <option value="Rusak Ringan">⚠️ Rusak Ringan</option>
                                    <option value="Rusak Berat">🛑 Rusak Berat</option>
                                </select>
                                @error('kondisi') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Penggunaan --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Peruntukan / Penggunaan <span class="text-rose-500">*</span></label>
                            <input type="text" 
                                   wire:model="penggunaan" 
                                   list="list-guna" 
                                   class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 placeholder-slate-400 bg-slate-50/60 focus:bg-white transition font-medium" 
                                   placeholder="Contoh: Tanah Kas Desa (Pertanian / Bangunan)"
                                   oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                            <datalist id="list-guna">
                                <option value="Jalan Desa"><option value="Bangunan Kantor"><option value="Tanah Bengkok"><option value="Kuburan / Makam"><option value="Pasar Desa">
                            </datalist>
                            @error('penggunaan') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat / Detail Lokasi <span class="text-rose-500">*</span></label>
                            <textarea wire:model="lokasi" rows="2" class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 placeholder-slate-400 leading-relaxed bg-slate-50/60 focus:bg-white transition font-medium" placeholder="Contoh: Dusun Soragan, Ngestiharjo, Kasihan, Bantul"></textarea>
                            @error('lokasi') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Peta Picker --}}
                        <div class="mt-4">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fas fa-map-pin text-emerald-600"></i>
                                    <span>Pin Koordinat Spasial</span>
                                </label>
                                <input type="text" wire:model="koordinat" readonly class="text-[11px] font-mono bg-emerald-50 border border-emerald-200 rounded-lg px-2.5 py-1 w-44 text-emerald-800 font-bold text-center" placeholder="Pilih pada peta...">
                            </div>
                            <div class="relative h-64 w-full bg-slate-100 rounded-2xl overflow-hidden border-2 border-emerald-100 shadow-inner">
                                <div wire:ignore id="map" class="w-full h-full z-0"></div>
                                <div class="absolute bottom-2 left-2 bg-white/95 backdrop-blur-xs px-3 py-1.5 rounded-xl shadow-xs z-[400] text-[11px] font-bold text-slate-700 pointer-events-none border border-slate-200 flex items-center gap-1.5">
                                    <i class="fas fa-hand-pointer text-emerald-600"></i> Klik peta untuk menandai titik persil tanah
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- KARTU 4: Batas Wilayah & Keterangan --}}
                <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-700 to-emerald-900 text-white flex items-center justify-center font-bold shadow-xs">
                                <i class="fas fa-border-all text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">Batas Sempadan & Catatan</h3>
                                <p class="text-[11px] text-emerald-800 font-medium">Batas fisik persil dan catatan riwayat</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 sm:p-7 space-y-4">
                        <div class="grid grid-cols-2 gap-3.5">
                            <div class="flex items-center gap-2 bg-slate-50/70 p-2.5 rounded-xl border border-slate-200 focus-within:border-emerald-500 focus-within:bg-white transition">
                                <span class="text-[10px] font-black text-emerald-700 uppercase w-12 text-right">Utara:</span>
                                <input type="text" wire:model="batas_utara" class="flex-1 bg-transparent border-none p-0 text-sm focus:ring-0 placeholder-slate-300 font-medium" placeholder="Tanah Bpk. A">
                            </div>
                            <div class="flex items-center gap-2 bg-slate-50/70 p-2.5 rounded-xl border border-slate-200 focus-within:border-emerald-500 focus-within:bg-white transition">
                                <span class="text-[10px] font-black text-emerald-700 uppercase w-12 text-right">Timur:</span>
                                <input type="text" wire:model="batas_timur" class="flex-1 bg-transparent border-none p-0 text-sm focus:ring-0 placeholder-slate-300 font-medium" placeholder="Jalan Kalurahan">
                            </div>
                            <div class="flex items-center gap-2 bg-slate-50/70 p-2.5 rounded-xl border border-slate-200 focus-within:border-emerald-500 focus-within:bg-white transition">
                                <span class="text-[10px] font-black text-emerald-700 uppercase w-12 text-right">Selatan:</span>
                                <input type="text" wire:model="batas_selatan" class="flex-1 bg-transparent border-none p-0 text-sm focus:ring-0 placeholder-slate-300 font-medium" placeholder="Saluran Irigasi">
                            </div>
                            <div class="flex items-center gap-2 bg-slate-50/70 p-2.5 rounded-xl border border-slate-200 focus-within:border-emerald-500 focus-within:bg-white transition">
                                <span class="text-[10px] font-black text-emerald-700 uppercase w-12 text-right">Barat:</span>
                                <input type="text" wire:model="batas_barat" class="flex-1 bg-transparent border-none p-0 text-sm focus:ring-0 placeholder-slate-300 font-medium" placeholder="Tanah Kas Desa Lain">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan Tambahan / Warkah</label>
                            <textarea wire:model="keterangan" rows="2" class="w-full rounded-xl border border-slate-200 text-sm py-2.5 px-3.5 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 placeholder-slate-400 bg-slate-50/60 focus:bg-white transition font-medium" placeholder="Tuliskan nomor buku C desa, asal usul hibah, dsb..."></textarea>
                        </div>

                    </div>
                </div>

                {{-- Tombol Aksi Bawah --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-2xl text-xs font-bold text-slate-700 bg-white border border-slate-300 hover:bg-slate-100 transition">
                        Batalkan
                    </a>
                    <button type="submit" wire:loading.attr="disabled" class="px-8 py-3.5 rounded-2xl font-black text-sm text-white bg-gradient-to-r from-emerald-600 via-emerald-700 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 shadow-lg shadow-emerald-700/25 transition disabled:opacity-60 flex items-center gap-2.5 cursor-pointer">
                        <span wire:loading.remove wire:target="simpan" class="flex items-center gap-2">
                            <i class="fas fa-floppy-disk text-emerald-200"></i>
                            <span>Simpan Inventaris Tanah</span>
                        </span>
                        <span wire:loading wire:target="simpan" class="flex items-center gap-2">
                            <i class="fas fa-circle-notch fa-spin text-white"></i>
                            <span>Menyimpan ke Database...</span>
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </form>

    {{-- Script Peta Spasial --}}
    <script>
        let formMap = null;
        let formMarker = null;

        document.addEventListener('livewire:navigated', () => {
            setTimeout(initAsetMap, 100);
        });

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(initAsetMap, 100);
        });

        function initAsetMap() {
            const container = document.getElementById('map');
            if (!container) return;

            if (typeof window.L === 'undefined') {
                setTimeout(initAsetMap, 200);
                return;
            }
            
            if (formMap !== null) {
                formMap.remove();
                formMap = null;
            } else if (container._leaflet_id) {
                container._leaflet_id = null;
                container.innerHTML = "";
            }
            
            formMap = L.map('map', {
                zoomControl: true,
                scrollWheelZoom: true
            }).setView([-7.6258, 110.4357], 14); 

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(formMap);

            let wire = Livewire.find(container.closest('[wire\\:id]').getAttribute('wire:id'));

            let koordinatAktual = wire.get('koordinat');
            if (koordinatAktual) {
                let parts = koordinatAktual.split(',');
                if (parts.length === 2) {
                    let lat = parseFloat(parts[0].trim());
                    let lng = parseFloat(parts[1].trim());
                    if (!isNaN(lat) && !isNaN(lng)) {
                        formMarker = L.marker([lat, lng]).addTo(formMap);
                        formMap.setView([lat, lng], 16);
                    }
                }
            }

            formMap.on('click', function(e) {
                let lat = e.latlng.lat.toFixed(6);
                let lng = e.latlng.lng.toFixed(6);
                
                if (formMarker) {
                    formMarker.setLatLng(e.latlng);
                } else {
                    formMarker = L.marker(e.latlng).addTo(formMap);
                }

                wire.set('koordinat', `${lat}, ${lng}`);
            });

            setTimeout(() => {
                if(formMap) {
                    formMap.invalidateSize();
                }
            }, 300);
        }
    </script>
</div>