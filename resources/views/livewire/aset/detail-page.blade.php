<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    {{-- Notifikasi Sukses / Error --}}
    @if (session()->has('success'))
        <div class="bg-emerald-50 border-2 border-emerald-300 text-emerald-900 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-xs animate-in fade-in">
            <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                <i class="fas fa-check text-sm font-bold"></i>
            </div>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-rose-50 border-2 border-rose-300 text-rose-900 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-xs animate-in fade-in">
            <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0">
                <i class="fas fa-exclamation-triangle text-sm font-bold"></i>
            </div>
            <span class="font-bold text-sm">{{ session('error') }}</span>
        </div>
    @endif

    {{-- ========================================== --}}
    {{-- 1. HERO BANNER PERSIL TANAH KAS            --}}
    {{-- ========================================== --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 p-6 sm:p-8 text-white shadow-xl shadow-emerald-950/15 border border-emerald-700/50">
        <div class="absolute -right-8 -top-8 w-64 h-64 rounded-full bg-emerald-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-10 w-48 h-48 rounded-full bg-teal-300/15 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/15 text-emerald-200 backdrop-blur-md border border-white/20">
                    <i class="fas fa-location-dot text-emerald-300"></i>
                    <span>Kode Barang: {{ $aset->kode_barang ?? 'TANPA KODE' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    {{ $aset->lokasi }}
                </h1>
                <div class="flex flex-wrap items-center gap-3 text-xs text-emerald-100/90 font-medium">
                    <span class="bg-emerald-700/70 px-2.5 py-1 rounded-lg border border-emerald-500/40">
                        {{ $aset->nama_barang ?? 'Tanah Kas Desa' }}
                    </span>
                    <span>•</span>
                    <span>Peruntukan: <strong>{{ $aset->penggunaan ?? 'Belum Diisi' }}</strong></span>
                </div>
            </div>
            
            <div class="shrink-0 flex items-center gap-3">
                <button wire:click="exportPdf" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl font-black text-sm text-rose-950 bg-rose-200 hover:bg-rose-100 shadow-lg shadow-emerald-950/30 transition-all active:scale-95 cursor-pointer">
                    <i class="fas fa-file-pdf text-rose-800 text-base"></i>
                    <span>Export Dokumen PDF</span>
                </button>
                <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl font-black text-sm text-emerald-950 bg-emerald-300 hover:bg-emerald-200 shadow-lg shadow-emerald-950/30 transition-all active:scale-95 cursor-pointer">
                    <i class="fas fa-arrow-left text-emerald-900"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. KARTU METRIK PERSIL (4 KOTAK BERWARNA)  --}}
    {{-- ========================================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        {{-- Luas --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-emerald-100 hover:border-emerald-300 transition-all relative overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-teal-500 to-emerald-500 absolute top-0 inset-x-0"></div>
            <div class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">Dimensi Luas Fisik</div>
            <div class="flex items-baseline gap-1.5">
                <span class="text-3xl font-black text-slate-900">{{ number_format($aset->luas, 0, ',', '.') }}</span>
                <span class="text-xs font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md">m²</span>
            </div>
        </div>

        {{-- Nilai Perolehan --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-emerald-100 hover:border-emerald-300 transition-all relative overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-emerald-500 to-teal-600 absolute top-0 inset-x-0"></div>
            <div class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">Nilai Perolehan</div>
            <div class="text-2xl sm:text-3xl font-black text-emerald-700 font-mono">
                Rp {{ number_format($aset->harga_perolehan, 0, ',', '.') }}
            </div>
        </div>

        {{-- Status Hak --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-slate-200 hover:border-emerald-300 transition-all relative overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-slate-400 to-slate-600 absolute top-0 inset-x-0"></div>
            <div class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">Legalitas Sertifikat</div>
            <div class="text-lg font-black text-slate-900 truncate">{{ $aset->status_sertifikat }}</div>
            <div class="text-xs text-emerald-800 font-mono font-bold mt-1 truncate">{{ $aset->nomor_sertifikat ?? 'Nomor: -' }}</div>
        </div>

        {{-- Status Validasi --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-slate-200 hover:border-emerald-300 transition-all relative overflow-hidden">
            <div class="h-1.5 {{ $aset->status_validasi == 'Disetujui' ? 'bg-emerald-500' : 'bg-amber-500' }} absolute top-0 inset-x-0"></div>
            <div class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">Persetujuan Dokumen</div>
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-black
                    {{ $aset->status_validasi == 'Disetujui' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                    <i class="fas {{ $aset->status_validasi == 'Disetujui' ? 'fa-check-circle text-emerald-600' : 'fa-clock text-amber-600' }}"></i>
                    {{ $aset->status_validasi }}
                </span>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 3. PERSETUJUAN KEPALA DESA / CATATAN       --}}
    {{-- ========================================== --}}
    @if($aset->status_validasi == 'Diproses' && auth()->user()->role_id == 2)
        <div class="bg-gradient-to-r from-amber-50 via-amber-50/50 to-orange-50 border-2 border-amber-300 rounded-3xl p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-md shadow-amber-500/30">
                        <i class="fas fa-clipboard-check text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl text-amber-950 font-black mb-1">Persetujuan Otoritas Kepala Desa</h3>
                    <p class="text-sm text-amber-800 mb-5 font-medium">Data inventaris persil tanah ini diajukan oleh admin dan menunggu verifikasi Anda sebelum dicetak pada KIB A resmi.</p>
                    
                    <form wire:submit="prosesValidasi" class="space-y-4 bg-white/80 p-5 rounded-2xl border border-amber-200">
                        <div>
                            <label class="block text-xs font-bold text-amber-950 uppercase tracking-wider mb-1.5">Catatan / Alasan Revisi (Wajib jika ditolak)</label>
                            <textarea wire:model="catatan_validasi" class="w-full rounded-xl border border-amber-200 focus:ring-4 focus:ring-amber-500/15 focus:border-amber-500 bg-white p-3 text-sm transition" rows="2" placeholder="Tuliskan catatan perbaikan atau koreksi untuk operator..."></textarea>
                            @error('catatan_validasi') <span class="text-xs text-rose-600 mt-1 block font-bold"><i class="fas fa-circle-exclamation"></i> {{ $message }}</span> @enderror
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="button" wire:click="setujuiAset" class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 text-white font-black text-sm rounded-xl shadow-md shadow-emerald-700/20 transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fas fa-check-circle text-emerald-200"></i> Setujui & Sahkan Aset
                            </button>
                            <button type="submit" class="px-6 py-3 bg-white border-2 border-rose-300 text-rose-700 font-bold text-sm rounded-xl hover:bg-rose-50 transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fas fa-times-circle text-rose-600"></i> Tolak & Kembalikan ke Operator
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @elseif($aset->status_validasi == 'Ditolak')
        <div class="bg-rose-50 border-2 border-rose-300 rounded-3xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-start gap-5">
                <div class="w-12 h-12 bg-rose-600 text-white rounded-2xl flex items-center justify-center shrink-0 shadow-sm">
                    <i class="fas fa-triangle-exclamation text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg text-rose-950 font-black mb-1">Data Aset Perlu Direvisi</h3>
                    <div class="bg-white p-4 rounded-xl border border-rose-200 mt-2 mb-4">
                        <p class="text-[11px] font-bold text-rose-600 uppercase tracking-wider mb-1">Catatan Kepala Desa:</p>
                        <p class="text-sm text-slate-800 font-medium">"{{ $aset->catatan_validasi ?? 'Tidak ada catatan spesifik.' }}"</p>
                    </div>
                    @if(auth()->user()->role_id == 1)
                        <a href="{{ route('aset.edit', $aset->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 text-white text-xs font-black rounded-xl hover:bg-rose-700 shadow-md shadow-rose-600/20 transition">
                            <i class="fas fa-pen"></i> Revisi Data Aset Sekarang
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- ========================================== --}}
    {{-- 4. PETA LOKASI & DETAIL LEGALITAS          --}}
    {{-- ========================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kiri: Peta & Batas --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-emerald-100/90 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <i class="fas fa-map-location-dot text-emerald-600"></i>
                        <h3 class="font-extrabold text-slate-900 text-sm">Peta Spasial Persil Tanah</h3>
                    </div>
                    <span class="text-xs font-mono font-bold bg-emerald-50 text-emerald-800 px-2.5 py-1 rounded-lg border border-emerald-200">
                        {{ $aset->koordinat }}
                    </span>
                </div>
                <div id="mapDetail" class="h-80 w-full z-0 bg-slate-100"></div>
            </div>
            
            {{-- Batas Sempadan --}}
            <div class="bg-white rounded-3xl border border-emerald-100/90 shadow-sm p-6">
                <h3 class="font-extrabold text-slate-900 mb-4 flex items-center gap-2 text-sm">
                    <i class="fas fa-border-all text-emerald-600"></i> Batas Sempadan Lahan
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3.5 bg-slate-50/70 rounded-2xl border border-slate-200">
                        <span class="text-[10px] text-emerald-800 font-black uppercase block">Batas Utara</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $aset->batas_utara ?? '-' }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50/70 rounded-2xl border border-slate-200">
                        <span class="text-[10px] text-emerald-800 font-black uppercase block">Batas Timur</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $aset->batas_timur ?? '-' }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50/70 rounded-2xl border border-slate-200">
                        <span class="text-[10px] text-emerald-800 font-black uppercase block">Batas Selatan</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $aset->batas_selatan ?? '-' }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50/70 rounded-2xl border border-slate-200">
                        <span class="text-[10px] text-emerald-800 font-black uppercase block">Batas Barat</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $aset->batas_barat ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Detail Legalitas --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-emerald-100/90 shadow-sm p-6">
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-100 text-emerald-950 font-black text-sm">
                    <i class="fas fa-id-card-clip text-emerald-600"></i>
                    <span>Informasi Legalitas & Riwayat</span>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Nomor Register (NUP)</label>
                        <p class="text-slate-900 font-bold text-sm">{{ $aset->nup ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Jenis Bukti Perolehan</label>
                        <p class="text-slate-900 font-bold text-sm">{{ $aset->bukti_perolehan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Kondisi Fisik Lahan</label>
                        <p class="text-slate-900 font-bold text-sm">{{ $aset->kondisi ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Catatan Tambahan Warkah</label>
                        <p class="text-slate-700 text-xs bg-slate-50/80 p-3 rounded-xl border border-slate-200 mt-1 leading-relaxed">
                            {{ $aset->keterangan ?? 'Tidak ada catatan tambahan.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 5. PEMANFAATAN & KERJASAMA (FORM & TABEL)  --}}
    {{-- ========================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        {{-- KOLOM 1: FORM INPUT (Khusus Admin) --}}
        @if(Auth::user()->role_id == 1)
        <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden lg:col-span-1 sticky top-24">
            <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center gap-2">
                <i class="fas fa-handshake text-emerald-600"></i>
                <h3 class="font-extrabold text-slate-900 text-sm">Catat Pemanfaatan Tanah</h3>
            </div>
            
            <form wire:submit.prevent="simpanPemanfaatan" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Pihak Pemanfaat (Penyewa)</label>
                    <input type="text" wire:model="p_pihak_ketiga" class="w-full rounded-xl border border-slate-200 text-sm px-3.5 py-2 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition" placeholder="Nama perorangan / instansi">
                    @error('p_pihak_ketiga') <span class="text-rose-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Bentuk Kerjasama</label>
                    <select wire:model="p_bentuk_pemanfaatan" class="w-full rounded-xl border border-slate-200 text-sm px-3.5 py-2 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-medium cursor-pointer">
                        <option value="Sewa">Sewa</option>
                        <option value="Pinjam Pakai">Pinjam Pakai</option>
                        <option value="Bangun Guna Serah">Bangun Guna Serah</option>
                        <option value="Bangun Serah Guna">Bangun Serah Guna</option>
                        <option value="Kerjasama Pemanfaatan">Kerjasama Pemanfaatan</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Mulai</label>
                        <input type="date" wire:model="p_tanggal_mulai" class="w-full rounded-xl border border-slate-200 text-xs px-3 py-2 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Selesai</label>
                        <input type="date" wire:model="p_tanggal_selesai" class="w-full rounded-xl border border-slate-200 text-xs px-3 py-2 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-semibold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nilai Kontribusi (Rp)</label>
                    <input type="number" wire:model="p_nilai_kontribusi" class="w-full rounded-xl border border-slate-200 text-sm px-3.5 py-2 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-mono font-bold" placeholder="0">
                    @error('p_nilai_kontribusi') <span class="text-rose-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Status Pembayaran</label>
                    <select wire:model="p_status_pembayaran" class="w-full rounded-xl border border-slate-200 text-sm px-3.5 py-2 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition font-bold cursor-pointer">
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Upload Berkas Perjanjian</label>
                    <input type="file" wire:model="p_path_bukti" class="w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Catatan Pemanfaatan</label>
                    <textarea wire:model="p_keterangan" rows="2" class="w-full rounded-xl border border-slate-200 text-sm px-3.5 py-2 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 bg-slate-50/60 focus:bg-white transition"></textarea>
                </div>

                <button type="submit" wire:loading.attr="disabled" class="w-full py-3 bg-gradient-to-r from-emerald-600 via-emerald-700 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 text-white font-black text-xs rounded-xl shadow-md shadow-emerald-700/20 transition disabled:opacity-50 flex justify-center items-center gap-2 cursor-pointer">
                    <span wire:loading.remove><i class="fas fa-save"></i> Simpan Data Pemanfaatan</span>
                    <span wire:loading><i class="fas fa-circle-notch fa-spin"></i> Menyimpan...</span>
                </button>
            </form>
        </div>
        @endif

        {{-- KOLOM 2 & 3: TABEL RIWAYAT PEMANFAATAN --}}
        <div class="{{ Auth::user()->role_id == 1 ? 'lg:col-span-2' : 'lg:col-span-3' }}">
            <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center gap-2">
                    <i class="fas fa-history text-emerald-600"></i>
                    <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wide">Riwayat Sewa & Pemanfaatan Persil</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs font-black text-emerald-950 uppercase tracking-wider bg-emerald-900/[0.03] border-b border-emerald-100">
                            <tr>
                                <th class="px-6 py-4">Masa Berlaku</th>
                                <th class="px-6 py-4">Pihak Pemanfaat</th>
                                <th class="px-6 py-4">Bentuk / Kontribusi</th>
                                <th class="px-6 py-4">Keterangan / Berkas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($aset->pemanfaatan->sortByDesc('created_at') as $item)
                            <tr class="hover:bg-emerald-50/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</div>
                                    <div class="text-xs text-slate-500 flex items-center gap-1 mt-0.5 font-medium">
                                        <i class="fas fa-arrow-right text-[10px] text-emerald-600"></i> 
                                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-extrabold text-slate-900">
                                    {{ $item->pihak_ketiga }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-bold rounded-lg uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200 mb-1">
                                        {{ $item->bentuk_pemanfaatan }}
                                    </span>
                                    <div class="font-mono text-emerald-800 font-black">Rp {{ number_format($item->nilai_kontribusi, 0, ',', '.') }}</div>
                                    <div class="text-[10px] font-black uppercase tracking-wider mt-1 {{ $item->status_pembayaran == 'Lunas' ? 'text-emerald-800 bg-emerald-100 inline-block px-2 py-0.5 rounded-md border border-emerald-300' : 'text-rose-800 bg-rose-100 inline-block px-2 py-0.5 rounded-md border border-rose-300' }}">
                                        {{ $item->status_pembayaran }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs text-slate-600 max-w-[200px] leading-relaxed mb-2 font-medium">{{ $item->keterangan ?? '-' }}</div>
                                    @if($item->path_bukti)
                                        <a href="{{ asset('storage/'.$item->path_bukti) }}" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-xl text-xs font-bold transition border border-emerald-200">
                                            <i class="fas fa-paperclip"></i> Berkas Perjanjian
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-full flex items-center justify-center mb-3">
                                            <i class="fas fa-folder-open text-xl"></i>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-700">Belum Ada Riwayat Kerjasama</h3>
                                        <p class="text-xs text-slate-500 mt-0.5">Lahan belum pernah disewakan atau dikerjasamakan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Peta Spasial --}}
    <script>
        let detailMap = null;

        document.addEventListener('livewire:navigated', () => {
            setTimeout(initDetailMap, 100);
        });

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(initDetailMap, 100);
        });

        function initDetailMap() {
            const container = document.getElementById('mapDetail');
            if(!container) return;

            if (typeof window.L === 'undefined') {
                setTimeout(initDetailMap, 200);
                return;
            }

            const koordinat = "{{ $aset->koordinat }}";
            if(!koordinat) return;

            const parts = koordinat.split(',');
            if(parts.length !== 2) return;

            const lat = parseFloat(parts[0]);
            const lng = parseFloat(parts[1]);

            if (detailMap !== null) {
                detailMap.remove();
                detailMap = null;
            } else if (container._leaflet_id) {
                container._leaflet_id = null;
                container.innerHTML = "";
            }

            detailMap = L.map('mapDetail', { zoomControl: true, scrollWheelZoom: false }).setView([lat, lng], 16);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(detailMap);
            
            L.marker([lat, lng]).addTo(detailMap)
                .bindPopup("<b>{{ addslashes($aset->lokasi) }}</b><br>Luas: {{ $aset->luas }} m²")
                .openPopup();
            
            setTimeout(() => { if(detailMap) detailMap.invalidateSize(); }, 300);
        }
    </script>
</div>