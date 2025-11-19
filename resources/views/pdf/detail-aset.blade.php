<!DOCTYPE html>
<html>
<head>
    <title>Detail Aset - {{ $aset->kode_barang }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16pt; }
        .header p { margin: 0; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-size: 10pt; }
        .detail-list li { margin-bottom: 5px; }
        h4 { margin-top: 20px; border-bottom: 1px solid #ddd; padding-bottom: 5px; font-size: 12pt; }
        .status-validasi { font-weight: bold; padding: 2px 5px; border-radius: 3px; display: inline-block; }
        .status-diproses { background-color: #ffc107; color: #333; }
        .status-disetujui { background-color: #28a745; color: white; }
        .status-ditolak { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DETAIL ASET TANAH KAS DESA</h1>
        <p>Kode Barang: {{ $aset->kode_barang ?? '-' }}</p>
    </div>

    <h4>Informasi Utama</h4>
    <table>
        <tr>
            <th>Kode Barang</th><td>{{ $aset->kode_barang ?? '-' }}</td>
            <th>NUP</th><td>{{ $aset->nup ?? '-' }}</td>
        </tr>
        <tr>
            <th>Asal Perolehan</th><td>{{ $aset->asal_perolehan ?? '-' }}</td>
            <th>Tgl. Perolehan</th><td>{{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d-m-Y') : '-' }}</td>
        </tr>
        <tr>
            <th>Harga Perolehan</th><td>Rp{{ number_format($aset->harga_perolehan, 2, ',', '.') }}</td>
            <th>Bukti Perolehan</th><td>{{ $aset->bukti_perolehan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Luas (m²)</th><td>{{ number_format($aset->luas, 2, ',', '.') }}</td>
            <th>Kondisi</th><td>{{ $aset->kondisi ?? '-' }}</td>
        </tr>
    </table>

    <h4>Legalitas dan Lokasi</h4>
    <table>
        <tr>
            <th>Nomor Sertifikat</th><td>{{ $aset->nomor_sertifikat ?? '-' }}</td>
            <th>Tanggal Sertifikat</th><td>{{ $aset->tanggal_sertifikat ? \Carbon\Carbon::parse($aset->tanggal_sertifikat)->format('d-m-Y') : '-' }}</td>
        </tr>
        <tr>
            <th>Status Sertifikat</th><td>{{ $aset->status_sertifikat ?? '-' }}</td>
            <th>Penggunaan</th><td>{{ $aset->penggunaan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Lokasi</th><td colspan="3">{{ $aset->lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Koordinat</th><td colspan="3">{{ $aset->koordinat ?? '-' }}</td>
        </tr>
    </table>

    <h4>Batas-Batas Tanah</h4>
    <table>
        <tr>
            <th>Utara</th><td>{{ $aset->batas_utara ?? '-' }}</td>
            <th>Timur</th><td>{{ $aset->batas_timur ?? '-' }}</td>
        </tr>
        <tr>
            <th>Selatan</th><td>{{ $aset->batas_selatan ?? '-' }}</td>
            <th>Barat</th><td>{{ $aset->batas_barat ?? '-' }}</td>
        </tr>
    </table>
    
    <h4>Status dan Keterangan</h4>
    <table>
        <tr>
            <th>Status Validasi</th>
            <td>
                <span class="status-validasi status-{{ strtolower($aset->status_validasi) }}">
                    {{ $aset->status_validasi }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Diinput Oleh</th>
            <td>{{ $aset->diinput_oleh_user->nama_lengkap ?? 'N/A' }}</td>
        </tr>
        @if ($aset->divalidasi_oleh)
        <tr>
            <th>Divalidasi Oleh</th>
            <td>{{ $aset->divalidasi_oleh_user->nama_lengkap ?? 'N/A' }} pada {{ $aset->updated_at->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Catatan Validasi</th>
            <td>{{ $aset->catatan_validasi ?? '-' }}</td>
        </tr>
        @endif
        <tr>
            <th>Keterangan</th>
            <td colspan="3">{{ $aset->keterangan ?? '-' }}</td>
        </tr>
    </table>
    
</body>
</html>