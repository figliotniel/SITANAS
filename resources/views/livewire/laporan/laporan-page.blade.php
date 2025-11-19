<div>
    <div class="content-header">
        <h1>Laporan Aset Desa</h1>
    </div>

    {{-- Notifikasi --}}
    @if (session('error'))
        <div class="notification error" style="margin-bottom: 1rem;">{{ session('error') }}</div>
    @endif

    <div class="card">
        {{-- AREA FILTER & PENCARIAN --}}
        <div class="card-header" style="display: block;">
            <div class="filter-container" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                
                {{-- Bagian Kiri: Input Filter --}}
                <div style="display: flex; gap: 10px; flex: 1;">
                    
                    {{-- 1. Filter Status (Sesuai Permintaan) --}}
                    <select wire:model.live="filterStatus" class="form-control" style="width: 180px;">
                        <option value="">Semua Status</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Diproses">Diproses (Menunggu)</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>

                    {{-- 2. Filter Kondisi --}}
                    <select wire:model.live="filterKondisi" class="form-control" style="width: 150px;">
                        <option value="">Semua Kondisi</option>
                        <option value="Baik">Baik</option>
                        <option value="Kurang Baik">Kurang Baik</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>

                    {{-- 3. Pencarian --}}
                    <input type="text" wire:model.live.debounce.300ms="searchTerm" class="form-control" placeholder="Cari lokasi, kode, atau asal..." style="width: 250px;">
                </div>

                {{-- Bagian Kanan: Tombol Download --}}
                <div>
                    <button wire:click="downloadPdf" class="btn btn-danger" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="downloadPdf">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </span>
                        <span wire:loading wire:target="downloadPdf">
                            <i class="fas fa-spinner fa-spin"></i> Memproses...
                        </span>
                    </button>
                </div>

            </div>
        </div>

        <div class="card-body">
            
            {{-- Info Filter Aktif --}}
            <p class="text-muted mb-2">
                Menampilkan <strong>{{ $total_aset }}</strong> data 
                @if($filterStatus) dengan status <strong>{{ $filterStatus }}</strong> @endif
                @if($filterKondisi) kondisi <strong>{{ $filterKondisi }}</strong> @endif
            </p>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Asal Perolehan</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                            <th>Tanggal Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($aset_tanah as $index => $aset)
                            <tr>
                                {{-- Penomoran halaman yang benar --}}
                                <td>{{ $aset_tanah->firstItem() + $index }}</td>
                                <td>{{ $aset->kode_barang }}</td>
                                <td>{{ $aset->asal_perolehan }}</td>
                                <td>{{ Str::limit($aset->lokasi, 40) }}</td>
                                <td>{{ $aset->kondisi }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($aset->status_validasi) }}">
                                        {{ $aset->status_validasi }}
                                    </span>
                                </td>
                                <td>{{ date('d/m/Y', strtotime($aset->created_at)) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div style="color: #6c757d;">
                                        <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 10px;"></i><br>
                                        Tidak ada data yang sesuai dengan filter Anda.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-container mt-3">
                {{ $aset_tanah->links() }}
            </div>
        </div>
    </div>
</div>