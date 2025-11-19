<div>
    <div class="content-header">
        <h1>Detail Aset: {{ $aset->kode_barang ?? 'Tanpa Kode' }}</h1>
        <div>
            <button wire:click="downloadDetailPdf" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Unduh PDF
            </button>
            <a href="{{ route('dashboard') }}" wire:navigate class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('success_validasi'))
        <div class="notification success">{{ session('success_validasi') }}</div>
    @endif
    @if (session('success_dokumen'))
        <div class="notification success">{{ session('success_dokumen') }}</div>
    @endif
    @if (session('success_pemanfaatan'))
        <div class="notification success">{{ session('success_pemanfaatan') }}</div>
    @endif
    @if (session('error'))
        <div class="notification error">{{ session('error') }}</div>
    @endif

    {{-- [BARU] AREA VALIDASI KHUSUS KADES (ROLE 2) --}}
    @if(auth()->user()->role_id == 2 && $aset->status_validasi == 'Diproses')
        <div class="card mb-4" style="border-left: 5px solid #f39c12; background-color: #fffcf5; margin-bottom: 2rem;">
            <div class="card-body" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h4 style="margin: 0; color: #d35400;"> <i class="fas fa-exclamation-circle"></i> Menunggu Validasi Anda</h4>
                    <p style="margin: 0; color: #7f8c8d;">Silakan cek data di bawah, lalu tentukan status validasi.</p>
                </div>
                <div class="action-buttons">
                    <button wire:click="openValidasiModal('Disetujui')" class="btn btn-success">
                        <i class="fas fa-check"></i> Setujui Data
                    </button>
                    <button wire:click="openValidasiModal('Ditolak')" class="btn btn-danger">
                        <i class="fas fa-times"></i> Tolak Data
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="grid-2-col" style="grid-template-columns: 2fr 1fr; gap: 2rem;">
        
        {{-- KOLOM KIRI: Detail Data --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Tanah</h4>
                    <span class="status-badge status-{{ strtolower($aset->status_validasi) }}">
                        {{ $aset->status_validasi }}
                    </span>
                </div>
                <div class="card-body">
                    <table class="table-detail">
                        {{-- Tampilkan Catatan jika Ditolak --}}
                        @if($aset->status_validasi == 'Ditolak' && $aset->catatan_validasi)
                            <tr>
                                <th style="color: red;">Alasan Penolakan</th>
                                <td style="color: red; font-weight: bold;">{{ $aset->catatan_validasi }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th width="30%">Asal Perolehan</th>
                            <td>{{ $aset->asal_perolehan }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Perolehan</th>
                            <td>{{ $aset->tanggal_perolehan ? date('d-m-Y', strtotime($aset->tanggal_perolehan)) : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Luas</th>
                            <td>{{ number_format($aset->luas, 2, ',', '.') }} m²</td>
                        </tr>
                        <tr>
                            <th>Harga Perolehan</th>
                            <td>Rp {{ number_format($aset->harga_perolehan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $aset->lokasi }}</td>
                        </tr>
                        <tr>
                            <th>Koordinat</th>
                            <td>
                                {{ $aset->koordinat ?? '-' }}
                                @if($aset->koordinat)
                                    <a href="https://www.google.com/maps?q={{ $aset->koordinat }}" target="_blank" style="margin-left: 10px; font-size: 0.8rem;">
                                        <i class="fas fa-external-link-alt"></i> Lihat Peta
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Kondisi</th>
                            <td>{{ $aset->kondisi }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $aset->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- TABEL RIWAYAT PEMANFAATAN --}}
            <div class="card" style="margin-top: 2rem;">
                <div class="card-header">
                    <h4>Riwayat Pemanfaatan / Sewa</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pihak Ketiga</th>
                                    <th>Bentuk</th>
                                    <th>Periode</th>
                                    <th>Nilai (Rp)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aset->pemanfaatan as $manfaat)
                                    <tr>
                                        <td>{{ $manfaat->pihak_ketiga }}</td>
                                        <td>{{ $manfaat->bentuk_pemanfaatan }}</td>
                                        <td>
                                            {{ date('d/m/y', strtotime($manfaat->tanggal_mulai)) }} - 
                                            {{ date('d/m/y', strtotime($manfaat->tanggal_selesai)) }}
                                        </td>
                                        <td>{{ number_format($manfaat->nilai_kontribusi, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge {{ $manfaat->status_pembayaran == 'Lunas' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $manfaat->status_pembayaran }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada riwayat pemanfaatan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <hr>
                    
                    {{-- [LOGIKA] FORM HANYA UNTUK ADMIN (Role 1) --}}
                    @if(auth()->user()->role_id == 1)
                        <h5>Catat Pemanfaatan Baru</h5>
                        <form wire:submit="simpanPemanfaatan" class="form-mini">
                            <div class="grid-2-col">
                                <div class="form-group">
                                    <label>Pihak Ketiga</label>
                                    <input type="text" wire:model="p_pihak_ketiga" class="form-control">
                                    @error('p_pihak_ketiga') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="form-group">
                                    <label>Bentuk Pemanfaatan</label>
                                    <select wire:model="p_bentuk_pemanfaatan" class="form-control">
                                        <option value="Sewa">Sewa</option>
                                        <option value="Pinjam Pakai">Pinjam Pakai</option>
                                        <option value="BGS">Bangun Guna Serah</option>
                                        <option value="BSG">Bangun Serah Guna</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" wire:model="p_tanggal_mulai" class="form-control">
                                    @error('p_tanggal_mulai') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" wire:model="p_tanggal_selesai" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Nilai Kontribusi (Rp)</label>
                                    <input type="number" wire:model="p_nilai_kontribusi" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Status Bayar</label>
                                    <select wire:model="p_status_pembayaran" class="form-control">
                                        <option value="Belum Lunas">Belum Lunas</option>
                                        <option value="Lunas">Lunas</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Simpan Riwayat</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Dokumen --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <h4>Dokumen Pendukung</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($dokumen_pendukung as $doc)
                            <li class="list-item">
                                <div class="doc-info">
                                    <strong>{{ $doc->nama_dokumen }}</strong><br>
                                    <small>{{ $doc->kategori }} • {{ date('d M Y', strtotime($doc->created_at)) }}</small>
                                </div>
                                <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="btn-icon info">
                                    <i class="fas fa-download"></i>
                                </a>
                            </li>
                        @empty
                            <li class="text-muted">Belum ada dokumen diunggah.</li>
                        @endforelse
                    </ul>

                    <hr>

                    {{-- [LOGIKA] FORM HANYA UNTUK ADMIN (Role 1) --}}
                    @if(auth()->user()->role_id == 1)
                        <h5>Upload Dokumen</h5>
                        <form wire:submit="simpanDokumen">
                            <div class="form-group">
                                <label>Nama Dokumen</label>
                                <input type="text" wire:model="nama_dokumen" class="form-control">
                                @error('nama_dokumen') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select wire:model="kategori_dokumen" class="form-control">
                                    <option value="Sertifikat">Sertifikat</option>
                                    <option value="Surat Perjanjian">Surat Perjanjian</option>
                                    <option value="Foto">Foto Fisik</option>
                                    <option value="Lain-lain">Lain-lain</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>File (PDF Only)</label>
                                <input type="file" wire:model="fileUpload" class="form-control" accept=".pdf">
                                @error('fileUpload') <small class="text-danger">{{ $message }}</small> @enderror
                                <div wire:loading wire:target="fileUpload" class="text-info">Mengupload...</div>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm btn-block">Upload</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- [BARU] MODAL VALIDASI --}}
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
                            <p>Anda yakin ingin <strong>{{ $validasiStatus == 'Disetujui' ? 'MENYETUJUI' : 'MENOLAK' }}</strong> aset ini?</p>
                            
                            <div class="form-group">
                                <label for="validasiCatatan">Catatan Validasi (Wajib jika Ditolak)</label>
                                <textarea id="validasiCatatan" wire:model="validasiCatatan" class="form-control" rows="3" placeholder="Berikan catatan atau alasan..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeValidasiModal" class="btn btn-secondary">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                Konfirmasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>