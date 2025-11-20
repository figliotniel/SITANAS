<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Laporan & Rekapitulasi</h1>
            <p class="text-sm text-slate-500 mt-1">Filter, cari, dan unduh data aset tanah desa dalam format resmi.</p>
        </div>
        
        <div class="flex gap-3">
            <button wire:click="exportPdf" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 rounded-xl text-sm font-bold hover:bg-red-100 hover:border-red-300 transition focus:ring-2 focus:ring-red-500/20">
                <i class="fas fa-file-pdf mr-2 text-lg"></i>
                <span wire:loading.remove wire:target="exportPdf">Export PDF</span>
                <span wire:loading wire:target="exportPdf">Memproses...</span>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6">
        <div class="flex items-center gap-2 mb-4 text-slate-800 font-bold text-sm uppercase tracking-wide">
            <i class="fas fa-filter text-blue-500"></i> Filter Data
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <div class="lg:col-span-1">
                <label class="block text-xs font-bold text-slate-500 mb-1">Pencarian</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400"></i>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" class="block w-full pl-10 rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5" placeholder="Cari lokasi/kode...">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Status Validasi</label>
                <select wire:model.live="filterStatus" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5">
                    <option value="">Semua Status</option>
                    <option value="Disetujui">✅ Disetujui</option>
                    <option value="Diproses">⏳ Diproses</option>
                    <option value="Ditolak">❌ Ditolak</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Kondisi Fisik</label>
                <select wire:model.live="filterKondisi" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5">
                    <option value="">Semua Kondisi</option>
                    <option value="Baik">✨ Baik</option>
                    <option value="Kurang Baik">⚠️ Kurang Baik</option>
                    <option value="Rusak Berat">🛑 Rusak Berat</option>
                </select>
            </div>

            <div class="flex gap-2">
                <div class="w-1/2">
                    <label class="block text-xs font-bold text-slate-500 mb-1">Dari Tanggal</label>
                    <input type="date" wire:model.live="dateStart" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-xs py-2.5">
                </div>
                <div class="w-1/2">
                    <label class="block text-xs font-bold text-slate-500 mb-1">Sampai Tanggal</label>
                    <input type="date" wire:model.live="dateEnd" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-xs py-2.5">
                </div>
            </div>

        </div>
    </div>

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
                        <th class="px-6 py-4">Kode Barang</th>
                        <th class="px-6 py-4">Asal Perolehan</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4 text-center">Kondisi</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Tanggal Input</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($aset_tanah as $aset)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 text-center text-slate-400 font-medium">
                                {{ ($aset_tanah->currentpage()-1) * $aset_tanah->perpage() + $loop->index + 1 }}
                            </td>
                            <td class="px-6 py-4 font-mono font-medium text-slate-700">
                                {{ $aset->kode_barang ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $aset->asal_perolehan }}
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate" title="{{ $aset->lokasi }}">
                                {{ Str::limit($aset->lokasi, 40) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $kondisiColor = match($aset->kondisi) {
                                        'Baik' => 'text-emerald-600 bg-emerald-50 ring-emerald-500/20',
                                        'Kurang Baik' => 'text-amber-600 bg-amber-50 ring-amber-500/20',
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $statusColor }}">
                                    {{ $aset->status_validasi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ date('d M Y', strtotime($aset->created_at)) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center text-slate-400">
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