<div>
    <div class="content-header">
        <h1>Dashboard</h1>
        @if(auth()->user()->role_id == 1)
            <a href="{{ route('aset.tambah') }}" wire:navigate class="btn btn-primary" title="Tambah Data Tanah"><i class="fas fa-plus"></i> Tambah Data Tanah</a>
        @endif
    </div>

    <div class="stat-container">
        <div class="stat-box">
            <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="stat-content">
                <span class="stat-label">Total Aset Tanah</span>
                <span class="stat-value">{{ number_format($totalAset, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon"><i class="fas fa-ruler-combined"></i></div>
            <div class="stat-content">
                <span class="stat-label">Total Luas Tanah</span>
                <span class="stat-value">{{ number_format($totalLuas, 0, ',', '.') }} m²</span>
            </div>
        </div>
        <div class="stat-box status-diproses">
            <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
            <div class="stat-content">
                <span class="stat-label">Menunggu Validasi</span>
                <span class="stat-value">{{ number_format($asetDiproses, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-box status-disetujui">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-content">
                <span class="stat-label">Aset Disetujui</span>
                <span class="stat-value">{{ number_format($asetDisetujui, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-box status-ditolak">
            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="stat-content">
                <span class="stat-label">Aset Ditolak</span>
                <span class="stat-value">{{ number_format($asetDitolak, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h4>Daftar Aset Tanah Kas Desa</h4>
            <div class="card-tools">
                <select wire:model.live="filterStatus" class="form-control" style="width: 150px; margin-right: 10px;">
                    <option value="">Semua Status</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
                <input type="text" wire:model.live.debounce.300ms="searchTerm" class="form-control" placeholder="Cari aset...">
            </div>
        </div>
        <div class="card-body">
            
            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="notification success">{{ session('success') }}</div>
            @endif
             @if (session('error'))
                <div class="notification error">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Asal Perolehan</th>
                            <th>Luas (m²)</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($aset_tanah as $aset)
                            <tr wire:key="{{ $aset->id }}">
                                <td>{{ $aset->kode_barang ?? '-' }}</td>
                                <td>{{ $aset->asal_perolehan }}</td>
                                <td>{{ number_format($aset->luas, 2, ',', '.') }}</td>
                                <td>{{ Str::limit($aset->lokasi, 40) }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($aset->status_validasi) }}">
                                        {{ $aset->status_validasi }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        {{-- Logika Tombol Validasi untuk Kades (Role ID 2) --}}
                                        @if (auth()->user()->role_id == 2 && $aset->status_validasi == 'Diproses')
                                            <button wire:click="openValidasiModal({{ $aset->id }}, 'Disetujui')" class="btn-icon success" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button wire:click="openValidasiModal({{ $aset->id }}, 'Ditolak')" class="btn-icon danger" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        
                                        {{-- Tombol untuk semua role --}}
                                        <a href="{{ route('aset.detail', ['aset' => $aset->id]) }}" wire:navigate class="btn-icon info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Logika Tombol Edit & Arsip untuk Petugas (Role ID 1) --}}
                                        @if (auth()->user()->role_id == 1)
                                            <a href="{{ route('aset.form', ['aset' => $aset->id]) }}" wire:navigate class="btn-icon warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button wire:click="arsipkan({{ $aset->id }})" 
                                                    wire:confirm="Anda yakin ingin mengarsipkan data ini?"
                                                    class="btn-icon danger" title="Arsipkan">
                                                <i class="fas fa-archive"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    @if ($searchTerm)
                                        Tidak ada aset yang ditemukan untuk pencarian "{{ $searchTerm }}".
                                    @else
                                        Belum ada data aset tanah.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                {{ $aset_tanah->links() }}
            </div>
        </div>
    </div>

    {{-- [UPGRADE] Modal Validasi --}}
    @if ($showValidasiModal)
        <div class="modal-backdrop show"></div>
        <div class="modal show" tabindex="-1" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit="prosesValidasi">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Konfirmasi Validasi Aset ({{ $validasiStatus }})
                            </h5>
                            <button type="button" wire:click="closeValidasiModal" class="close-button">&times;</button>
                        </div>
                        <div class="modal-body">
                            {{-- [BARU] Info Aset di Modal --}}
                            @if ($infoAsetModal)
                                <div class="modal-asset-info">
                                    <p><strong>Kode Barang:</strong> {{ $infoAsetModal['kode_barang'] ?? '-' }}</p>
                                    <p><strong>Asal:</strong> {{ $infoAsetModal['asal_perolehan'] }}</p>
                                    <p><strong>Lokasi:</strong> {{ Str::limit($infoAsetModal['lokasi'], 50) }}</p>
                                </div>
                            @endif
                        
                            <p>Anda akan memvalidasi aset ini dengan status: 
                                <strong class="status-{{ strtolower($validasiStatus) }}">{{ $validasiStatus }}</strong>
                            </p>
                            
                            <div class="form-group">
                                <label for="validasiCatatan">Catatan Validasi (Opsional)</label>
                                <textarea id="validasiCatatan" wire:model="validasiCatatan" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeValidasiModal" class="btn btn-secondary">Batal</Batal>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    Konfirmasi
                                </span>
                                <span wire:loading>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>