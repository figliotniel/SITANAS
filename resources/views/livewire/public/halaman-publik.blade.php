<div class="min-h-screen bg-slate-50 flex flex-col selection:bg-emerald-500 selection:text-white">

    {{-- ======================================================== --}}
    {{-- 1. NAVBAR PUBLIK                                         --}}
    {{-- ======================================================== --}}
    <nav class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-slate-200/80 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                {{-- Logo & Identitas Desa --}}
                <a href="{{ route('publik') }}" wire:navigate class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 flex items-center justify-center text-white shadow-md shadow-emerald-700/20 group-hover:scale-105 transition-transform">
                        <i class="fas fa-landmark text-lg"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-lg text-slate-900 tracking-tight group-hover:text-emerald-700 transition-colors">SITANAS</span>
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 uppercase tracking-wider">Publik</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium">Kalurahan {{ $desa->nama_desa ?? 'Desa' }}</p>
                    </div>
                </a>

                {{-- Aksi Kanan (Masuk Aparatur / Dashboard) --}}
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           wire:navigate 
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm shadow-emerald-600/20 transition active:scale-95">
                            <i class="fas fa-gauge"></i>
                            <span>Buka Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           wire:navigate 
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/70 transition active:scale-95">
                            <i class="fas fa-lock text-xs"></i>
                            <span>Aparatur Desa</span>
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    {{-- ======================================================== --}}
    {{-- 2. HERO SECTION                                          --}}
    {{-- ======================================================== --}}
    <div class="relative bg-gradient-to-br from-emerald-950 via-emerald-900 to-slate-950 text-white overflow-hidden py-16 sm:py-24">
        
        {{-- Aksen Dekorasi Cahaya Latar --}}
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            {{-- Tagline Pill --}}
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-medium bg-emerald-800/60 text-emerald-200 border border-emerald-700/60 backdrop-blur-sm mb-6 animate-in fade-in">
                <i class="fas fa-shield-halved text-amber-400"></i>
                <span>Keterbukaan Informasi Aset Desa • Kalurahan {{ $desa->nama_desa ?? 'Desa' }}</span>
            </div>

            {{-- Judul Utama --}}
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                Transparansi Aset Tanah Kas Desa<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-teal-200 to-amber-200">
                    Untuk Kemakmuran Warga
                </span>
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-sm sm:text-base text-emerald-100/80 leading-relaxed">
                Informasi terbuka mengenai luas wilayah, peruntukan lahan, dan inventarisasi resmi tanah milik desa secara transparan, digital, dan akuntabel.
            </p>

            {{-- Bilah Pencarian Utama --}}
            <div class="mt-8 max-w-2xl mx-auto">
                <div class="relative flex items-center bg-white rounded-2xl shadow-xl shadow-emerald-950/40 p-2 border border-emerald-200/20">
                    <div class="pl-3.5 text-emerald-600">
                        <i class="fas fa-search text-base"></i>
                    </div>
                    
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           class="w-full pl-3 pr-4 py-2.5 text-slate-800 placeholder-slate-400 text-sm sm:text-base border-0 focus:ring-0 focus:outline-none bg-transparent"
                           placeholder="Cari lokasi, jenis penggunaan, atau kode barang tanah...">

                    @if(!empty($search))
                        <button type="button" 
                                wire:click="$set('search', '')" 
                                class="text-slate-400 hover:text-slate-600 p-2 text-sm">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    @endif
                </div>

                @if(!empty($search))
                    <p class="mt-2 text-xs text-emerald-200/90 text-left px-2">
                        Menampilkan hasil pencarian untuk: "<span class="font-bold text-white">{{ $search }}</span>"
                    </p>
                @endif
            </div>

        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- 3. KARTU STATISTIK RINGKAS PUBLIK                        --}}
    {{-- ======================================================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            
            {{-- Total Bidang --}}
            <div class="bg-white rounded-2xl p-5 shadow-lg shadow-slate-200/50 border border-slate-200/80 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fas fa-landmark"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Bidang Terdata</p>
                    <p class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ number_format($stats['totalAset']) }} <span class="text-sm font-semibold text-slate-500">Bidang</span></p>
                </div>
            </div>

            {{-- Total Luas --}}
            <div class="bg-white rounded-2xl p-5 shadow-lg shadow-slate-200/50 border border-slate-200/80 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fas fa-vector-square"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Akumulasi Luas</p>
                    <p class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ number_format($stats['totalLuas'], 0, ',', '.') }} <span class="text-sm font-semibold text-slate-500">m²</span></p>
                </div>
            </div>

            {{-- Legalitas Sertifikat --}}
            <div class="bg-white rounded-2xl p-5 shadow-lg shadow-slate-200/50 border border-slate-200/80 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fas fa-certificate"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sertifikat Resmi</p>
                    <p class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ number_format($stats['totalBersertifikat']) }} <span class="text-sm font-semibold text-slate-500">Tersertifikasi</span></p>
                </div>
            </div>

        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- 4. DAFTAR KARTU ASET TANAH (BISA DI-KLIK)                --}}
    {{-- ======================================================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-1 w-full">
        
        {{-- Section Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-8 border-b border-slate-200 pb-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Inventaris Tanah Kas Desa</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                        Sah & Disetujui
                    </span>
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Klik pada kartu tanah untuk membuka informasi rincian lengkap, batas wilayah, dan peta lokasi.
                </p>
            </div>
            
            <div class="text-xs font-semibold text-slate-500 bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-2xs">
                Ditemukan: <span class="text-emerald-700 font-bold">{{ $aset->total() }}</span> aset
            </div>
        </div>

        {{-- Grid Kartu Aset --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($aset as $item)
                <div wire:key="publik-aset-{{ $item->id }}"
                     wire:click="bukaDetail({{ $item->id }})"
                     class="bg-white rounded-2xl border border-slate-200/90 hover:border-emerald-400 hover:shadow-xl transition-all duration-200 flex flex-col group overflow-hidden cursor-pointer active:scale-[0.99]">
                    
                    {{-- Header Kartu (Preview Visual) --}}
                    <div class="h-36 bg-gradient-to-br from-emerald-800 via-teal-900 to-slate-900 relative p-4 flex flex-col justify-between overflow-hidden">
                        {{-- Pola Abstrak Dekoratif --}}
                        <div class="absolute -right-6 -bottom-6 text-white/10 text-8xl pointer-events-none group-hover:scale-110 transition-transform">
                            <i class="fas fa-map-location-dot"></i>
                        </div>

                        {{-- Badges Atas --}}
                        <div class="flex justify-between items-start relative z-10">
                            <span class="font-mono text-[11px] font-bold px-2 py-1 rounded-lg bg-white/95 backdrop-blur-xs text-slate-800 shadow-2xs">
                                {{ $item->kode_barang ?? 'KIB A' }}
                            </span>

                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-1 rounded-lg bg-emerald-500/30 backdrop-blur-xs text-emerald-200 border border-emerald-400/30">
                                <i class="fas fa-check-circle text-[10px]"></i>
                                <span>Disetujui</span>
                            </span>
                        </div>

                        {{-- Penggunaan Lahan Badge --}}
                        <div class="relative z-10">
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-white/95 bg-black/35 backdrop-blur-xs px-2.5 py-1 rounded-lg">
                                <i class="fas fa-layer-group text-emerald-400 text-xs"></i>
                                <span class="truncate max-w-[200px]">{{ $item->penggunaan ?? 'Belum ditentukan' }}</span>
                            </span>
                        </div>
                    </div>

                    {{-- Isi Kartu --}}
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        
                        <div>
                            {{-- Nama & Lokasi --}}
                            <div class="mb-4">
                                <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-1">
                                    {{ $item->nama_barang ?? $item->lokasi }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2 flex items-start gap-1.5">
                                    <i class="fas fa-location-dot text-slate-400 mt-0.5 flex-shrink-0 text-[11px]"></i>
                                    <span>{{ $item->lokasi }}</span>
                                </p>
                            </div>

                            {{-- 2 Kotak Metrik (Luas & Legalitas) --}}
                            <div class="grid grid-cols-2 gap-2.5 mb-4 text-xs">
                                <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                    <span class="text-slate-400 text-[10px] uppercase font-bold block">Luas Tanah</span>
                                    <span class="font-mono font-bold text-slate-800 text-sm">{{ number_format($item->luas, 0, ',', '.') }}</span>
                                    <span class="text-slate-500 text-[11px]">m²</span>
                                </div>
                                
                                <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                    <span class="text-slate-400 text-[10px] uppercase font-bold block">Status Sertifikat</span>
                                    <span class="font-semibold text-slate-800 truncate block text-[11px]" title="{{ $item->status_sertifikat }}">
                                        {{ $item->status_sertifikat ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Keterangan Singkat jika ada --}}
                            @if(!empty($item->keterangan))
                                <p class="text-xs text-slate-500 italic mb-4 line-clamp-2 bg-slate-50/50 p-2 rounded-lg border border-slate-100">
                                    "{{ $item->keterangan }}"
                                </p>
                            @endif
                        </div>

                        {{-- Tombol Buka Rincian --}}
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <div class="w-full py-2 px-3 rounded-xl bg-emerald-50 group-hover:bg-emerald-600 text-emerald-800 group-hover:text-white text-xs font-bold transition-all flex items-center justify-center gap-1.5 border border-emerald-200/60 group-hover:border-emerald-600">
                                <span>Lihat Rincian Lengkap</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </div>

                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-slate-200 p-8 shadow-xs">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-magnifying-glass"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Tidak ada data aset ditemukan</h3>
                    <p class="text-sm text-slate-500 mt-1 max-w-md mx-auto">
                        Coba gunakan kata kunci pencarian yang lain, atau hubungi kantor kalurahan untuk informasi lebih lanjut.
                    </p>
                    @if(!empty($search))
                        <button type="button" 
                                wire:click="$set('search', '')" 
                                class="mt-4 px-4 py-2 rounded-xl text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition">
                            Hapus Filter Pencarian
                        </button>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $aset->links() }}
        </div>

    </div>

    {{-- ======================================================== --}}
    {{-- 5. MODAL POPUP DETAIL RINCIAN ASET PUBLIK                --}}
    {{-- ======================================================== --}}
    @if($showModal && $selectedAset)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6 animate-in fade-in duration-200"
             x-data
             @keydown.escape.window="$wire.tutupDetail()">
            
            {{-- Modal Card Container --}}
            <div class="relative bg-white rounded-3xl max-w-4xl w-full max-h-[92vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden animate-in zoom-in-95 duration-200">
                
                {{-- Modal Header --}}
                <div class="px-6 py-5 bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white flex justify-between items-start border-b border-emerald-700/50">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span class="font-mono text-xs font-bold px-2.5 py-0.5 rounded-lg bg-white/20 text-white backdrop-blur-xs">
                                {{ $selectedAset->kode_barang ?? 'KIB A' }}
                            </span>
                            @if(!empty($selectedAset->nup))
                                <span class="text-xs px-2 py-0.5 rounded-lg bg-black/25 text-emerald-200">
                                    NUP: {{ $selectedAset->nup }}
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1 text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/40 text-emerald-200 border border-emerald-400/40">
                                <i class="fas fa-check-circle text-[10px]"></i>
                                <span>Disetujui & Sah</span>
                            </span>
                        </div>

                        <h2 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">
                            {{ $selectedAset->nama_barang ?? $selectedAset->lokasi }}
                        </h2>
                        <p class="text-xs sm:text-sm text-emerald-100/90 mt-0.5 flex items-center gap-1.5">
                            <i class="fas fa-location-dot text-amber-300 text-xs"></i>
                            <span>{{ $selectedAset->lokasi }}</span>
                        </p>
                    </div>

                    {{-- Tombol Tutup Silang --}}
                    <button type="button" 
                            wire:click="tutupDetail" 
                            class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition flex-shrink-0 ml-3">
                        <i class="fas fa-times text-base"></i>
                    </button>
                </div>

                {{-- Modal Body (Scrollable) --}}
                <div class="p-6 sm:p-8 overflow-y-auto space-y-6">
                    
                    {{-- 4 Metrik Ringkas Utama --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
                        
                        <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-100">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 block">Luas Tanah</span>
                            <span class="text-xl sm:text-2xl font-extrabold text-emerald-950 font-mono mt-0.5 block">
                                {{ number_format($selectedAset->luas, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-emerald-700 font-medium">Meter Persegi (m²)</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-teal-50/70 border border-teal-100">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700 block">Peruntukan Lahan</span>
                            <span class="text-base sm:text-lg font-bold text-teal-950 mt-1 block truncate" title="{{ $selectedAset->penggunaan }}">
                                {{ $selectedAset->penggunaan ?? '-' }}
                            </span>
                            <span class="text-xs text-teal-700 font-medium">Fungsi Pemanfaatan</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-100">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700 block">Status Sertifikat</span>
                            <span class="text-base sm:text-lg font-bold text-amber-950 mt-1 block truncate" title="{{ $selectedAset->status_sertifikat }}">
                                {{ $selectedAset->status_sertifikat ?? '-' }}
                            </span>
                            <span class="text-xs text-amber-700 font-medium">Aspek Legalitas</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Kondisi Fisik</span>
                            <span class="text-base sm:text-lg font-bold text-slate-900 mt-1 block">
                                {{ $selectedAset->kondisi ?? 'Baik' }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium">Keadaan Lahan</span>
                        </div>

                    </div>

                    {{-- Grid 2 Kolom Rincian --}}
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                        
                        {{-- Sisi Kiri (7 Kolom): Peta & Batas Wilayah --}}
                        <div class="lg:col-span-7 space-y-6">
                            
                            {{-- Peta Lokasi Interaktif --}}
                            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                                <div class="px-5 py-3.5 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                                        <i class="fas fa-map-marked-alt text-emerald-600"></i>
                                        <span>Peta Lokasi Bidang Tanah</span>
                                    </h4>
                                    @if(!empty($selectedAset->koordinat))
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($selectedAset->koordinat) }}" 
                                           target="_blank" 
                                           class="text-[11px] font-semibold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                                            <span>Buka di Google Maps</span>
                                            <i class="fas fa-external-link-alt text-[9px]"></i>
                                        </a>
                                    @endif
                                </div>

                                @if(!empty($selectedAset->koordinat))
                                    <div id="mapPublic" class="h-64 w-full bg-slate-100 z-0"></div>
                                    <div class="p-3 bg-slate-50/70 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                                        <span>Titik Koordinat: <strong class="font-mono text-slate-800">{{ $selectedAset->koordinat }}</strong></span>
                                        <span class="text-emerald-700"><i class="fas fa-check-double mr-1"></i>Tervalidasi GPS</span>
                                    </div>
                                @else
                                    <div class="h-48 flex flex-col items-center justify-center p-6 text-center text-slate-400 bg-slate-50/50">
                                        <i class="fas fa-map-location-dot text-3xl mb-2 text-slate-300"></i>
                                        <p class="text-xs font-medium text-slate-600">Titik Koordinat GPS Belum Tercatat</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Bidang tanah ini belum dilengkapi data titik koordinat digital.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Batas-Batas Wilayah (4 Penjuru) --}}
                            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3.5 flex items-center gap-2">
                                    <i class="fas fa-compass text-amber-500"></i>
                                    <span>Batas-Batas Wilayah (Patok Batas)</span>
                                </h4>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                    
                                    {{-- Utara --}}
                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-2.5">
                                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-[11px] flex-shrink-0">
                                            U
                                        </span>
                                        <div>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Batas Utara</span>
                                            <span class="font-semibold text-slate-800 mt-0.5 block leading-relaxed">
                                                {{ $selectedAset->batas_utara ?? 'Tidak ada data batas' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Timur --}}
                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-2.5">
                                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-[11px] flex-shrink-0">
                                            T
                                        </span>
                                        <div>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Batas Timur</span>
                                            <span class="font-semibold text-slate-800 mt-0.5 block leading-relaxed">
                                                {{ $selectedAset->batas_timur ?? 'Tidak ada data batas' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Selatan --}}
                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-2.5">
                                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-[11px] flex-shrink-0">
                                            S
                                        </span>
                                        <div>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Batas Selatan</span>
                                            <span class="font-semibold text-slate-800 mt-0.5 block leading-relaxed">
                                                {{ $selectedAset->batas_selatan ?? 'Tidak ada data batas' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Barat --}}
                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-2.5">
                                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-[11px] flex-shrink-0">
                                            B
                                        </span>
                                        <div>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Batas Barat</span>
                                            <span class="font-semibold text-slate-800 mt-0.5 block leading-relaxed">
                                                {{ $selectedAset->batas_barat ?? 'Tidak ada data batas' }}
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        {{-- Sisi Kanan (5 Kolom): Legalitas, Asal Usul, Status Pemanfaatan --}}
                        <div class="lg:col-span-5 space-y-6">
                            
                            {{-- Legalitas & Bukti Kepemilikan --}}
                            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-3.5 text-xs">
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider border-b border-slate-100 pb-2.5 flex items-center gap-2">
                                    <i class="fas fa-file-contract text-emerald-600"></i>
                                    <span>Kepastian Hukum & Legalitas</span>
                                </h4>

                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Nomor Sertifikat</span>
                                    <span class="font-mono font-semibold text-slate-900 text-sm mt-0.5 block">
                                        {{ $selectedAset->nomor_sertifikat ?? '-' }}
                                    </span>
                                </div>

                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Tanggal Sertifikat</span>
                                    <span class="font-medium text-slate-800 mt-0.5 block">
                                        {{ $selectedAset->tanggal_sertifikat ? \Carbon\Carbon::parse($selectedAset->tanggal_sertifikat)->format('d F Y') : '-' }}
                                    </span>
                                </div>

                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Asal Perolehan</span>
                                    <span class="font-medium text-slate-800 mt-0.5 block">
                                        {{ $selectedAset->asal_perolehan ?? '-' }}
                                    </span>
                                </div>

                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Bukti Perolehan</span>
                                    <span class="font-medium text-slate-800 mt-0.5 block">
                                        {{ $selectedAset->bukti_perolehan ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Catatan / Keterangan --}}
                            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs text-xs">
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2.5 flex items-center gap-2">
                                    <i class="fas fa-note-sticky text-amber-500"></i>
                                    <span>Keterangan Tambahan</span>
                                </h4>
                                <p class="text-slate-600 leading-relaxed bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                                    {{ $selectedAset->keterangan ?? 'Tidak ada catatan keterangan khusus pada buku inventaris untuk tanah ini.' }}
                                </p>
                            </div>

                            {{-- Status Pemanfaatan Terkini --}}
                            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs text-xs">
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2.5 flex items-center gap-2">
                                    <i class="fas fa-handshake text-teal-600"></i>
                                    <span>Status Sewa / Kerjasama</span>
                                </h4>

                                @php
                                    $kontrakAktif = $selectedAset->pemanfaatan
                                        ? $selectedAset->pemanfaatan->first(fn($p) => \Carbon\Carbon::parse($p->tanggal_selesai)->isFuture() || \Carbon\Carbon::parse($p->tanggal_selesai)->isToday())
                                        : null;
                                @endphp

                                @if($kontrakAktif)
                                    <div class="p-3 rounded-xl bg-teal-50 border border-teal-200/80">
                                        <div class="flex items-center gap-2 text-teal-800 font-bold mb-1">
                                            <i class="fas fa-clock"></i>
                                            <span>Sedang Dimanfaatkan ({{ $kontrakAktif->bentuk_pemanfaatan }})</span>
                                        </div>
                                        <p class="text-teal-700 text-[11px] leading-relaxed">
                                            Masa berlaku kontrak hingga <strong>{{ \Carbon\Carbon::parse($kontrakAktif->tanggal_selesai)->format('d M Y') }}</strong>
                                        </p>
                                    </div>
                                @else
                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-slate-500 text-[11px] flex items-center gap-2">
                                        <i class="fas fa-circle-check text-emerald-600"></i>
                                        <span>Dikelola Langsung oleh Pemerintah Kalurahan (Bebas Sewa).</span>
                                    </div>
                                @endif
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Modal Footer --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <div class="text-[11px] text-slate-500 text-center sm:text-left flex items-center gap-1.5">
                        <i class="fas fa-shield-halved text-emerald-600"></i>
                        <span>Data resmi Buku Inventaris KIB A Kalurahan {{ $desa->nama_desa ?? 'Desa' }}.</span>
                    </div>

                    <button type="button" 
                            wire:click="tutupDetail" 
                            class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition cursor-pointer">
                        Tutup Rincian
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ======================================================== --}}
    {{-- 6. FOOTER RESMI (KOMPREHENSIF & BERWIBAWA GOVTECH)       --}}
    {{-- ======================================================== --}}
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 mt-auto pt-14 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Bagian Atas: 4 Kolom Informasi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10 pb-12 border-b border-slate-800 text-xs">
                
                {{-- Kolom 1: Profil & Identitas Lembaga (4 Kolom di Desktop) --}}
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white text-lg shadow-sm">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <div>
                            <span class="font-bold text-base text-white tracking-tight">SITANAS</span>
                            <p class="text-[11px] text-emerald-400 font-medium">Kalurahan {{ $desa->nama_desa ?? 'Ngestiharjo' }}</p>
                        </div>
                    </div>

                    <p class="text-slate-400 leading-relaxed text-xs">
                        Portal Transparansi dan Sistem Informasi Tanah Kas Desa resmi Pemerintah Kalurahan {{ $desa->nama_desa ?? 'Ngestiharjo' }}. Mendukung digitalisasi buku inventaris aset tanah (KIB A) yang akuntabel, tertib administrasi, dan berlandaskan kepastian hukum.
                    </p>

                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-800/80 border border-slate-700 text-[11px] text-slate-300">
                        <i class="fas fa-scale-balanced text-amber-400"></i>
                        <span>Sesuai Permendagri No. 1 Tahun 2016</span>
                    </div>
                </div>

                {{-- Kolom 2: Kontak & Kantor Layanan (3 Kolom di Desktop) --}}
                <div class="lg:col-span-3 space-y-3.5">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-building text-emerald-400"></i>
                        <span>Kantor Pelayanan</span>
                    </h4>

                    <div class="space-y-2.5 text-slate-400">
                        <p class="flex items-start gap-2">
                            <i class="fas fa-location-dot text-slate-500 mt-0.5 text-xs flex-shrink-0"></i>
                            <span class="leading-relaxed">{{ $desa->alamat_kantor ?? 'Jl. Soragan No. 1, Kasihan, Bantul' }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-map text-slate-500 text-xs flex-shrink-0"></i>
                            <span>Kapanewon {{ $desa->kecamatan ?? 'Kasihan' }}, {{ $desa->kabupaten ?? 'Kab. Bantul' }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-phone text-slate-500 text-xs flex-shrink-0"></i>
                            <span>{{ $desa->telepon ?? '(0274) 378123' }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-envelope text-slate-500 text-xs flex-shrink-0"></i>
                            <span class="truncate">{{ $desa->email ?? 'kalurahan@desa.id' }}</span>
                        </p>
                    </div>

                    <div class="pt-2">
                        <span class="text-[11px] text-slate-400 block font-medium">Jam Pelayanan Kantor:</span>
                        <span class="text-slate-300 font-semibold text-[11px]">Senin – Jumat: 08.00 – 15.30 WIB</span>
                    </div>
                </div>

                {{-- Kolom 3: Layanan & Informasi Pertanahan (3 Kolom di Desktop) --}}
                <div class="lg:col-span-3 space-y-3.5">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-circle-info text-teal-400"></i>
                        <span>Layanan & Pengaduan</span>
                    </h4>

                    <ul class="space-y-2.5 text-slate-400">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-chevron-right text-emerald-500 text-[10px] mt-1 flex-shrink-0"></i>
                            <span>Klarifikasi patok & sengketa batas tanah melalui Jagabaya / Kasi Pemerintahan.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-chevron-right text-emerald-500 text-[10px] mt-1 flex-shrink-0"></i>
                            <span>Permohonan sewa pemanfaatan tanah kas desa bagi kelompok masyarakat.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-chevron-right text-emerald-500 text-[10px] mt-1 flex-shrink-0"></i>
                            <span>Monitoring keterbukaan informasi publik dan akuntabilitas aset kalurahan.</span>
                        </li>
                    </ul>

                    <div class="pt-1">
                        <a href="{{ route('login') }}" 
                           wire:navigate 
                           class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-950/80 border border-emerald-700/60 text-emerald-300 hover:text-white hover:bg-emerald-800 transition text-[11px] font-semibold">
                            <i class="fas fa-lock text-[10px]"></i>
                            <span>Login Khusus Aparatur Desa</span>
                        </a>
                    </div>
                </div>

                {{-- Kolom 4: Pengesahan & Pejabat Desa (2 Kolom di Desktop) --}}
                <div class="lg:col-span-2 space-y-3.5">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-stamp text-amber-400"></i>
                        <span>Pengesahan</span>
                    </h4>

                    <div class="p-3.5 rounded-xl bg-slate-800/60 border border-slate-700 space-y-2">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Lurah / Kepala Desa</span>
                        <p class="font-bold text-white text-xs leading-snug">{{ $desa->nama_kepala_desa ?? 'H. Fathoni Ahad, S.H.' }}</p>
                        @if(!empty($desa->nip_kepala_desa) && $desa->nip_kepala_desa != '-')
                            <p class="text-[10px] font-mono text-slate-400">NIP: {{ $desa->nip_kepala_desa }}</p>
                        @endif
                        <span class="inline-flex items-center gap-1 text-[10px] text-emerald-400 font-semibold pt-1">
                            <i class="fas fa-circle-check text-[9px]"></i>
                            <span>Verifikator Sah</span>
                        </span>
                    </div>

                    <div class="text-[11px] text-slate-500 flex items-center gap-1.5">
                        <i class="fas fa-shield-halved text-emerald-500"></i>
                        <span>Standar SPBE Terpadu</span>
                    </div>
                </div>

            </div>

            {{-- Bagian Bawah: Sub-Footer Hak Cipta & Keamanan --}}
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left text-xs text-slate-500">
                <div>
                    &copy; {{ date('Y') }} Pemerintah Kalurahan {{ $desa->nama_desa ?? 'Desa' }}. Sistem Informasi Tanah Kas Desa (SITANAS).
                </div>

                <div class="flex items-center gap-4 text-[11px]">
                    <span class="flex items-center gap-1.5 text-slate-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Server Kalurahan Aktif</span>
                    </span>
                    <span>•</span>
                    <span>v2.0 Kelompok Biru</span>
                </div>
            </div>

        </div>
    </footer>

</div>

{{-- Script Inisialisasi Peta Leaflet untuk Modal Publik --}}
<script>
    document.addEventListener('livewire:navigated', setupPublicMapListeners);
    document.addEventListener('DOMContentLoaded', setupPublicMapListeners);

    function setupPublicMapListeners() {
        window.addEventListener('open-public-map', (event) => {
            const data = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            if (!data || !data.koordinat) return;

            // Tunggu modal selesai di-render DOM
            setTimeout(() => {
                initPublicMap(data.koordinat, data.lokasi, data.luas);
            }, 200);
        });
    }

    function initPublicMap(koordinat, lokasi, luas) {
        if (!koordinat) return;
        const parts = koordinat.split(',');
        if (parts.length !== 2) return;

        const lat = parseFloat(parts[0].trim());
        const lng = parseFloat(parts[1].trim());
        if (isNaN(lat) || isNaN(lng)) return;

        const container = document.getElementById('mapPublic');
        if (!container) return;

        // Reset container Leaflet jika sebelumnya sudah pernah dibuat
        if (container._leaflet_id) {
            container._leaflet_id = null;
        }
        container.innerHTML = "";

        if (typeof L === 'undefined') return;

        var map = L.map('mapPublic', {
            zoomControl: true,
            scrollWheelZoom: false
        }).setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("<b>" + lokasi + "</b><br>Luas: " + luas)
            .openPopup();

        setTimeout(() => {
            map.invalidateSize();
        }, 300);
    }
</script>