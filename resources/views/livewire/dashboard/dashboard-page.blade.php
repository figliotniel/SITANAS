<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">
    
    {{-- ========================================== --}}
    {{-- 1. HERO BANNER PRESTIGE KEDINASAN          --}}
    {{-- ========================================== --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 p-6 sm:p-7 text-white shadow-xl shadow-emerald-950/15 border border-emerald-700/50">
        {{-- Efek Ambient Glow Halus --}}
        <div class="absolute -right-8 -top-8 w-64 h-64 rounded-full bg-emerald-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-10 w-48 h-48 rounded-full bg-teal-300/15 blur-2xl pointer-events-none"></div>
        <div class="absolute left-1/3 -top-10 w-32 h-32 rounded-full bg-emerald-500/15 blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/15 text-emerald-200 backdrop-blur-md border border-white/20">
                    <i class="fas fa-landmark text-emerald-300"></i>
                    <span>Sistem Informasi Tanah Kas Desa (SITANAS)</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Dashboard Aset Kalurahan
                </h1>
                <p class="text-sm text-emerald-100/90 font-medium max-w-2xl">
                    Selamat datang kembali, <strong>{{ auth()->user()->nama_lengkap }}</strong>. Ringkasan inventarisasi KIB A, status validasi pimpinan, dan pemantauan masa sewa tanah kas.
                </p>
            </div>
            
            @if(auth()->user()->role_id == 1)
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('aset.tambah') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl font-black text-sm text-emerald-950 bg-emerald-300 hover:bg-emerald-200 shadow-lg shadow-emerald-950/30 transition-all active:scale-95 cursor-pointer">
                        <i class="fas fa-plus-circle text-emerald-900 text-base"></i>
                        <span>Tambah Data Baru</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. KARTU METRIK UTAMA BERWARNA & BERAKSEN   --}}
    {{-- ========================================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        {{-- KARTU 1: TOTAL ASET (HERO GREEN CARD) --}}
        <div class="bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-800 text-white rounded-3xl p-6 shadow-lg shadow-emerald-700/25 border border-emerald-500/40 relative overflow-hidden group hover:scale-[1.02] transition-transform">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform pointer-events-none"></div>
            
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-200 uppercase tracking-wider">Total Aset Tanah</span>
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-xl shadow-xs">
                    <i class="fas fa-landmark"></i>
                </div>
            </div>
            
            <div class="mt-4">
                <p class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    {{ number_format($stats['total_bidang'] ?? 0) }}
                </p>
                <div class="flex items-center gap-1.5 text-xs text-emerald-100 font-medium mt-1">
                    <i class="fas fa-check-double text-[10px]"></i>
                    <span>Bidang Terdaftar di KIB A</span>
                </div>
            </div>
        </div>

        {{-- KARTU 2: TOTAL LUAS (TEAL ACCENT) --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-emerald-100/90 hover:border-emerald-300 hover:shadow-md transition-all group relative overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-teal-500 to-emerald-500 absolute top-0 inset-x-0"></div>
            
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Luas Keseluruhan</span>
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl shadow-xs group-hover:scale-105 transition-transform">
                    <i class="fas fa-vector-square"></i>
                </div>
            </div>
            
            <div class="mt-4">
                <div class="flex items-baseline gap-1.5">
                    <p class="text-3xl font-black text-slate-900 tracking-tight">
                        {{ number_format($stats['total_luas'] ?? 0, 0, ',', '.') }}
                    </p>
                    <span class="text-xs font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-100">m²</span>
                </div>
                <div class="text-xs text-slate-500 font-medium mt-1 flex items-center gap-1.5">
                    <i class="fas fa-chart-area text-[10px] text-teal-600"></i>
                    <span>Akumulasi Luas Kas Desa</span>
                </div>
            </div>
        </div>

        {{-- KARTU 3: MENUNGGU VALIDASI (AMBER ACCENT) --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-amber-100/90 hover:border-amber-300 hover:shadow-md transition-all group relative overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-amber-400 to-amber-600 absolute top-0 inset-x-0"></div>
            
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Validasi Pimpinan</span>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl shadow-xs group-hover:scale-105 transition-transform">
                    <i class="fas fa-clock-rotate-left"></i>
                </div>
            </div>
            
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-black text-amber-600 tracking-tight">
                        {{ number_format($stats['menunggu_validasi'] ?? 0) }}
                    </p>
                    <span class="text-xs text-amber-700 font-bold bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">Menunggu</span>
                </div>
                <div class="text-xs text-slate-500 font-medium mt-1 flex items-center gap-1.5">
                    <i class="fas fa-signature text-[10px] text-amber-600"></i>
                    <span>Persetujuan Kades / Lurah</span>
                </div>
            </div>
        </div>

        {{-- KARTU 4: SEWA HABIS / EARLY WARNING --}}
        @php
            $hasWarning = ($stats['early_warning_count'] ?? 0) > 0;
        @endphp
        <div class="bg-white rounded-3xl p-6 shadow-sm border-2 {{ $hasWarning ? 'border-rose-300 bg-rose-50/20' : 'border-slate-200' }} hover:shadow-md transition-all group relative overflow-hidden">
            <div class="h-1.5 {{ $hasWarning ? 'bg-gradient-to-r from-rose-500 to-red-600' : 'bg-slate-300' }} absolute top-0 inset-x-0"></div>
            
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Masa Sewa Kritis</span>
                <div class="w-12 h-12 rounded-2xl {{ $hasWarning ? 'bg-rose-100 text-rose-600 animate-pulse' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center text-xl shadow-xs group-hover:scale-105 transition-transform">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
            </div>
            
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-black {{ $hasWarning ? 'text-rose-600' : 'text-slate-900' }} tracking-tight">
                        {{ number_format($stats['early_warning_count'] ?? 0) }}
                    </p>
                    <span class="text-xs {{ $hasWarning ? 'text-rose-700 font-bold bg-rose-100' : 'text-slate-500 bg-slate-100' }} px-2 py-0.5 rounded-md">
                        &lt; 30 Hari
                    </span>
                </div>
                <div class="text-xs text-slate-500 font-medium mt-1 flex items-center gap-1.5">
                    <i class="fas fa-calendar-xmark text-[10px] {{ $hasWarning ? 'text-rose-500' : 'text-slate-400' }}"></i>
                    <span>Kontrak Sewa Habis</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ========================================== --}}
    {{-- 3. KOTAK EARLY WARNING DETAIL              --}}
    {{-- ========================================== --}}
    @if(isset($earlyWarnings) && $earlyWarnings->count() > 0)
        <div class="bg-rose-50/70 border-2 border-rose-200 rounded-3xl p-5 sm:p-6 shadow-sm animate-in fade-in">
            <h3 class="text-rose-900 font-black flex items-center gap-2 mb-4 text-sm uppercase tracking-wider">
                <i class="fas fa-bell text-rose-600 animate-pulse text-base"></i> 
                <span>Peringatan Dini: Kontrak Sewa Segera Berakhir (&lt; 30 Hari)</span>
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($earlyWarnings as $warning)
                    <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                        <div class="mb-3">
                            <p class="text-sm font-bold text-slate-900 truncate" title="{{ $warning->tanah->lokasi ?? 'Tanah Tidak Diketahui' }}">
                                {{ $warning->tanah->lokasi ?? 'Tanah Tidak Diketahui' }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                <i class="fas fa-user-tag text-emerald-600"></i>
                                <span>{{ $warning->pihak_ketiga }} ({{ $warning->bentuk_pemanfaatan }})</span>
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-lg border border-rose-200">
                                Sisa {{ \Carbon\Carbon::parse($warning->tanggal_selesai)->diffInDays() }} hari
                            </span>
                            <span class="text-[11px] font-mono font-bold text-slate-600">
                                {{ \Carbon\Carbon::parse($warning->tanggal_selesai)->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ========================================== --}}
    {{-- 4. TOOLBAR PENCARIAN & FILTER              --}}
    {{-- ========================================== --}}
    <div class="bg-white p-4 sm:p-5 rounded-3xl shadow-sm border border-emerald-100/90 flex flex-col sm:flex-row gap-4 items-center justify-between">
        
        <div class="w-full sm:max-w-md relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                <i class="fas fa-search"></i>
            </div>
            <input type="text" 
                   wire:model.live.debounce.300ms="searchTerm" 
                   class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-slate-200 bg-slate-50/70 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition text-sm text-slate-800 placeholder-slate-400 font-medium" 
                   placeholder="Cari kode barang, asal perolehan, atau lokasi...">
        </div>
        
        <div class="w-full sm:w-56 relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                <i class="fas fa-filter text-xs"></i>
            </div>
            <select wire:model.live="filterStatus" class="w-full pl-10 pr-10 py-2.5 rounded-2xl border border-slate-200 bg-slate-50/70 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 transition text-sm text-slate-800 appearance-none font-bold cursor-pointer">
                <option value="">Semua Status Validasi</option>
                <option value="Diproses">⏳ Menunggu Validasi</option>
                <option value="Disetujui">✅ Disetujui / Sah</option>
                <option value="Ditolak">❌ Ditolak / Revisi</option>
            </select>
            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fas fa-chevron-down text-xs"></i>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 5. FLASH MESSAGES                          --}}
    {{-- ========================================== --}}
    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border-2 border-emerald-300 text-emerald-900 text-sm flex items-center gap-3 shadow-xs animate-in fade-in">
            <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                <i class="fas fa-check text-sm font-bold"></i>
            </div>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif
    
    @if (session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border-2 border-rose-300 text-rose-900 text-sm flex items-center gap-3 shadow-xs animate-in fade-in">
            <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0">
                <i class="fas fa-exclamation text-sm font-bold"></i>
            </div>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
    @endif

    {{-- ========================================== --}}
    {{-- 6. TABEL DATA INVENTARIS ASET TANAH        --}}
    {{-- ========================================== --}}
    <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden flex flex-col">
        
        {{-- Header Kartu Tabel Beraksen Hijau --}}
        <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-700 to-emerald-900 text-white flex items-center justify-center font-bold shadow-xs">
                    <i class="fas fa-layer-group text-sm"></i>
                </div>
                <div>
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900">Daftar Inventaris Tanah Kas Desa</h2>
                    <p class="text-[11px] text-emerald-800 font-medium">Data KIB A resmi yang terdaftar pada sistem kalurahan</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="text-xs font-black text-emerald-800 bg-emerald-100/90 px-3 py-1 rounded-xl border border-emerald-300">
                    Total: {{ $aset_tanah->total() }} Persil
                </span>
            </div>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="min-w-full divide-y divide-slate-200 text-left">
                <thead class="bg-emerald-900/[0.03] border-b border-emerald-100">
                    <tr>
                        <th scope="col" class="px-5 py-4 text-xs font-black text-emerald-950 uppercase tracking-wider w-16 text-center">No</th>
                        <th scope="col" class="px-5 py-4 text-xs font-black text-emerald-950 uppercase tracking-wider min-w-[180px]">Kode / Nama Barang</th>
                        <th scope="col" class="px-5 py-4 text-xs font-black text-emerald-950 uppercase tracking-wider min-w-[220px]">Lokasi & Fisik</th>
                        <th scope="col" class="px-5 py-4 text-xs font-black text-emerald-950 uppercase tracking-wider">Peruntukan</th>
                        <th scope="col" class="px-5 py-4 text-xs font-black text-emerald-950 uppercase tracking-wider text-center">Status</th>
                        <th scope="col" class="px-5 py-4 text-xs font-black text-emerald-950 uppercase tracking-wider text-center sticky right-0 bg-slate-50/95 backdrop-blur-sm z-10 shadow-[-5px_0_10px_rgba(0,0,0,0.03)]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($aset_tanah as $aset)
                    <tr wire:key="aset-{{ $aset->id }}" class="hover:bg-emerald-50/30 transition-colors group">
                        
                        <td class="px-5 py-4 whitespace-nowrap text-xs text-slate-400 font-mono text-center font-bold">
                            {{ $loop->iteration + ($aset_tanah->firstItem() - 1) }}
                        </td>
                        
                        <td class="px-5 py-4">
                            <div class="text-sm font-extrabold text-slate-900 group-hover:text-emerald-700 transition-colors">
                                {{ $aset->kode_barang ?? 'Belum ada kode' }}
                            </div>
                            <div class="text-[11px] font-semibold text-slate-500 mt-1 truncate max-w-[180px]" title="{{ $aset->nama_barang }}">
                                {{ $aset->nama_barang ?? $aset->asal_perolehan }}
                            </div>
                        </td>
                        
                        <td class="px-5 py-4">
                            <div class="text-sm text-slate-700 truncate max-w-[220px] flex items-center gap-1.5 font-medium" title="{{ $aset->lokasi }}">
                                <i class="fas fa-location-dot text-emerald-600 text-xs"></i> 
                                <span>{{ $aset->lokasi }}</span>
                            </div>
                            <div class="text-xs font-mono font-bold text-slate-600 mt-1.5">
                                <span class="bg-emerald-50/80 text-emerald-800 px-2 py-0.5 rounded-lg border border-emerald-200">
                                    L: {{ number_format($aset->luas, 0, ',', '.') }} m²
                                </span>
                            </div>
                        </td>
                        
                        <td class="px-5 py-4 text-sm font-semibold text-slate-700">
                            {{ $aset->penggunaan ?? '-' }}
                        </td>
                        
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            @if($aset->status_validasi === 'Disetujui')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    <i class="fas fa-check-circle text-emerald-600"></i> Disetujui
                                </span>
                            @elseif($aset->status_validasi === 'Ditolak')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-800 border border-rose-300">
                                    <i class="fas fa-times-circle text-rose-600"></i> Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-300">
                                    <i class="fas fa-clock-rotate-left text-amber-600"></i> Diproses
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-5 py-4 whitespace-nowrap text-center sticky right-0 bg-white group-hover:bg-emerald-50/40 z-10 shadow-[-5px_0_10px_rgba(0,0,0,0.02)] transition-colors">
                            <div class="flex justify-center items-center gap-1.5">
                                
                                <a href="{{ route('aset.detail', ['aset' => $aset->id]) }}" wire:navigate 
                                   class="w-8 h-8 flex items-center justify-center rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 hover:bg-emerald-600 hover:text-white transition-all shadow-2xs" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>

                                @if(auth()->user()->role_id == 1)
                                    <a href="{{ route('aset.edit', ['aset' => $aset->id]) }}" wire:navigate 
                                       class="w-8 h-8 flex items-center justify-center rounded-xl bg-amber-50 border border-amber-200 text-amber-700 hover:bg-amber-600 hover:text-white transition-all shadow-2xs" 
                                       title="Edit Data">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    
                                    <button wire:click="arsipkan({{ $aset->id }})" 
                                            wire:confirm="Yakin ingin mengarsipkan data ini ke Tong Sampah?"
                                            class="w-8 h-8 flex items-center justify-center rounded-xl bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-600 hover:text-white transition-all shadow-2xs cursor-pointer" 
                                            title="Arsipkan">
                                        <i class="fas fa-trash-can text-xs"></i>
                                    </button>
                                @endif

                                @if(auth()->user()->role_id == 2 && $aset->status_validasi == 'Diproses')
                                    <button wire:click="openValidasiModal({{ $aset->id }}, 'Disetujui')" 
                                            class="w-8 h-8 flex items-center justify-center rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition-all shadow-2xs cursor-pointer" 
                                            title="Setujui Validasi">
                                        <i class="fas fa-check text-xs"></i>
                                    </button>
                                    
                                    <button wire:click="openValidasiModal({{ $aset->id }}, 'Ditolak')" 
                                            class="w-8 h-8 flex items-center justify-center rounded-xl bg-rose-600 text-white hover:bg-rose-700 transition-all shadow-2xs cursor-pointer" 
                                            title="Tolak Validasi">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl mb-3 border border-emerald-200">
                                    <i class="fas fa-magnifying-glass"></i>
                                </div>
                                <p class="text-base font-bold text-slate-700">Data Aset Tidak Ditemukan</p>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm">
                                    Tidak ada data tanah yang cocok dengan kata kunci pencarian atau status filter saat ini.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINASI --}}
        @if($aset_tanah->hasPages())
            <div class="p-4 bg-emerald-50/20 border-t border-emerald-100 flex items-center justify-between">
                {{ $aset_tanah->links() }}
            </div>
        @endif

    </div>

</div>