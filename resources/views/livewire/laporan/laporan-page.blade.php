<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    {{-- Header & Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Laporan & Rekapitulasi</h1>
            <p class="text-sm text-slate-500 mt-1">Filter, cari, dan unduh data aset tanah desa dalam format resmi.</p>
        </div>
        
        <div class="flex gap-3">
            {{-- Tombol PDF --}}
            <button wire:click="exportPdf" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 rounded-xl text-sm font-bold hover:bg-red-100 hover:border-red-300 transition focus:ring-2 focus:ring-red-500/20 shadow-sm">
                <i class="fas fa-file-pdf mr-2 text-lg"></i>
                <span wire:loading.remove wire:target="exportPdf">Export PDF</span>
                <span wire:loading wire:target="exportPdf">Memproses...</span>
            </button>

            {{-- Tombol CSV --}}
            <button wire:click="exportCsv" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-sm font-bold hover:bg-emerald-100 hover:border-emerald-300 transition focus:ring-2 focus:ring-emerald-500/20 shadow-sm">
                <i class="fas fa-file-csv mr-2 text-lg"></i>
                <span wire:loading.remove wire:target="exportCsv">Export CSV</span>
                <span wire:loading wire:target="exportCsv">Memproses...</span>
            </button>
        </div>
    </div>

    {{-- Notifikasi Error --}}
    @if (session()->has('error'))
        <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-xl relative flex items-center gap-2 shadow-sm">
            <i class="fas fa-exclamation-circle text-xl"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Filter Section --}}
    <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">
        <div class="flex items-center gap-2 mb-4 text-slate-800 font-bold text-sm uppercase tracking-wide">
            <i class="fas fa-filter text-blue-500"></i> Filter Data
        </div>
        
        {{-- Grid 4 Kolom yang Rapi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            
            {{-- 1. Pencarian --}}
            <div class="lg:col-span-1">
                <label class="block text-xs font-bold text-slate-500 mb-1">Pencarian</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400"></i>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="searchTerm" class="block w-full pl-10 rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5" placeholder="Cari nama/kode/lokasi...">
                </div>
            </div>

            {{-- 2. Status --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Status Validasi</label>
                <select wire:model.live="filterStatus" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5">
                    <option value="">Semua Status</option>
                    <option value="Disetujui">✅ Disetujui</option>
                    <option value="Diproses">⏳ Diproses</option>
                    <option value="Ditolak">❌ Ditolak</option>
                </select>
            </div>

            {{-- 3. Kondisi --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Kondisi Fisik</label>
                <select wire:model.live="filterKondisi" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5">
                    <option value="">Semua Kondisi</option>
                    <option value="Baik">✨ Baik</option>
                    <option value="Rusak Ringan">⚠️ Rusak Ringan</option>
                    <option value="Rusak Berat">🛑 Rusak Berat</option>
                </select>
            </div>

            {{-- 4. Tanggal Tunggal (Fixed) --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Tanggal Input</label>
                <input type="date" wire:model.live="filterDate" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 text-slate-600">
            </div>

        </div>
    </div>

    {{-- Tabel Hasil --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Hasil Laporan</h3>
            <span class="bg-white border border-slate-200 px-3 py-1 rounded-lg text-xs font-bold text-slate-600">
                Total Data: {{ $aset_tanah->total() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4">Identitas Barang</th>
                        <th class="px-6 py-4">Asal / Lokasi</th>
                        <th class="px-6 py-4 text-center">Kondisi</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Harga (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($aset_tanah as $aset)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 text-center text-slate-400 font-medium">
                                {{ ($aset_tanah->currentpage()-1) * $aset_tanah->perpage() + $loop->index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $aset->nama_barang ?? 'Tanah Desa' }}</div>
                                <div class="font-mono text-xs text-slate-500 mt-1">{{ $aset->kode_barang ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-slate-500 mb-1">{{ $aset->asal_perolehan }}</div>
                                <div class="truncate max-w-xs text-slate-700" title="{{ $aset->lokasi }}">
                                    {{ Str::limit($aset->lokasi, 35) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $kondisiColor = match($aset->kondisi) {
                                        'Baik' => 'text-emerald-600 bg-emerald-50 ring-emerald-500/20',
                                        'Rusak Ringan' => 'text-amber-600 bg-amber-50 ring-amber-500/20',
                                        'Rusak Berat' => 'text-red-600 bg-red-50 ring-red-500/20',
                                        default => 'text-slate-600 bg-slate-50 ring-slate-500/20',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $kondisiColor }}">
                                    {{ $aset->kondisi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusColor = match($aset->status_validasi) {
                                        'Disetujui' => 'bg-blue-100 text-blue-700',
                                        'Ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $statusColor }} uppercase">
                                    {{ $aset->status_validasi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-slate-600">
                                {{ number_format($aset->harga_perolehan, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-slate-50 rounded-full p-4 mb-3">
                                        <i class="fas fa-search text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="text-base font-medium text-slate-600">Data tidak ditemukan</p>
                                    <p class="text-sm">Coba ubah filter atau kata kunci pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $aset_tanah->links() }}
        </div>
    </div>
</div>