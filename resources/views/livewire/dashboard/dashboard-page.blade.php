<div class="space-y-6 relative">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Dashboard Aset</h1>
            <p class="text-sm text-slate-500 mt-1">Monitor status persetujuan dan kelola tanah desa.</p>
        </div>
        @if(auth()->user()->role_id == 1)
            <a href="{{ route('aset.tambah') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 shadow-sm shadow-blue-500/30 transition-all hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i> Tambah Tanah
            </a>
        @endif
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400"></i>
                </div>
                <input type="text" 
                       wire:model.live.debounce.300ms="searchTerm" 
                       class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow" 
                       placeholder="Cari kode, asal, atau lokasi...">
            </div>
            <div class="sm:w-48">
                <select wire:model.live="filterStatus" class="block w-full py-2 pl-3 pr-10 border border-slate-300 bg-white rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Semua Status</option>
                    <option value="Diproses">⏳ Diproses</option>
                    <option value="Disetujui">✅ Disetujui</option>
                    <option value="Ditolak">❌ Ditolak</option>
                </select>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-emerald-700 bg-emerald-50 rounded-lg border border-emerald-200 flex items-center shadow-sm animate-in fade-in slide-in-from-top-2" role="alert">
            <i class="fas fa-check-circle mr-2 text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    
    @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-50 rounded-lg border border-red-200 flex items-center shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle mr-2 text-lg"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode / Asal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Lokasi & Luas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Penggunaan</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($aset_tanah as $aset)
                    <tr wire:key="aset-{{ $aset->id }}" class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $loop->iteration + ($aset_tanah->firstItem() - 1) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">{{ $aset->kode_barang ?? '-' }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $aset->asal_perolehan }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-900 truncate max-w-xs" title="{{ $aset->lokasi }}">{{ Str::limit($aset->lokasi, 30) }}</div>
                            <div class="text-xs font-mono text-slate-500 mt-0.5">{{ number_format($aset->luas, 2, ',', '.') }} m²</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $aset->penggunaan ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $statusClasses = match($aset->status_validasi) {
                                    'Disetujui' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'Ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                    default => 'bg-amber-100 text-amber-700 border-amber-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusClasses }}">
                                {{ $aset->status_validasi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('aset.detail', ['aset' => $aset->id]) }}" wire:navigate class="p-1 text-slate-400 hover:text-blue-600 transition-colors" title="Detail">
                                    <i class="fas fa-eye text-lg"></i>
                                </a>

                                @if(auth()->user()->role_id == 1)
                                    <a href="{{ route('aset.edit', ['aset' => $aset->id]) }}" wire:navigate class="p-1 text-slate-400 hover:text-amber-500 transition-colors" title="Edit">
                                        <i class="fas fa-edit text-lg"></i>
                                    </a>
                                    <button 
                                        wire:click="arsipkan({{ $aset->id }})" 
                                        wire:confirm="Anda yakin ingin mengarsipkan data ini?"
                                        class="p-1 text-slate-400 hover:text-red-600 transition-colors" 
                                        title="Arsip">
                                        <i class="fas fa-archive text-lg"></i>
                                    </button>
                                @endif

                                @if(in_array(auth()->user()->role_id, [2]) && $aset->status_validasi == 'Diproses')
                                    <button 
                                        wire:click="openValidasiModal({{ $aset->id }}, 'Disetujui')" 
                                        class="p-1 text-emerald-400 hover:text-emerald-600 transition-transform hover:scale-110" 
                                        title="Setujui">
                                        <i class="fas fa-check-circle text-xl"></i>
                                    </button>
                                    <button 
                                        wire:click="openValidasiModal({{ $aset->id }}, 'Ditolak')" 
                                        class="p-1 text-red-400 hover:text-red-600 transition-transform hover:scale-110" 
                                        title="Tolak">
                                        <i class="fas fa-times-circle text-xl"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            <i class="fas fa-folder-open text-4xl text-slate-300 mb-3 block"></i>
                            Data tidak ditemukan atau belum ada aset.
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

    @if($showValidasiModal)
    <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="closeValidasiModal"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200">
                
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full {{ $validasiStatus == 'Disetujui' ? 'bg-emerald-100' : 'bg-red-100' }} sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas {{ $validasiStatus == 'Disetujui' ? 'fa-check text-emerald-600' : 'fa-times text-red-600' }}"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">
                                Konfirmasi {{ $validasiStatus == 'Disetujui' ? 'Persetujuan' : 'Penolakan' }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500 mb-4">
                                    Apakah Anda yakin ingin <strong>{{ $validasiStatus == 'Disetujui' ? 'MENYETUJUI' : 'MENOLAK' }}</strong> validasi aset ini? Tindakan ini akan tercatat di sistem.
                                </p>
                                
                                <label class="block text-sm font-bold text-slate-700 mb-1">Catatan Validasi (Opsional)</label>
                                <textarea 
                                    wire:model="validasiCatatan" 
                                    class="w-full rounded-lg border-slate-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                    rows="3" 
                                    placeholder="Contoh: Dokumen lengkap, fisik sesuai..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100 gap-2">
                    <button 
                        wire:click="prosesValidasi" 
                        type="button" 
                        wire:loading.attr="disabled"
                        class="w-full inline-flex justify-center items-center rounded-xl border border-transparent px-4 py-2 text-base font-bold text-white shadow-sm {{ $validasiStatus == 'Disetujui' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-red-600 hover:bg-red-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm transition">
                        <span wire:loading.remove wire:target="prosesValidasi">Ya, {{ $validasiStatus }}</span>
                        <span wire:loading wire:target="prosesValidasi"><i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...</span>
                    </button>
                    
                    <button 
                        wire:click="closeValidasiModal" 
                        type="button" 
                        class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>