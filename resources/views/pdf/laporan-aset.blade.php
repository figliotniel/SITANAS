<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aset Tanah Kas Desa</title>
    <style>
        /* Gaya dasar untuk PDF Laporan */
        body { font-family: sans-serif; font-size: 8pt; }
        .header { text-align: center; margin-bottom: 15px; }
        .header h1 { margin: 0; font-size: 14pt; }
        .header p { margin: 0; font-size: 9pt; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; font-size: 8pt; }
        td { font-size: 7.5pt; }
        .status { padding: 2px 4px; border-radius: 3px; font-weight: bold; }
        .diproses { background-color: #ffc107; }
        .disetujui { background-color: #28a745; color: white; }
        .ditolak { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN REKAPITULASI ASET TANAH KAS DESA</h1>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Asal Perolehan</th>
                <th>Tgl. Perolehan</th>
                <th>Harga Perolehan (Rp)</th>
                <th>Luas (m²)</th>
                <th>Lokasi</th>
                <th>Penggunaan</th>
                <th>Kondisi</th>
                <th>Status Validasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aset_tanah as $aset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $aset->kode_barang ?? '-' }}</td>
                <td>{{ $aset->asal_perolehan }}</td>
                <td>{{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d-m-Y') : '-' }}</td>
                <td>{{ number_format($aset->harga_perolehan, 0, ',', '.') }}</td>
                <td>{{ number_format($aset->luas, 2, ',', '.') }}</td>
                <td>{{ $aset->lokasi ?? '-' }}</td>
                <td>{{ $aset->penggunaan ?? '-' }}</td>
                <td>{{ $aset->kondisi ?? '-' }}</td>
                <td>
                    <span class="status {{ strtolower($aset->status_validasi) }}">
                        {{ $aset->status_validasi }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>