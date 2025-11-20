<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Arsip Sampah (Recycle Bin)</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data yang telah dihapus. Data di sini dapat dipulihkan atau dihapus permanen.</p>
        </div>
        <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-2 text-amber-800 text-sm font-medium flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Hati-hati saat menghapus permanen.
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center shadow-sm animate-in fade-in slide-in-from-top-2">
            <i class="fas fa-check-circle mr-3 text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Data Terhapus</h3>
            <span class="bg-white border border-slate-200 px-3 py-1 rounded-lg text-xs font-bold text-slate-600">
                Total: {{ $asetArsip->total() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4">Identitas Aset</th>
                        <th class="px-6 py-4">Lokasi & Luas</th>
                        <th class="px-6 py-4">Waktu Dihapus</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($asetArsip as $aset)
                        <tr class="hover:bg-slate-50 transition duration-150 group">
                            <td class="px-6 py-4 text-center text-slate-400 font-medium">
                                {{ $loop->iteration + ($asetArsip->firstItem() - 1) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $aset->kode_barang ?? 'Tanpa Kode' }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $aset->asal_perolehan }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-map-marker-alt text-slate-400 mt-1"></i>
                                    <div>
                                        <div class="font-medium text-slate-800 max-w-xs truncate" title="{{ $aset->lokasi }}">
                                            {{ Str::limit($aset->lokasi, 40) }}
                                        </div>
                                        <div class="text-xs font-mono text-slate-500">
                                            Luas: {{ number_format($aset->luas, 2, ',', '.') }} m²
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center px-2.5 py-0.5 rounded bg-red-50 text-red-700 text-xs font-medium border border-red-100">
                                    <i class="far fa-clock mr-1.5"></i>
                                    {{ $aset->deleted_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-3 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <button 
                                        wire:click="pulihkan({{ $aset->id }})" 
                                        wire:confirm="Anda yakin ingin memulihkan (Restore) data aset ini kembali ke database aktif?"
                                        class="inline-flex items-center px-3 py-2 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold hover:bg-emerald-200 transition shadow-sm"
                                        title="Pulihkan Data">
                                        <i class="fas fa-undo-alt mr-2"></i> Pulihkan
                                    </button>

                                    <button 
                                        wire:click="hapusPermanen({{ $aset->id }})" 
                                        wire:confirm="PERINGATAN FATAL: Data ini akan dihapus SELAMANYA dan tidak bisa dikembalikan lagi. Anda yakin?"
                                        class="inline-flex items-center px-3 py-2 bg-white border border-red-200 text-red-600 rounded-lg text-xs font-bold hover:bg-red-50 hover:border-red-300 transition shadow-sm"
                                        title="Hapus Permanen">
                                        <i class="fas fa-trash mr-2"></i> Hapus Permanen
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-emerald-50 rounded-full p-4 mb-3">
                                        <i class="fas fa-trash-restore text-2xl text-emerald-300"></i>
                                    </div>
                                    <p class="text-base font-medium text-slate-600">Arsip Kosong</p>
                                    <p class="text-sm">Tidak ada data sampah saat ini. Semua data aman.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $asetArsip->links() }}
        </div>
    </div>
</div>