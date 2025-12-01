<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Audit Log Aktivitas</h1>
            <p class="text-sm text-slate-500 mt-1">Rekam jejak digital perubahan data dan aktivitas pengguna.</p>
        </div>
        <div class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-600 shadow-sm">
            <i class="fas fa-clock mr-2 text-blue-500"></i>
            <span class="font-mono">{{ now()->format('d M Y H:i') }}</span>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <div class="flex flex-col lg:flex-row gap-4">
            
            {{-- Search Input --}}
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400"></i>
                </div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow" 
                       placeholder="Cari nama user atau deskripsi aktivitas...">
            </div>

            {{-- Filter Group --}}
            <div class="flex flex-col sm:flex-row gap-2 lg:w-auto">
                {{-- Filter Aksi --}}
                <div class="sm:w-48">
                    <select wire:model.live="filterAksi" class="block w-full py-2 pl-3 pr-8 border border-slate-300 bg-white rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer">
                        <option value="">Semua Jenis Aksi</option>
                        <option value="TAMBAH">TAMBAH DATA</option>
                        <option value="EDIT">EDIT DATA</option>
                        <option value="VALIDASI">VALIDASI</option>
                        <option value="ARSIP">ARSIPKAN</option>
                        <option value="HAPUS PERMANEN">HAPUS PERMANEN</option>
                        <option value="PULIHKAN">PULIHKAN</option>
                    </select>
                </div>

                {{-- Filter Tanggal (Tunggal) --}}
                <div class="sm:w-40">
                    <input type="date" 
                           wire:model.live="filterDate" 
                           class="block w-full py-2 px-3 border border-slate-300 bg-white rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-slate-600 cursor-pointer"
                           placeholder="Pilih Tanggal">
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Log --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Detail</th>
                    </tr>
                </thead>
                
                @forelse($logs as $log)
                    {{-- FIXED: Ditambahkan wire:key untuk mencegah duplikasi render --}}
                    <tbody wire:key="log-{{ $log->id }}" x-data="{ expanded: false }" class="bg-white border-b border-slate-100 last:border-b-0 hover:bg-slate-50 transition-colors">
                        {{-- Baris Utama --}}
                        <tr class="cursor-pointer" @click="expanded = !expanded">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-700">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-xs font-mono text-slate-500">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-xs font-bold mr-3 shadow-sm">
                                        {{ substr($log->user->nama_lengkap ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900">{{ $log->user->nama_lengkap ?? 'Sistem / Tamu' }}</div>
                                        <div class="text-xs text-slate-500">{{ $log->user->role->nama_role ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $badgeColor = match($log->aksi) {
                                        'TAMBAH'         => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'EDIT'           => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'VALIDASI'       => 'bg-purple-100 text-purple-700 border-purple-200',
                                        'ARSIP'          => 'bg-orange-100 text-orange-700 border-orange-200',
                                        'HAPUS PERMANEN' => 'bg-red-100 text-red-700 border-red-200',
                                        'PULIHKAN'       => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'DISETUJUI'      => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'DITOLAK'        => 'bg-red-100 text-red-700 border-red-200',
                                        default          => 'bg-slate-100 text-slate-600 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeColor }} uppercase tracking-wide">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 max-w-md truncate">
                                {{ $log->deskripsi }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button class="p-1 text-slate-400 hover:text-blue-600 transition-transform duration-200" :class="expanded ? 'rotate-180 text-blue-600' : ''">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Baris Detail (Hidden by default) --}}
                        <tr x-show="expanded" x-collapse style="display: none;">
                            <td colspan="5" class="bg-slate-50/50 px-6 py-4 border-t border-slate-100">
                                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                                    <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 flex items-center gap-2">
                                        <i class="fas fa-exchange-alt"></i> Rincian Perubahan Data
                                    </h4>

                                    @php
                                        $props = $log->properties ?? [];
                                        $old = $props['old'] ?? [];
                                        $new = $props['new'] ?? []; // Hanya ambil 'new', JANGAN ambil 'attributes'
                                        $attributes = $props['attributes'] ?? []; // Ambil 'attributes' terpisah
                                        
                                        // Bersihkan kolom sistem
                                        $ignored = ['created_at', 'updated_at', 'deleted_at', 'id'];
                                        $new = array_diff_key($new, array_flip($ignored));
                                    @endphp

                                    @if(!empty($old) || !empty($new))
                                        {{-- TAMPILAN UNTUK EDIT / UPDATE (Kiri-Kanan) --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                                            @if(!empty($old))
                                            <div>
                                                <span class="inline-block px-2 py-1 rounded-md bg-red-50 text-red-600 text-[10px] font-bold mb-3 border border-red-100">SEBELUM</span>
                                                <ul class="space-y-2">
                                                    @foreach($old as $key => $val)
                                                        <li class="flex justify-between border-b border-slate-50 pb-1 border-dashed">
                                                            <span class="text-slate-500 capitalize text-xs">{{ str_replace('_', ' ', $key) }}</span>
                                                            <span class="font-mono text-slate-600 text-right text-xs">{{ is_array($val) ? json_encode($val) : $val }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif

                                            @if(!empty($new))
                                            <div>
                                                <span class="inline-block px-2 py-1 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold mb-3 border border-emerald-100">SESUDAH</span>
                                                <ul class="space-y-2">
                                                    @foreach($new as $key => $val)
                                                        <li class="flex justify-between border-b border-slate-50 pb-1 border-dashed">
                                                            <span class="text-slate-500 capitalize text-xs">{{ str_replace('_', ' ', $key) }}</span>
                                                            <span class="font-mono text-slate-900 font-bold text-right text-xs">{{ is_array($val) ? json_encode($val) : $val }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                        </div>

                                    @elseif(!empty($attributes))
                                        {{-- TAMPILAN UNTUK TAMBAH DATA (Grid Card) --}}
                                        <div>
                                            <span class="inline-block px-2 py-1 rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold mb-3 border border-blue-100">DATA BARU</span>
                                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                                @foreach($attributes as $key => $val)
                                                    @if(!in_array($key, $ignored))
                                                    <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                                        <div class="text-[10px] text-slate-400 uppercase font-bold mb-1">{{ str_replace('_', ' ', $key) }}</div>
                                                        <div class="text-xs font-medium text-slate-800 truncate" title="{{ $val }}">{{ $val }}</div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                    @else
                                        {{-- JIKA TIDAK ADA RINCIAN --}}
                                        <div class="text-center py-4">
                                            <p class="text-slate-400 italic text-sm">Tidak ada rincian data teknis.</p>
                                        </div>
                                    @endif

                                    {{-- Metadata Tambahan --}}
                                    <div class="mt-6 pt-4 border-t border-slate-100 flex flex-wrap gap-4 text-[10px] text-slate-400">
                                        <div class="flex items-center gap-2 bg-slate-50 px-2 py-1 rounded"><i class="fas fa-globe"></i> IP: {{ $log->ip_address ?? '-' }}</div>
                                        <div class="flex items-center gap-2 bg-slate-50 px-2 py-1 rounded"><i class="fas fa-desktop"></i> {{ Str::limit($log->user_agent, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                @empty
                    <tbody>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-search text-2xl text-slate-300"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-slate-900">Tidak ada aktivitas ditemukan</h3>
                                    <p class="text-slate-500 text-sm mt-1">Coba ubah kata kunci pencarian atau filter Anda.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                @endforelse
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $logs->links() }}
        </div>
    </div>
</div>