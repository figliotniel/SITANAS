<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    {{-- ========================================== --}}
    {{-- 1. HERO BANNER LAPORAN & AKSI EKSPOR       --}}
    {{-- ========================================== --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 p-6 sm:p-7 text-white shadow-xl shadow-emerald-950/15 border border-emerald-700/50">
        <div class="absolute -right-8 -top-8 w-64 h-64 rounded-full bg-emerald-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-10 w-48 h-48 rounded-full bg-teal-300/15 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/15 text-emerald-200 backdrop-blur-md border border-white/20">
                    <i class="fas fa-file-invoice text-emerald-300"></i>
                    <span>Modul Rekapitulasi & Pelaporan Resmi</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Laporan & Rekapitulasi KIB A
                </h1>
                <p class="text-sm text-emerald-100/90 font-medium max-w-2xl leading-relaxed">
                    Saring, rekapitulasi, dan ekspor seluruh inventaris tanah kas desa ke dalam dokumen cetak resmi PDF (standar kedinasan) atau berkas CSV.
                </p>
            </div>
            
            <div class="shrink-0 flex items-center gap-3">
                {{-- Tombol PDF --}}
                <button wire:click="exportPdf" wire:loading.attr="disabled" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl font-black text-sm text-rose-950 bg-rose-200 hover:bg-rose-100 shadow-lg shadow-emerald-950/30 transition-all active:scale-95 disabled:opacity-60 cursor-pointer">
                    <i class="fas fa-file-pdf text-rose-800 text-base"></i>
                    <span wire:loading.remove wire:target="exportPdf">Export PDF KIB A</span>
                    <span wire:loading wire:target="exportPdf">Memproses PDF...</span>
                </button>

                {{-- Tombol CSV --}}
                <button wire:click="exportCsv" wire:loading.attr="disabled" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl font-black text-sm text-emerald-950 bg-emerald-300 hover:bg-emerald-200 shadow-lg shadow-emerald-950/30 transition-all active:scale-95 disabled:opacity-60 cursor-pointer">
                    <i class="fas fa-file-csv text-emerald-900 text-base"></i>
                    <span wire:loading.remove wire:target="exportCsv">Export CSV</span>
                    <span wire:loading wire:target="exportCsv">Memproses CSV...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Notifikasi Error --}}
    @if (session()->has('error'))
        <div class="bg-rose-50 border-2 border-rose-300 text-rose-900 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-xs animate-in fade-in">
            <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0">
                <i class="fas fa-exclamation-circle text-sm font-bold"></i>
            </div>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
    @endif

    {{-- ========================================== --}}
    {{-- 2. FILTER DATA DENGAN AKSEN HIJAU          --}}
    {{-- ========================================== --}}
    <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 p-6 space-y-4">
        <div class="flex items-center gap-2 text-emerald-950 font-black text-xs uppercase tracking-wider">
            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center">
                <i class="fas fa-filter text-xs"></i>
            </div>
            <span>Parameter Filter Data Laporan</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- 1. Pencarian --}}
            <div class="lg:col-span-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pencarian Kata Kunci</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                        <i class="fas fa-search text-xs"></i>
                    </div>
                    <input type="text" 
                           wire:model.live.debounce.300ms="searchTerm" 
                           class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition font-medium" 
                           placeholder="Nama barang / kode / lokasi...">
                </div>
            </div>

            {{-- 2. Status --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Validasi</label>
                <select wire:model.live="filterStatus" class="block w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition font-bold text-slate-800 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="Disetujui">✅ Disetujui / Sah</option>
                    <option value="Diproses">⏳ Diproses / Menunggu</option>
                    <option value="Ditolak">❌ Ditolak / Revisi</option>
                </select>
            </div>

            {{-- 3. Kondisi --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kondisi Fisik</label>
                <select wire:model.live="filterKondisi" class="block w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition font-bold text-slate-800 cursor-pointer">
                    <option value="">Semua Kondisi</option>
                    <option value="Baik">✨ Baik</option>
                    <option value="Rusak Ringan">⚠️ Rusak Ringan</option>
                    <option value="Rusak Berat">🛑 Rusak Berat</option>
                </select>
            </div>

            {{-- 4. Tanggal --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Input</label>
                <input type="date" wire:model.live="filterDate" class="block w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition font-semibold text-slate-700 cursor-pointer">
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 3. TABEL HASIL LAPORAN BERAKSEN            --}}
    {{-- ========================================== --}}
    <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden flex flex-col">
        <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-700 to-emerald-900 text-white flex items-center justify-center font-bold shadow-xs">
                    <i class="fas fa-table-list text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Hasil Rekapitulasi Laporan</h3>
                    <p class="text-[11px] text-emerald-800 font-medium">Data inventaris tanah kas berdasarkan filter aktif</p>
                </div>
            </div>
            <span class="bg-emerald-100/90 text-emerald-800 border border-emerald-300 px-3 py-1 rounded-xl text-xs font-black">
                Total: {{ $aset_tanah->total() }} Persil
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-emerald-900/[0.03] border-b border-emerald-100 text-xs uppercase font-black text-emerald-950">
                    <tr>
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4">Identitas Barang</th>
                        <th class="px-6 py-4">Asal / Lokasi</th>
                        <th class="px-6 py-4 text-center">Kondisi</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Nilai / Harga (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($aset_tanah as $aset)
                        <tr class="hover:bg-emerald-50/30 transition-colors">
                            <td class="px-6 py-4 text-center text-slate-400 font-mono font-bold">
                                {{ ($aset_tanah->currentpage()-1) * $aset_tanah->perpage() + $loop->index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('aset.detail', ['aset' => $aset->id]) }}" wire:navigate class="font-extrabold text-slate-900 hover:text-emerald-700 transition-colors">
                                    {{ $aset->nama_barang ?? 'Tanah Kas Desa' }}
                                </a>
                                <div class="font-mono text-xs text-emerald-700 font-bold mt-0.5">{{ $aset->kode_barang ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-slate-500 mb-1 font-medium">{{ $aset->asal_perolehan }}</div>
                                <div class="truncate max-w-xs text-slate-800 font-medium flex items-center gap-1.5" title="{{ $aset->lokasi }}">
                                    <i class="fas fa-location-dot text-emerald-600 text-[10px]"></i>
                                    <span>{{ Str::limit($aset->lokasi, 35) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $kondisiColor = match($aset->kondisi) {
                                        'Baik' => 'text-emerald-800 bg-emerald-100 border border-emerald-300',
                                        'Rusak Ringan' => 'text-amber-800 bg-amber-100 border border-amber-300',
                                        'Rusak Berat' => 'text-rose-800 bg-rose-100 border border-rose-300',
                                        default => 'text-slate-700 bg-slate-100 border border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-xl px-2.5 py-1 text-xs font-bold {{ $kondisiColor }}">
                                    {{ $aset->kondisi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
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
                            <td class="px-6 py-4 text-right font-mono font-bold text-slate-800">
                                {{ number_format($aset->harga_perolehan, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl mb-3 border border-emerald-200">
                                        <i class="fas fa-magnifying-glass"></i>
                                    </div>
                                    <p class="text-base font-bold text-slate-700">Data Tidak Ditemukan</p>
                                    <p class="text-xs text-slate-500 mt-1">Coba sesuaikan kata kunci pencarian atau tanggal filter Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($aset_tanah->hasPages())
            <div class="p-4 bg-emerald-50/20 border-t border-emerald-100">
                {{ $aset_tanah->links() }}
            </div>
        @endif
    </div>
</div>