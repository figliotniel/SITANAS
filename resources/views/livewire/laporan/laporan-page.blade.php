<div>
    <div class="content-header">
        <h1>Laporan Aset Desa</h1>
    </div>

    {{-- Tampilkan pesan error jika download gagal --}}
    @if (session()->has('error'))
        <div style="margin-top: 1rem; color: var(--danger-color); padding: 10px; border: 1px solid var(--danger-color); background-color: #ffe0e0; border-radius: 4px;">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Card untuk Download PDF --}}
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h4><i class="fas fa-book"></i> Opsi Laporan PDF</h4>
            {{-- Tombol PDF yang memanggil method di Livewire component --}}
            <button wire:click="exportPdf" class="btn btn-primary">
                <i class="fas fa-download"></i> Download Laporan PDF
            </button>
        </div>
        <div class="card-body">
            <p>Klik tombol di atas untuk mengunduh Laporan Buku Inventaris Aset Desa (Bidang Tanah) dalam format PDF. Laporan ini akan mencakup data aset berdasarkan filter yang Anda pilih di bawah.</p>
            
            {{-- Indikator loading saat PDF dibuat --}}
            <div wire:loading wire:target="exportPdf" style="margin-top: 1rem; color: var(--primary-color);">
                <i class="fas fa-spinner fa-spin"></i> Mohon tunggu, sedang membuat PDF...
            </div>
        </div>
    </div>


    {{-- Card untuk Daftar Aset dan Filter (Tampilan Web) --}}
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h4><i class="fas fa-list"></i> Daftar Aset (Filter Web)</h4>
        </div>
        <div class="card-body">
            
            <div class="filter-controls" style="display: flex; gap: 15px; margin-bottom: 1.5rem;">
                {{-- Filter Pencarian --}}
                <input type="text" 
                       wire:model.live.debounce.300ms="searchTerm" 
                       class="form-control" 
                       placeholder="Cari kode, asal, atau lokasi...">
                
                {{-- Filter Status --}}
                <select wire:model.live="filterStatus" class="form-control" style="max-width: 200px;">
                    <option value="Disetujui">Disetujui</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Ditolak">Ditolak</option>
                </select>

                {{-- Pilihan Per Page --}}
                <select wire:model.live="perPage" class="form-control" style="max-width: 100px;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            {{-- Cek apakah variabel $aset_tanah ada isinya (DARI KOMPONEN PHP) --}}
            @if($aset_tanah->isEmpty())
                {{-- Tampilkan pesan jika tidak ada data --}}
                <div class="text-center" style="padding: 2rem; background-color: #f9f9f9; border-radius: 8px;">
                    <i class="fas fa-folder-open" style="font-size: 2rem; color: #888;"></i>
                    <p style="margin-top: 1rem; color: #555;">Data aset dengan filter saat ini tidak ditemukan.</p>
                </div>
            @else
                {{-- Jika ada data, tampilkan tabel --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead style="background-color: #f4f6f9;">
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Asal Perolehan</th>
                                <th>Luas (m²)</th>
                                <th>Lokasi</th>
                                <th>Penggunaan</th>
                                <th style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop data aset. Menggunakan $aset_tanah dari komponen PHP --}}
                            @foreach($aset_tanah as $aset)
                                <tr>
                                    {{-- Menggunakan $aset_tanah->firstItem() untuk menghitung nomor urut yang benar --}}
                                    <td>{{ $loop->iteration + ($aset_tanah->firstItem() - 1) }}</td>
                                    <td>{{ $aset->kode_barang ?? '-' }}</td>
                                    <td>{{ $aset->asal_perolehan }}</td>
                                    <td>{{ number_format($aset->luas, 2, ',', '.') }}</td>
                                    <td>{{ Str::limit($aset->lokasi, 50) }}</td>
                                    <td>{{ $aset->penggunaan ?? '-' }}</td>
                                    <td>
                                        {{-- Berikan link ke halaman detail aset --}}
                                        <a href="{{ route('aset.detail', $aset->id) }}" wire:navigate class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Paginasi --}}
                <div style="margin-top: 1.5rem;">
                    {{ $aset_tanah->links() }}
                    <span style="font-size: 0.9em; float: right; margin-top: 5px;">
                        Menampilkan {{ $aset_tanah->firstItem() }} hingga {{ $aset_tanah->lastItem() }} dari {{ $aset_tanah->total() }} total aset (Filter: {{ $filterStatus }})
                    </span>
                </div>
            @endif
        </div>
    </div>
</div>