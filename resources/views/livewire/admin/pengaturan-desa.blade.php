<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    {{-- ========================================== --}}
    {{-- 1. HEADER HALAMAN ELEGAN BERAKSEN EMERALD  --}}
    {{-- ========================================== --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900 p-6 sm:p-8 text-white shadow-xl shadow-emerald-950/15 border border-emerald-700/50">
        {{-- Aksen Dekoratif Glow di Sudut --}}
        <div class="absolute -right-10 -top-10 w-72 h-72 rounded-full bg-emerald-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-16 w-60 h-60 rounded-full bg-teal-300/15 blur-2xl pointer-events-none"></div>
        <div class="absolute left-1/4 -top-8 w-40 h-40 rounded-full bg-emerald-600/20 blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/15 text-emerald-200 backdrop-blur-md border border-white/20">
                    <i class="fas fa-landmark text-emerald-300"></i>
                    <span>Konfigurasi Instansi Pemerintah Desa</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white flex items-center gap-3">
                    <span>Pengaturan Identitas & Profil Desa</span>
                </h1>
                <p class="text-sm text-emerald-100/90 max-w-2xl font-medium leading-relaxed">
                    Atur identitas resmi kalurahan/desa. Data ini menjadi acuan baku untuk pencetakan kepala surat (KOP), dokumen Buku Inventaris Tanah (KIB A), berita acara, serta portal transparansi publik.
                </p>
            </div>

            <div class="shrink-0 flex items-center">
                <button type="submit" 
                        form="form-pengaturan-desa"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2.5 px-6 py-3 rounded-2xl font-extrabold text-sm text-emerald-950 bg-emerald-300 hover:bg-emerald-200 hover:shadow-emerald-400/30 shadow-lg shadow-emerald-950/30 transition-all active:scale-[0.98] disabled:opacity-60 cursor-pointer">
                    <span wire:loading.remove wire:target="simpan" class="flex items-center gap-2">
                        <i class="fas fa-floppy-disk text-emerald-900"></i>
                        <span>Simpan Perubahan</span>
                    </span>
                    <span wire:loading wire:target="simpan" class="flex items-center gap-2">
                        <i class="fas fa-circle-notch fa-spin text-emerald-900"></i>
                        <span>Menyimpan...</span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. NOTIFIKASI BERHASIL DISIMPAN            --}}
    {{-- ========================================== --}}
    @if (session()->has('success'))
        <div class="p-4 sm:p-5 bg-gradient-to-r from-emerald-500/15 via-emerald-50 to-teal-50 border-2 border-emerald-300/80 text-emerald-900 rounded-2xl flex items-center justify-between shadow-sm animate-in fade-in slide-in-from-top-2">
            <div class="flex items-center gap-3.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-sm shadow-emerald-600/30">
                    <i class="fas fa-check text-sm font-black"></i>
                </div>
                <div>
                    <h4 class="text-sm font-black text-emerald-950">Profil Desa Berhasil Diperbarui!</h4>
                    <p class="text-xs text-emerald-700 font-medium mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
            <span class="text-[11px] font-extrabold text-emerald-800 bg-emerald-100/90 px-3 py-1 rounded-xl border border-emerald-300">
                Tersimpan
            </span>
        </div>
    @endif

    {{-- ========================================== --}}
    {{-- 3. GRID UTAMA: FORM & LIVE PREVIEW KOP     --}}
    {{-- ========================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- ========================================== --}}
        {{-- SISI KIRI: FORMULIR INPUT (7 KOLOM)        --}}
        {{-- ========================================== --}}
        <div class="lg:col-span-7 space-y-6">
            <form id="form-pengaturan-desa" wire:submit="simpan" class="space-y-6">
                
                {{-- KARTU 1: IDENTITAS WILAYAH --}}
                <div class="bg-white rounded-3xl border border-emerald-100/90 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    {{-- Header Kartu Beraksen Hijau Lembut --}}
                    <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 text-white flex items-center justify-center font-bold shadow-xs shadow-emerald-700/25">
                                <i class="fas fa-landmark text-sm"></i>
                            </div>
                            <div>
                                <h2 class="text-sm sm:text-base font-extrabold text-slate-900">Identitas & Wilayah Administratif</h2>
                                <p class="text-[11px] text-emerald-800 font-medium">Data registrasi resmi dari Kementerian Dalam Negeri</p>
                            </div>
                        </div>
                        <span class="hidden sm:inline-flex text-[10px] font-extrabold text-emerald-700 bg-emerald-100/70 px-2.5 py-1 rounded-lg border border-emerald-200">
                            Bagian 1/3
                        </span>
                    </div>

                    <div class="p-6 sm:p-7 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            {{-- Nama Desa --}}
                            <div class="sm:col-span-2">
                                <label class="flex items-center justify-between text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                        Nama Desa / Kalurahan <span class="text-rose-500">*</span>
                                    </span>
                                    <span class="text-[10px] text-emerald-800 font-extrabold bg-emerald-100/80 px-2 py-0.5 rounded-md border border-emerald-200">Wajib</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                                        <i class="fas fa-building text-xs"></i>
                                    </span>
                                    <input type="text" 
                                           wire:model.live.debounce.300ms="nama_desa" 
                                           placeholder="Contoh: Ngestiharjo"
                                           class="block w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition" 
                                           required>
                                </div>
                                @error('nama_desa') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Kode Desa --}}
                            <div class="sm:col-span-2">
                                <label class="flex items-center justify-between text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                        Kode Desa (Kemendagri)
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-medium">Opsional</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                                        <i class="fas fa-barcode text-xs"></i>
                                    </span>
                                    <input type="text" 
                                           wire:model.live.debounce.300ms="kode_desa" 
                                           placeholder="Contoh: 34.02.15.2001"
                                           class="block w-full pl-10 pr-4 py-2.5 text-sm font-mono bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition">
                                </div>
                                <span class="text-[11px] text-slate-400 mt-1 block">Kode registrasi wilayah administrasi nasional dari Kemendagri.</span>
                            </div>

                            {{-- Kecamatan --}}
                            <div>
                                <label class="flex items-center justify-between text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                        Kecamatan / Kapanewon <span class="text-rose-500">*</span>
                                    </span>
                                </label>
                                <input type="text" 
                                       wire:model.live.debounce.300ms="kecamatan" 
                                       placeholder="Contoh: Kasihan"
                                       class="block w-full px-3.5 py-2.5 text-sm bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition" 
                                       required>
                                @error('kecamatan') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Kabupaten --}}
                            <div>
                                <label class="flex items-center justify-between text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                        Kabupaten / Kota <span class="text-rose-500">*</span>
                                    </span>
                                </label>
                                <input type="text" 
                                       wire:model.live.debounce.300ms="kabupaten" 
                                       placeholder="Contoh: Bantul"
                                       class="block w-full px-3.5 py-2.5 text-sm bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition" 
                                       required>
                                @error('kabupaten') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Provinsi --}}
                            <div>
                                <label class="flex items-center justify-between text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                        Provinsi <span class="text-rose-500">*</span>
                                    </span>
                                </label>
                                <input type="text" 
                                       wire:model.live.debounce.300ms="provinsi" 
                                       placeholder="Contoh: D.I. Yogyakarta"
                                       class="block w-full px-3.5 py-2.5 text-sm bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition" 
                                       required>
                                @error('provinsi') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Kode Pos --}}
                            <div>
                                <label class="flex items-center justify-between text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                        Kode Pos
                                    </span>
                                </label>
                                <input type="text" 
                                       wire:model.live.debounce.300ms="kode_pos" 
                                       placeholder="Contoh: 55182"
                                       class="block w-full px-3.5 py-2.5 text-sm font-mono bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KARTU 2: ALAMAT KANTOR & KONTAK --}}
                <div class="bg-white rounded-3xl border border-emerald-100/90 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white flex items-center justify-center font-bold shadow-xs shadow-emerald-700/25">
                                <i class="fas fa-map-location-dot text-sm"></i>
                            </div>
                            <div>
                                <h2 class="text-sm sm:text-base font-extrabold text-slate-900">Alamat Kantor & Saluran Komunikasi</h2>
                                <p class="text-[11px] text-emerald-800 font-medium">Informasi fisik sekretariat kantor dan kontak dinas</p>
                            </div>
                        </div>
                        <span class="hidden sm:inline-flex text-[10px] font-extrabold text-emerald-700 bg-emerald-100/70 px-2.5 py-1 rounded-lg border border-emerald-200">
                            Bagian 2/3
                        </span>
                    </div>

                    <div class="p-6 sm:p-7 space-y-4">
                        {{-- Alamat Kantor --}}
                        <div>
                            <label class="flex items-center gap-1.5 text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                Alamat Lengkap Kantor Desa
                            </label>
                            <textarea wire:model.live.debounce.300ms="alamat_kantor" 
                                      rows="2" 
                                      placeholder="Nama jalan, nomor gedung, dusun/padukuhan..."
                                      class="block w-full px-3.5 py-2.5 text-sm bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Telepon --}}
                            <div>
                                <label class="flex items-center gap-1.5 text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                    Telepon / Saluran Hotline
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                                        <i class="fas fa-phone text-xs"></i>
                                    </span>
                                    <input type="text" 
                                           wire:model.live.debounce.300ms="telepon" 
                                           placeholder="Contoh: (0274) 378123"
                                           class="block w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition">
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="flex items-center gap-1.5 text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                    Email Resmi Desa (.go.id / domain)
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                                        <i class="fas fa-envelope text-xs"></i>
                                    </span>
                                    <input type="email" 
                                           wire:model.live.debounce.300ms="email" 
                                           placeholder="desa@bantulkab.go.id"
                                           class="block w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KARTU 3: PEJABAT PENANDATANGAN RESMI --}}
                <div class="bg-white rounded-3xl border border-emerald-100/90 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-700 to-emerald-900 text-white flex items-center justify-center font-bold shadow-xs shadow-emerald-700/25">
                                <i class="fas fa-signature text-sm"></i>
                            </div>
                            <div>
                                <h2 class="text-sm sm:text-base font-extrabold text-slate-900">Pejabat Pengesah (Kepala Desa / Lurah)</h2>
                                <p class="text-[11px] text-emerald-800 font-medium">Penandatangan sah dokumen KIB A dan laporan inventaris</p>
                            </div>
                        </div>
                        <span class="hidden sm:inline-flex text-[10px] font-extrabold text-emerald-700 bg-emerald-100/70 px-2.5 py-1 rounded-lg border border-emerald-200">
                            Bagian 3/3
                        </span>
                    </div>

                    <div class="p-6 sm:p-7 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            {{-- Nama Kepala Desa --}}
                            <div>
                                <label class="flex items-center justify-between text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                        Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                                    </span>
                                    <span class="text-[10px] text-emerald-800 font-bold bg-emerald-100/80 px-2 py-0.5 rounded-md border border-emerald-200">Pengesah</span>
                                </label>
                                <input type="text" 
                                       wire:model.live.debounce.300ms="nama_kepala_desa" 
                                       placeholder="Contoh: H. Fathoni Ahad, S.H."
                                       class="block w-full px-3.5 py-2.5 text-sm bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition" 
                                       required>
                                @error('nama_kepala_desa') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- NIP / NRPDes --}}
                            <div>
                                <label class="flex items-center justify-between text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-circle text-[6px] text-emerald-600"></i>
                                        NIP / NRPDes Kepala Desa
                                    </span>
                                </label>
                                <input type="text" 
                                       wire:model.live.debounce.300ms="nip_kepala_desa" 
                                       placeholder="Nomor pegawai atau tanda strip (-)"
                                       class="block w-full px-3.5 py-2.5 text-sm font-mono bg-slate-50/60 border border-slate-200 rounded-xl hover:border-emerald-300 focus:bg-white focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition">
                                <span class="text-[11px] text-slate-400 mt-1 block">Tuliskan tanda (-) jika tidak memiliki NIP PNS.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL SIMPAN BAWAH --}}
                <div class="flex items-center justify-end pt-2">
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-3.5 rounded-2xl font-black text-sm text-white bg-gradient-to-r from-emerald-600 via-emerald-700 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 shadow-lg shadow-emerald-700/25 hover:shadow-xl transition-all active:scale-[0.98] disabled:opacity-60 cursor-pointer">
                        <span wire:loading.remove wire:target="simpan" class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-200"></i>
                            <span>Simpan Seluruh Pengaturan Desa</span>
                        </span>
                        <span wire:loading wire:target="simpan" class="flex items-center gap-2">
                            <i class="fas fa-circle-notch fa-spin text-white"></i>
                            <span>Menyimpan Perubahan Data...</span>
                        </span>
                    </button>
                </div>

            </form>
        </div>

        {{-- ========================================== --}}
        {{-- SISI KANAN: PRATINJAU KOP SURAT (5 KOLOM)  --}}
        {{-- ========================================== --}}
        <div class="lg:col-span-5 space-y-6 lg:sticky lg:top-24">
            
            {{-- KARTU PRATINJAU KOP SURAT RESMI BERAKSEN HIJAU --}}
            <div class="bg-white rounded-3xl border-2 border-emerald-200/90 shadow-md shadow-emerald-900/5 overflow-hidden">
                {{-- Top Bar Panel Pratinjau --}}
                <div class="bg-gradient-to-r from-emerald-800 via-emerald-850 to-teal-900 text-white px-5 py-3.5 flex items-center justify-between border-b border-emerald-700/60">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-emerald-100 flex items-center gap-1.5">
                            <i class="fas fa-eye text-emerald-300 text-xs"></i>
                            Pratinjau KOP Dokumen Resmi
                        </h3>
                    </div>
                    <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-white/15 text-emerald-200 border border-white/20">
                        Live Preview
                    </span>
                </div>

                {{-- LEMBAR KERTAS PRATINJAU KOP KEDINASAN --}}
                <div class="p-5 sm:p-6 bg-emerald-50/20">
                    <div class="bg-white border-2 border-emerald-100 rounded-2xl p-5 text-center space-y-2 select-none shadow-sm relative overflow-hidden">
                        {{-- Ribbon Aksen Tipis Hijau di Atas Kertas --}}
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600"></div>

                        {{-- Logo & Heading Dokumen --}}
                        <div class="flex justify-center mb-1 pt-1">
                            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-emerald-700 to-emerald-900 text-white shadow-sm flex items-center justify-center border-2 border-emerald-100">
                                <i class="fas fa-shield-halved text-base text-emerald-200"></i>
                            </div>
                        </div>

                        <div class="space-y-0.5">
                            <p class="text-[11px] font-extrabold text-slate-800 tracking-wider uppercase">
                                Pemerintah Kabupaten {{ $kabupaten ?: '[Kabupaten]' }}
                            </p>
                            <p class="text-[10px] font-bold text-slate-600 tracking-wide uppercase">
                                Kecamatan {{ $kecamatan ?: '[Kecamatan]' }}
                            </p>
                            <h4 class="text-sm font-black text-emerald-950 tracking-tight uppercase">
                                Pemerintah Kalurahan {{ $nama_desa ?: '[Nama Desa]' }}
                            </h4>
                            @if($kode_desa)
                                <p class="text-[9px] font-mono text-emerald-800 font-semibold bg-emerald-50 inline-block px-2 py-0.5 rounded">
                                    Kode Wilayah: {{ $kode_desa }}
                                </p>
                            @endif
                        </div>

                        {{-- Alamat & Kontak --}}
                        <div class="text-[9px] text-slate-500 leading-tight pt-1">
                            <p>{{ $alamat_kantor ?: 'Alamat Kantor Pemerintahan Desa' }}</p>
                            <p class="mt-0.5 font-medium text-slate-600">
                                @if($telepon) <span>Telp: {{ $telepon }}</span> @endif
                                @if($telepon && $email) <span> | </span> @endif
                                @if($email) <span class="text-emerald-700 font-semibold">Email: {{ $email }}</span> @endif
                                @if($kode_pos) <span> | Pos: {{ $kode_pos }}</span> @endif
                            </p>
                        </div>

                        {{-- Garis Ganda Standar Kedinasan (Kop Surat) --}}
                        <div class="pt-2">
                            <div class="border-t-2 border-slate-900"></div>
                            <div class="border-t border-slate-900 mt-0.5"></div>
                        </div>

                        {{-- Mock Dokumen Inventaris --}}
                        <div class="pt-3 pb-2 text-left">
                            <div class="text-center font-black text-[10px] text-emerald-950 uppercase tracking-tight">
                                KARTU INVENTARIS BARANG (KIB) A - TANAH KAS
                            </div>
                            <div class="h-2 w-3/4 bg-emerald-100/80 rounded mx-auto mt-2"></div>
                            <div class="h-1.5 w-1/2 bg-slate-100 rounded mx-auto mt-1"></div>
                        </div>

                        {{-- Pratinjau Tanda Tangan Kades --}}
                        <div class="pt-4 flex justify-end text-right">
                            <div class="text-center text-[10px] min-w-[145px] bg-emerald-50/40 p-2 rounded-xl border border-emerald-100">
                                <p class="text-slate-500 text-[9px]">{{ $kabupaten ?: 'Wilayah' }}, {{ now()->format('d M Y') }}</p>
                                <p class="font-bold text-slate-800">Lurah / Kepala Desa</p>
                                <div class="h-10 flex items-center justify-center text-emerald-600/40 italic text-[10px]">
                                    (Tanda Tangan & Cap)
                                </div>
                                <p class="font-black text-emerald-950 underline">{{ $nama_kepala_desa ?: '[Nama Kepala Desa]' }}</p>
                                <p class="text-[9px] font-mono text-slate-500">NIP. {{ $nip_kepala_desa ?: '-' }}</p>
                            </div>
                        </div>

                    </div>

                    <p class="text-[11px] text-emerald-800 font-medium text-center mt-3 flex items-center justify-center gap-1.5">
                        <i class="fas fa-arrows-rotate text-[10px] text-emerald-600"></i>
                        <span>Pratinjau otomatis bereaksi sesuai ketikan formulir Anda.</span>
                    </p>
                </div>
            </div>

            {{-- KARTU INFORMASI PENGGUNAAN DATA BERAKSEN HIJAU KEDINASAN --}}
            <div class="bg-gradient-to-br from-emerald-900 via-emerald-850 to-slate-900 rounded-3xl p-6 text-white border border-emerald-600/40 shadow-xl shadow-emerald-950/20 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center font-bold border border-emerald-400/30">
                        <i class="fas fa-circle-info"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-wider text-emerald-300">Pemanfaatan Data Profil</h4>
                        <p class="text-xs text-emerald-100/80">Integrasi otomatis ke seluruh modul SITANAS</p>
                    </div>
                </div>

                <ul class="space-y-3 text-xs text-slate-200 divide-y divide-emerald-800/60">
                    <li class="flex items-start gap-2.5 pt-2 first:pt-0">
                        <div class="w-6 h-6 rounded-lg bg-rose-500/20 text-rose-300 flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fas fa-file-pdf text-[10px]"></i>
                        </div>
                        <div>
                            <span class="font-bold text-white">Dokumen Ekspor PDF:</span>
                            <p class="text-slate-300 text-[11px] mt-0.5">Menjadi KOP surat baku pada laporan rekapitulasi KIB A dan lembar cetak detail persil tanah.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2.5 pt-2">
                        <div class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fas fa-globe text-[10px]"></i>
                        </div>
                        <div>
                            <span class="font-bold text-white">Portal Informasi Publik:</span>
                            <p class="text-slate-300 text-[11px] mt-0.5">Nama dan kontak kalurahan ditampilkan di header portal transparansi warga.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2.5 pt-2">
                        <div class="w-6 h-6 rounded-lg bg-amber-500/20 text-amber-300 flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fas fa-file-signature text-[10px]"></i>
                        </div>
                        <div>
                            <span class="font-bold text-white">Legalitas Pengesahan:</span>
                            <p class="text-slate-300 text-[11px] mt-0.5">Nama Lurah/Kepala Desa tercetak otomatis di lembar berita acara pengesahan buku inventaris.</p>
                        </div>
                    </li>
                </ul>
            </div>

        </div>

    </div>

</div>
