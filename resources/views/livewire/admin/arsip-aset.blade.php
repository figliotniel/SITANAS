<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    {{-- ========================================== --}}
    {{-- 1. HERO BANNER ARSIP SAMPAH                --}}
    {{-- ========================================== --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 p-6 sm:p-7 text-white shadow-xl shadow-emerald-950/15 border border-emerald-700/50">
        <div class="absolute -right-8 -top-8 w-64 h-64 rounded-full bg-emerald-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-10 w-48 h-48 rounded-full bg-teal-300/15 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/15 text-emerald-200 backdrop-blur-md border border-white/20">
                    <i class="fas fa-box-archive text-emerald-300"></i>
                    <span>Perlindungan & Pemulihan Data</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Arsip Sampah (Recycle Bin)
                </h1>
                <p class="text-sm text-emerald-100/90 font-medium max-w-2xl leading-relaxed">
                    Data tanah yang dihapus sementara diamankan di sini. Anda dapat memulihkan (restore) data kembali ke sistem aktif atau menghapusnya secara permanen.
                </p>
            </div>
            
            <div class="shrink-0 flex items-center">
                <div class="bg-amber-400/20 border border-amber-300/40 rounded-2xl px-4 py-2.5 text-amber-200 text-xs font-bold flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation text-amber-300 text-sm"></i>
                    <span>Penghapusan permanen tidak dapat dibatalkan.</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="p-4 sm:p-5 bg-emerald-50 border-2 border-emerald-300 text-emerald-900 rounded-2xl flex items-center gap-3 shadow-xs animate-in fade-in">
            <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                <i class="fas fa-check text-sm font-bold"></i>
            </div>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if (session('error'))
        <div class="p-4 sm:p-5 bg-rose-50 border-2 border-rose-300 text-rose-900 rounded-2xl flex items-center gap-3 shadow-xs animate-in fade-in">
            <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0">
                <i class="fas fa-circle-exclamation text-sm font-bold"></i>
            </div>
            <span class="font-bold text-sm">{{ session('error') }}</span>
        </div>
    @endif

    {{-- ========================================== --}}
    {{-- 2. TABEL DATA TERHAPUS                     --}}
    {{-- ========================================== --}}
    <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden flex flex-col">
        <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-700 to-emerald-900 text-white flex items-center justify-center font-bold shadow-xs">
                    <i class="fas fa-trash-can text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Data Dalam Kotak Sampah</h3>
                    <p class="text-[11px] text-emerald-800 font-medium">Persil tanah yang berstatus soft-deleted</p>
                </div>
            </div>
            <span class="bg-emerald-100/90 text-emerald-800 border border-emerald-300 px-3 py-1 rounded-xl text-xs font-black">
                Total: {{ $asetArsip->total() }} Persil
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-emerald-900/[0.03] border-b border-emerald-100 text-xs uppercase font-black text-emerald-950">
                    <tr>
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4">Identitas Aset</th>
                        <th class="px-6 py-4">Lokasi & Luas</th>
                        <th class="px-6 py-4">Waktu Dihapus</th>
                        <th class="px-6 py-4 text-center">Aksi Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($asetArsip as $aset)
                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                            <td class="px-6 py-4 text-center text-slate-400 font-mono font-bold">
                                {{ $loop->iteration + ($asetArsip->firstItem() - 1) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-extrabold text-slate-900">{{ $aset->kode_barang ?? 'Tanpa Kode' }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 font-medium">{{ $aset->asal_perolehan }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-location-dot text-emerald-600 mt-1 text-xs"></i>
                                    <div>
                                        <div class="font-bold text-slate-800 max-w-xs truncate" title="{{ $aset->lokasi }}">
                                            {{ Str::limit($aset->lokasi, 40) }}
                                        </div>
                                        <div class="text-xs font-mono font-bold text-emerald-700 mt-0.5">
                                            Luas: {{ number_format($aset->luas, 0, ',', '.') }} m²
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center px-3 py-1 rounded-xl bg-rose-50 text-rose-700 text-xs font-bold border border-rose-200">
                                    <i class="far fa-clock mr-1.5"></i>
                                    {{ $aset->deleted_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <button 
                                        wire:click="pulihkan({{ $aset->id }})" 
                                        wire:confirm="Anda yakin ingin memulihkan (Restore) data aset ini kembali ke database aktif?"
                                        class="inline-flex items-center px-3.5 py-1.5 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-xl text-xs font-black hover:bg-emerald-600 hover:text-white transition shadow-2xs cursor-pointer"
                                        title="Pulihkan Data">
                                        <i class="fas fa-undo-alt mr-1.5"></i> Pulihkan
                                    </button>

                                    @if($aset->status_validasi !== 'Disetujui')
                                        <button 
                                            wire:click="hapusPermanen({{ $aset->id }})" 
                                            wire:confirm="PERINGATAN FATAL: Data ini akan dihapus SELAMANYA dan tidak bisa dikembalikan lagi. Anda yakin?"
                                            class="inline-flex items-center px-3 py-1.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-black hover:bg-rose-600 hover:text-white transition shadow-2xs cursor-pointer"
                                            title="Hapus Permanen">
                                            <i class="fas fa-trash mr-1.5"></i> Hapus Permanen
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-3 border border-emerald-200">
                                        <i class="fas fa-trash-can-arrow-up"></i>
                                    </div>
                                    <p class="text-base font-extrabold text-slate-800">Kotak Sampah Kosong</p>
                                    <p class="text-xs text-slate-500 mt-1">Tidak ada data persil tanah yang sedang dihapus. Seluruh data aman.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($asetArsip->hasPages())
            <div class="p-4 bg-emerald-50/20 border-t border-emerald-100">
                {{ $asetArsip->links() }}
            </div>
        @endif
    </div>
</div>