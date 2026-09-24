<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    
    {{-- ========================================== --}}
    {{-- 1. HERO BANNER AUDIT LOG AKTIVITAS         --}}
    {{-- ========================================== --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 p-6 sm:p-7 text-white shadow-xl shadow-emerald-950/15 border border-emerald-700/50">
        <div class="absolute -right-8 -top-8 w-64 h-64 rounded-full bg-emerald-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-10 w-48 h-48 rounded-full bg-teal-300/15 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/15 text-emerald-200 backdrop-blur-md border border-white/20">
                    <i class="fas fa-clock-rotate-left text-emerald-300"></i>
                    <span>Sistem Audit & Akuntabilitas Digital</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Audit Log Aktivitas Pengguna
                </h1>
                <p class="text-sm text-emerald-100/90 font-medium max-w-2xl leading-relaxed">
                    Rekam jejak forensik seluruh perubahan data, aksi penambahan, validasi Kades, hingga pemulihan berkas persil tanah.
                </p>
            </div>
            
            <div class="shrink-0 flex items-center">
                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-700/60 border border-emerald-500/40 text-emerald-100 text-xs font-bold shadow-xs">
                    <i class="fas fa-shield-halved text-emerald-300"></i>
                    <span class="font-mono">{{ now()->format('d M Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. TOOLBAR FILTER AUDIT LOG                --}}
    {{-- ========================================== --}}
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-emerald-100/90">
        <div class="flex flex-col lg:flex-row gap-4">
            
            {{-- Search Input --}}
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                    <i class="fas fa-search text-xs"></i>
                </div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition font-medium" 
                       placeholder="Cari nama pegawai, aksi, atau rincian deskripsi...">
            </div>

            {{-- Filter Group --}}
            <div class="flex flex-col sm:flex-row gap-3 lg:w-auto">
                {{-- Filter Aksi --}}
                <div class="sm:w-52">
                    <select wire:model.live="filterAksi" class="block w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition font-bold text-slate-800 cursor-pointer">
                        <option value="">Semua Jenis Aksi</option>
                        <option value="TAMBAH">➕ TAMBAH DATA</option>
                        <option value="EDIT">✏️ EDIT DATA</option>
                        <option value="VALIDASI">🛡️ VALIDASI</option>
                        <option value="ARSIP">📦 ARSIPKAN</option>
                        <option value="HAPUS PERMANEN">🗑️ HAPUS PERMANEN</option>
                        <option value="PULIHKAN">♻️ PULIHKAN</option>
                    </select>
                </div>

                {{-- Filter Tanggal --}}
                <div class="sm:w-44">
                    <input type="date" 
                           wire:model.live="filterDate" 
                           class="block w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition font-semibold text-slate-700 cursor-pointer">
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 3. TABEL AUDIT LOG AKTIVITAS               --}}
    {{-- ========================================== --}}
    <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-emerald-900/[0.03] border-b border-emerald-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-emerald-950 uppercase tracking-wider">Waktu Kejadian</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-emerald-950 uppercase tracking-wider">Pegawai / Pelaku</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-black text-emerald-950 uppercase tracking-wider">Aksi</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-emerald-950 uppercase tracking-wider">Deskripsi Perubahan</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-black text-emerald-950 uppercase tracking-wider">Rincian</th>
                    </tr>
                </thead>
                
                @forelse($logs as $log)
                    <tbody wire:key="log-{{ $log->id }}" x-data="{ expanded: false }" class="bg-white border-b border-slate-100 last:border-b-0 hover:bg-emerald-50/20 transition-colors">
                        <tr class="cursor-pointer" @click="expanded = !expanded">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-800">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-xs font-mono font-bold text-emerald-700">{{ $log->created_at->format('H:i:s') }} WIB</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-9 w-9 rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-800 text-white flex items-center justify-center text-xs font-black mr-3 shadow-xs">
                                        {{ substr($log->user->nama_lengkap ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">{{ $log->user->nama_lengkap ?? 'Sistem / Tamu' }}</div>
                                        <div class="text-[11px] text-emerald-800 font-semibold">{{ $log->user->role->nama_role ?? 'Sistem' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $badgeColor = match($log->aksi) {
                                        'TAMBAH'         => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'EDIT'           => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'VALIDASI'       => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'ARSIP'          => 'bg-orange-100 text-orange-800 border-orange-200',
                                        'HAPUS PERMANEN' => 'bg-rose-100 text-rose-800 border-rose-200',
                                        'PULIHKAN'       => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                        'DISETUJUI'      => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                        'DITOLAK'        => 'bg-rose-100 text-rose-800 border-rose-200',
                                        default          => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black border {{ $badgeColor }} uppercase tracking-wider">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700 max-w-md truncate font-medium">
                                {{ $log->deskripsi }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-emerald-100 text-slate-500 hover:text-emerald-700 transition-all duration-200 flex items-center justify-center mx-auto" :class="expanded ? 'rotate-180 bg-emerald-100 text-emerald-800' : ''">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Baris Detail Perubahan (Accordion) --}}
                        <tr x-show="expanded" x-collapse style="display: none;">
                            <td colspan="5" class="bg-emerald-50/20 px-6 py-4 border-t border-emerald-100">
                                <div class="bg-white border-2 border-emerald-100 rounded-2xl p-5 shadow-xs">
                                    <h4 class="text-xs font-black text-emerald-950 uppercase mb-4 flex items-center gap-2">
                                        <i class="fas fa-code-compare text-emerald-600"></i> Rincian Perubahan Data Nilai
                                    </h4>

                                    @php
                                        $props = $log->properties ?? [];
                                        $old = $props['old'] ?? [];
                                        $new = $props['new'] ?? [];
                                        $attributes = $props['attributes'] ?? [];
                                        
                                        $ignored = ['created_at', 'updated_at', 'deleted_at', 'id'];
                                        $new = array_diff_key($new, array_flip($ignored));
                                    @endphp

                                    @if(!empty($old) || !empty($new))
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                                            @if(!empty($old))
                                            <div>
                                                <span class="inline-block px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 text-[10px] font-black mb-3 border border-rose-200">DATA SEBELUMNYA</span>
                                                <ul class="space-y-2">
                                                    @foreach($old as $key => $val)
                                                        <li class="flex justify-between border-b border-slate-100 pb-1 border-dashed">
                                                            <span class="text-slate-500 capitalize text-xs">{{ str_replace('_', ' ', $key) }}</span>
                                                            <span class="font-mono text-slate-700 text-right text-xs font-semibold">{{ is_array($val) ? json_encode($val) : $val }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif

                                            @if(!empty($new))
                                            <div>
                                                <span class="inline-block px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-[10px] font-black mb-3 border border-emerald-300">DATA SESUDAHNYA</span>
                                                <ul class="space-y-2">
                                                    @foreach($new as $key => $val)
                                                        <li class="flex justify-between border-b border-slate-100 pb-1 border-dashed">
                                                            <span class="text-slate-500 capitalize text-xs">{{ str_replace('_', ' ', $key) }}</span>
                                                            <span class="font-mono text-emerald-950 font-black text-right text-xs">{{ is_array($val) ? json_encode($val) : $val }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                        </div>

                                    @elseif(!empty($attributes))
                                        <div>
                                            <span class="inline-block px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-[10px] font-black mb-3 border border-emerald-300">DATA TERCATAT BARU</span>
                                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                                @foreach($attributes as $key => $val)
                                                    @if(!in_array($key, $ignored))
                                                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                                                        <div class="text-[10px] text-slate-400 uppercase font-black mb-0.5">{{ str_replace('_', ' ', $key) }}</div>
                                                        <div class="text-xs font-bold text-slate-800 truncate" title="{{ $val }}">{{ $val }}</div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                    @else
                                        <div class="text-center py-4">
                                            <p class="text-slate-400 italic text-sm">Tidak ada rincian data teknis tambahan.</p>
                                        </div>
                                    @endif

                                    {{-- Metadata Teknis --}}
                                    <div class="mt-5 pt-3 border-t border-slate-100 flex flex-wrap gap-4 text-[11px] text-slate-500 font-medium">
                                        <div class="flex items-center gap-1.5 bg-slate-100/80 px-2.5 py-1 rounded-lg"><i class="fas fa-network-wired text-emerald-600"></i> IP: {{ $log->ip_address ?? '-' }}</div>
                                        <div class="flex items-center gap-1.5 bg-slate-100/80 px-2.5 py-1 rounded-lg"><i class="fas fa-desktop text-emerald-600"></i> {{ Str::limit($log->user_agent, 60) }}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                @empty
                    <tbody>
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl mb-3 border border-emerald-200">
                                        <i class="fas fa-magnifying-glass"></i>
                                    </div>
                                    <p class="text-base font-bold text-slate-700">Tidak ada rekaman log ditemukan</p>
                                    <p class="text-xs text-slate-500 mt-1">Coba sesuaikan kata kunci pencarian atau tanggal audit Anda.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                @endforelse
            </table>
        </div>
        
        <div class="p-4 bg-emerald-50/20 border-t border-emerald-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>